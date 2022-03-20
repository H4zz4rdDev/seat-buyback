<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\Cache;
use WipOutInc\Seat\SeatBuyback\Exceptions\EveMarketerException;

/**
 * Class EveMarketerHelper.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Helpers
 */
class EveMarketerHelper {

    const BASE_URI = "https://api.evemarketer.com/ec/marketstat/json";

    const CACHE_TIME = 3600;

    /**
     * @var EveMarketerHelper
     */
    private static $instance;

    /**
     * @return EveMarketerHelper
     */
    public static function getInstance() : EveMarketerHelper {
        if(!isset(self::$instance)) {
            self::$instance = new EveMarketerHelper();
        }

        return self::$instance;
    }

    /**
     * @param array $itemTypeIds
     * @return array|null
     * @throws EveMarketerException
     */
    public function getMarketPriceList (array $itemTypeIds) : ?array  {

        if(empty($itemTypeIds)) {
            throw new EveMarketerException("ItemsTypeID not found!");
        }

        $prices = [];

        foreach($itemTypeIds as $itemTypeId) {
            $prices[$itemTypeId] = self::getItemPrice($itemTypeId);
        }

        return $prices;
    }

    /**
     * @param string $data
     * @return mixed
     */
    private function makeMarketerCall(string $data) {
        $url = self::BASE_URI."?typeid=" . $data;

        return json_decode(file_get_contents($url), true);

    }

    /**
     * @param int $itemTypeId
     * @return mixed
     */
    public function getItemPrice(int $itemTypeId) {

        if(Cache::has($itemTypeId)) {
            return Cache::get($itemTypeId);
        }

        $priceData = self::makeMarketerCall($itemTypeId);
        Cache::put($itemTypeId, $priceData, self::CACHE_TIME);

        return $priceData;
    }
}
