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

use H4zz4rdDev\Seat\SeatBuyback\Exceptions\NoMarketDataFoundException;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsServiceException;
use H4zz4rdDev\Seat\SeatBuyback\Models\BuybackPriceData;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use JsonException;

/**
 * Class EvePraisalPriceProvider
 */
class EvePraisalPriceProvider extends AbstractEvePriceProvider implements IPriceProvider
{
    private SettingsService $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        parent::__construct($settingsService);

        $this->settingsService = $settingsService;

        $this->name = "evePraisal";
    }

    /**
     * @param int $itemTypeId
     * @return BuybackPriceData|null
     * @throws NoMarketDataFoundException|SettingsServiceException
     */
    public function getItemPrice(int $itemTypeId) : ?BuybackPriceData {

        $prices = $this->getPriceData($itemTypeId, $this->name);

        return new BuybackPriceData(
            $itemTypeId,
            $prices["summaries"][0]["prices"]["buy"]["percentile"]
        );
    }

    /**
     * @param string $itemTypeId
     * @return mixed|null
     * @throws SettingsServiceException|JsonException
     */
    public function doCall(string $itemTypeId) {

        $url = $this->settingsService->get('admin_price_provider_url');

        if(str_ends_with($url, '/')) {
            $evePraisalUrl = substr($url, -1);
        } else {
            $evePraisalUrl = $url;
        }

        $url = sprintf($evePraisalUrl."/item/%d.json", $itemTypeId);
        $data = @file_get_contents($url);

        if($data === false) {
            return null;
        }

        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);

    }
}