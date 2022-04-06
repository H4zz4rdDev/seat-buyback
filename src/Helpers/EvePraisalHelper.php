<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackMarketConfig;

/**
 * Class EvePraisalHelper.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Helpers
 */
class EvePraisalHelper {

    /**
     * @var EvePraisalHelper
     */
    private static $instance;

    public static function getInstance() : EvePraisalHelper {
        if(!isset(self::$instance)) {
            self::$instance = new EvePraisalHelper();
        }

        return self::$instance;
    }

    public function parseEveItemData(string $item_string) : ?array {

        if(empty($item_string)) {
            return null;
        }

        $parsedRawData = $this->parseRawData($item_string);

        foreach ($parsedRawData as $key => $item) {
            $priceData = EveMarketerHelper::getInstance()->getItemPrice($item["typeID"]);
            $parsedRawData[$key]["price"] = $priceData[0]["buy"]["median"];
            $parsedRawData[$key]["sum"] = $priceData[0]["buy"]["median"] * $parsedRawData[$key]["quantity"];
        }

        return $this->categorizeItems($parsedRawData);
    }

    private function categorizeItems(array $itemData) : ?array
    {
        $parsedItems = [];
        foreach ($itemData as $key => $item) {

            $result = DB::table('invTypes as it')
                ->join('invGroups as ig', 'it.groupID', '=', 'ig.GroupID')
                ->rightJoin('buyback_market_config as bmc', 'it.groupID', '=', 'bmc.groupID')
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

            if(empty($result)) {

                $parsedItems["ignored"][] = [
                    'ItemId' => $item["typeID"],
                    'ItemName' => $item["name"],
                    'ItemQuantity' => $item["quantity"]
                ];

                continue;
            }

            if (!array_key_exists($result->groupID, $parsedItems)) {

                $parsedItems["parsed"][$result->groupID] = [
                    'groupID' => $result->groupID,
                    'marketGroupName' => $result->groupName,
                    'marketConfig' => [
                      'percentage' => $result->percentage != null ?  $result->percentage : 0,
                      'marketOperationType' => $result->marketOperationType != null ?  $result->marketOperationType : 0
                    ],
                    'items' => []
                ];
            }
            $parsedItems["parsed"][$result->groupID]["items"][] = $item;
        }

        return $parsedItems;
    }

    public function getItemTypeId(string $itemName) : ?int {

        $result = DB::table('invTypes')
                  ->select(
                    'typeID'
                  )
                  ->where('typeName', '=', $itemName)
                  ->first();
        return ($result == null) ? null : $result->typeID;
    }

    private function parseRawData(string $item_string) : ?array {

        $sorted_item_data = [];

        foreach (preg_split('/\r\n|\r|\n/', $item_string) as $item) {

            if(!preg_match('/\t\d/', $item)) {
                continue;
            }

            $item_data_details = explode("\t", $item);
            $item_name = $item_data_details[0];
            $item_quantity = $item_data_details[1];

            if (!array_key_exists($item_name, $sorted_item_data)) {
                $sorted_item_data[$item_name]["name"] = $item_name;
                $sorted_item_data[$item_name]["typeID"] = $this->getItemTypeId($item_name);
                $sorted_item_data[$item_name]["quantity"] = 0;
                $sorted_item_data[$item_name]["price"] = 0;
                $sorted_item_data[$item_name]["sum"] = 0;
            }

            if ($item_data_details[1] <= 0) {
                $sorted_item_data[$item_name]["quantity"] += 1;
            } else {
                $sorted_item_data[$item_name]["quantity"] += $item_quantity;
            }

        }

        return $sorted_item_data;
    }
}