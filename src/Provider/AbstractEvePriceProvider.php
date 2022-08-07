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

use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use Illuminate\Support\Facades\Cache;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\NoMarketDataFoundException;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsServiceException;

/**
 * Class AbstractEvePriceProvider
 */
abstract class AbstractEvePriceProvider {

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $price_cache_time;

    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @param string $itemTypeId
     * @return mixed
     */
    abstract protected function doCall(string $itemTypeId);

    /**
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
     * @param int $itemTypeId
     * @return array|null
     * @throws NoMarketDataFoundException
     * @throws SettingsServiceException
     */
    public function getPriceData (int $itemTypeId) : ?array {
        if($itemTypeId == null) {
            return null;
        }

        $cacheId = (int)$this->settingsService->get("admin_price_provider") . ":" . $itemTypeId;

        if(Cache::has($cacheId)) {
            $prices = Cache::get($cacheId);
        } else {
            $prices = $this->doCall($itemTypeId);
        }

        if($prices == null) {
            throw new NoMarketDataFoundException();
        }

        // Todo Wrong place
        Cache::put(
            $cacheId,
            $prices,
            (int)$this->settingsService->get("admin_price_cache_time"));

        return $prices;
    }
}
