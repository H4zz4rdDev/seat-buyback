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
use H4zz4rdDev\Seat\SeatBuyback\Models\BuybackPriceData;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use Illuminate\Support\Facades\Cache;

/**
 * Class EvePraisalPriceProvider
 */
class EvePraisalPriceProvider implements IPriceProvider
{
    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @param string $itemTypeId
     * @return mixed|null
     */
    public function doCall(string $itemTypeId) {

        $url = sprintf(config('buyback.priceProvider.evePraisal.apiUrl')."/item/%d.json", $itemTypeId);
        $data = @file_get_contents($url);

        if($data === false) {
            return null;
        }

        return json_decode($data, true);

    }

    /**
     * @param int $itemTypeId
     * @return mixed|void
     * @throws SettingsServiceException
     */
    public function getItemPrice(int $itemTypeId) : ?BuybackPriceData {

        if($itemTypeId == null) {
            return null;
        }

        if(Cache::has($itemTypeId)) {
            $prices = Cache::get($itemTypeId);
        } else {
            $prices = $this->doCall($itemTypeId);

            if($prices == null) {
                return null;
            }
            Cache::put(
                (int)$this->settingsService->get("admin_price_provider").$itemTypeId,
                $prices,
                (int)$this->settingsService->get("admin_price_cache_time"));
        }

        return new BuybackPriceData(
            $itemTypeId,
            $prices["summaries"][0]["prices"]["buy"]["percentile"]
        );
    }
}