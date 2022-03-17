<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Class EvePraisalHelper.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Helpers
 */
class EvePraisalHelper {

    /**
     * @return string
     */
    public static function getEvePraisalData () : string {
        return "Coming soon...";
    }

    public static function parseEveItemData(string $item_string) : ?array {

        if(empty($item_string)) {
            return null;
        }

        return self::categorizeItems(self::parseRawData($item_string));
    }

    private static function categorizeItems(array $itemData) : ?array {

        $parsedItems = [];
        foreach ($itemData as $key => $item) {

            $result = DB::table('invTypes as it')
                ->join('invGroups as ig', 'it.groupID', '=', 'ig.GroupID')
                ->select(
                    'it.typeName as typeName',
                    'it.description as description',
                    'ig.GroupName as groupName',
                    'ig.GroupID as groupID'
                )
                ->where('it.typeName', '=', $key)
                ->first();

            if(empty($result)) {
                continue;
            }

            $groupID = $result->groupID;
            if (!array_key_exists($groupID, $parsedItems)) {
                $parsedItems[$groupID] = [
                    'groupID' => $groupID,
                    'marketGroupName' => $result->groupName,
                    'Items' => []
                ];
            }
            $parsedItems[$groupID]["Items"][] = $item;
        }

        return $parsedItems;
    }

    private static function parseRawData(string $item_string) : ?array {

        $sorted_item_data = [];

        foreach (preg_split('/\r\n|\r|\n/', $item_string) as $item) {
            $item_data_details = explode("\t", $item);
            $item_name = $item_data_details[0];
            $item_quantity = $item_data_details[1];

            if(!array_key_exists($item_name,$sorted_item_data)) {
                $sorted_item_data[$item_name]["name"] = $item_name;
                $sorted_item_data[$item_name]["quantity"] = 0;
            }

            if($item_data_details[1] <= 0) {
                $sorted_item_data[$item_name]["quantity"] += 1;
            } else {
                $sorted_item_data[$item_name]["quantity"] += $item_quantity;
            }
        }

        return $sorted_item_data;
    }
}