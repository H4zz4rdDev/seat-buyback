<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackMarketConfig;

class PriceCalculationHelper {

    /**
     * @param int $typeId
     * @param int $quantity
     * @param array $priceData
     * @return float|int|null
     */
    public static function calculateItemPrice(int $typeId, int $quantity, array $priceData) : ?float {

        $marketConfig = BuybackMarketConfig::where('typeId', $typeId)->first();

        if($marketConfig == null) {
            return null;
        }

        $priceSum = $quantity * $priceData[0]["buy"]["median"];
        $pricePercentage = $priceSum * $marketConfig->percentage / 100;

        if(!$marketConfig->marketOperationType) {
            $price = $priceSum - $pricePercentage;
        } else {
            $price = $priceSum + $pricePercentage;
        }

        return $price;
    }

    public static function calculateFinalPrice(array $itemData) : ?float {

        $finalPrice = 0;

        foreach ($itemData as $item) {
            $finalPrice += $item["typeSum"];
        }

        return $finalPrice;

    }
}