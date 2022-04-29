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

namespace H4zz4rdDev\Seat\SeatBuyback\Provider;

use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsServiceException;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Support\Facades\Cache;


/**
 * Class EveMarketPriceProvider
 */
class EveMarketerPriceProvider implements IPriceProvider
{
    /**
     * @var string
     */
    public $price_cache_time;

    /**
     * @var SettingsService
     */
    public $settingsService;

    /**
     * Constructor
     *
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
        try {
            $this->price_cache_time = $settingsService->get("admin_price_cache_time");
        } catch (SettingsServiceException $e) {
            \Log::error('SettingsServiceException: ' . $e->getMessage());
        }
    }

    /**
     * @param string $itemTypeId
     * @return mixed
     */
    public function doCall(string $itemTypeId) {

        $url = config('buyback.priceProvider.eveMarketer.apiUrl')."?typeid=" . $itemTypeId;
        $data = @file_get_contents($url);

        if($data === false) {
            return null;
        }

        return json_decode($data, true);
    }

    /**
     * @param int $itemTypeId
     * @return mixed
     */
    public function getItemPrice(int $itemTypeId) {

        //Todo Repair EVEMarketer
        return null;

        if(Cache::has($itemTypeId)) {
            return Cache::get($itemTypeId);
        }

        $priceData = $this->doCall($itemTypeId);

        if($priceData == null) {
            return null;
        }

        Cache::put($itemTypeId, $priceData, (int)$this->price_cache_time);

        return $priceData;
    }
}