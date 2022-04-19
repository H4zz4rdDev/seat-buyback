<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackMarketConfig;

/**
 * Class EvePraisalHelper.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Helpers
 */
class EvePraisalHelper
{

    /**
     * @var EvePraisalHelper
     */
    private static $instance;

    /**
     * @return EvePraisalHelper
     */
    public static function getInstance(): EvePraisalHelper
    {
        if (!isset(self::$instance)) {
            self::$instance = new EvePraisalHelper();
        }

        return self::$instance;
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
            $priceData = EveMarketerHelper::getInstance()->getItemPrice($item["typeID"]);

            $parsedRawData[$key]["price"] = $priceData[0]["sell"]["median"];
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
     * @param string $itemName
     * @return int|null
     */
    public function getItemTypeId(string $itemName): ?int
    {

        $result = DB::table('invTypes')
            ->select(
                'typeID'
            )
            ->where('typeName', '=', $itemName)
            ->first();
        return ($result == null) ? null : $result->typeID;
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
                    $item_quantity = $item_data_detail;
                }
            }

            if ($item_quantity == null) {
                continue;
            }

            if (!array_key_exists($item_name, $sorted_item_data)) {
                $sorted_item_data[$item_name]["name"] = $item_name;
                $sorted_item_data[$item_name]["typeID"] = $this->getItemTypeId($item_name);
                $sorted_item_data[$item_name]["quantity"] = 0;
                $sorted_item_data[$item_name]["price"] = 0;
                $sorted_item_data[$item_name]["sum"] = 0;
            }

            $sorted_item_data[$item_name]["quantity"] += $item_quantity;
        }

        return $sorted_item_data;
    }
}