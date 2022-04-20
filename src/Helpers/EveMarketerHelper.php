<?php

namespace H4zz4rdDev\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\Cache;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\EveMarketerException;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsException;

/**
 * Class EveMarketerHelper.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback\Helpers
 */
class EveMarketerHelper {

    const BASE_URI = "https://api.evemarketer.com/ec/marketstat/json";

    public $price_cache_time;

    public function __construct()
    {
        try {
            $this->price_cache_time = SettingsHelper::getInstance()->getSetting("admin_price_cache_time");
        } catch (SettingsException $e) {
            \Log::error('QueryException: ' . $e->getMessage());
        }
    }

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

        $priceData = $this->makeMarketerCall($itemTypeId);
        Cache::put($itemTypeId, $priceData, (int)$this->price_cache_time);

        return $priceData;
    }
}
