<?php

/*
This file is part of SeAT

Copyright (C) 2015 to 2020  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace H4zz4rdDev\Seat\SeatBuyback\Services;

use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsServiceException;
use H4zz4rdDev\Seat\SeatBuyback\Factories\PriceProviderFactory;
use H4zz4rdDev\Seat\SeatBuyback\Helpers\PriceCalculationHelper;
use H4zz4rdDev\Seat\SeatBuyback\Models\BuybackPriceData;
use H4zz4rdDev\Seat\SeatBuyback\Provider\IPriceProvider;
use Illuminate\Support\Facades\DB;
use Seat\Eveapi\Models\Sde\InvType;

/**
 * Class ItemService
 */
class ItemService
{
    /**
     * @var IPriceProvider
     */
    private $priceProvider;

    /**
     * @param PriceProviderFactory $priceProviderFactory
     * @throws SettingsServiceException
     */
    public function __construct(PriceProviderFactory $priceProviderFactory)
    {
        $this->priceProvider = $priceProviderFactory->getPriceProvider();
    }

    /**
     * @param string $item_string
     * @return array|null
     */
    public function parseEveItemData(string $item_string): ?array
    {
        if (empty($item_string)) {
            return null;
        }

        $parsedRawData = $this->parseRawData($item_string);

        foreach ($parsedRawData as $key => $item) {
            $priceData = $this->priceProvider->getItemPrice($item["typeID"]);

            if($priceData == null) {
                return null;
            }

            $parsedRawData[$key]["price"] = $priceData->getItemPrice();
            $parsedRawData[$key]["sum"] = PriceCalculationHelper::calculateItemPrice($item["typeID"],
                $parsedRawData[$key]["quantity"], $priceData);
        }

        return $this->categorizeItems($parsedRawData);
    }

    /**
     * @param array $itemData
     * @return array|null
     */
    private function categorizeItems(array $itemData): ?array
    {
        $parsedItems = [];
        foreach ($itemData as $key => $item) {

            $result = DB::table('invTypes as it')
                ->join('invGroups as ig', 'it.groupID', '=', 'ig.GroupID')
                ->rightJoin('buyback_market_config as bmc', 'it.typeID', '=', 'bmc.typeId')
                ->select(
                    'it.typeID as typeID',
                    'it.typeName as typeName',
                    'it.description as description',
                    'ig.GroupName as groupName',
                    'ig.GroupID as groupID',
                    'bmc.percentage',
                    'bmc.marketOperationType'
                )
                ->where('it.typeName', '=', $key)
                ->first();

            if (empty($result)) {

                $parsedItems["ignored"][] = [
                    'ItemId' => $item["typeID"],
                    'ItemName' => $item["name"],
                    'ItemQuantity' => $item["quantity"]
                ];

                continue;
            }

            if (!array_key_exists($result->groupID, $parsedItems)) {

                $parsedItems["parsed"][$key]["typeId"] = $item["typeID"];
                $parsedItems["parsed"][$key]["typeName"] = $item["name"];
                $parsedItems["parsed"][$key]["typeQuantity"] = $item["quantity"];
                $parsedItems["parsed"][$key]["typeSum"] = $item["sum"];
                $parsedItems["parsed"][$key]["groupId"] = $result->groupID;
                $parsedItems["parsed"][$key]["marketGroupName"] = $result->groupName;

                $parsedItems["parsed"][$key]["marketConfig"] = [
                    'percentage' => $result->percentage != null ? $result->percentage : 0,
                    'marketOperationType' => $result->marketOperationType != null ? $result->marketOperationType : 0
                ];
            }
        }

        return $parsedItems;
    }

    /**
     * @param string $item_string
     * @return array|null
     */
    private function parseRawData(string $item_string): ?array
    {

        $sorted_item_data = [];

        foreach (preg_split('/\r\n|\r|\n/', $item_string) as $item) {

            if (strlen($item) < 2) {
                continue;
            }

            if(stripos($item, "    ")) {
                $item_data_details = explode("    ", $item);
            } elseif (stripos($item, "\t") ) {
                $item_data_details = explode("\t", $item);
            } else {
                continue;
            }

            $item_name = $item_data_details[0];
            $item_quantity = null;

            foreach ($item_data_details as $item_data_detail) {
                if (is_numeric(trim($item_data_detail))) {
                    $item_quantity = (int)str_replace('.', '', $item_data_detail);
                }
            }

            if ($item_quantity == null) {
                continue;
            }

            $inv_type = InvType::where('typeName', '=', $item_name)->first();

            if (!array_key_exists($item_name, $sorted_item_data)) {
                $sorted_item_data[$item_name]["name"] = $item_name;
                $sorted_item_data[$item_name]["typeID"] = $inv_type->typeID;
                $sorted_item_data[$item_name]["quantity"] = 0;
                $sorted_item_data[$item_name]["price"] = 0;
                $sorted_item_data[$item_name]["sum"] = 0;
            }

            $sorted_item_data[$item_name]["quantity"] += $item_quantity;
        }

        return $sorted_item_data;
    }
}
