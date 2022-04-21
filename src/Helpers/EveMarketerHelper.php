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

namespace H4zz4rdDev\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\Cache;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\EveMarketerException;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsException;

/**
 * Class EveMarketerHelper
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
