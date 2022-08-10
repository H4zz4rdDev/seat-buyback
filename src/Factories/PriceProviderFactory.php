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

namespace H4zz4rdDev\Seat\SeatBuyback\Factories;

use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsServiceException;
use H4zz4rdDev\Seat\SeatBuyback\Provider\EveMarketerPriceProvider;
use H4zz4rdDev\Seat\SeatBuyback\Provider\EvePraisalPriceProvider;
use H4zz4rdDev\Seat\SeatBuyback\Provider\IPriceProvider;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;

/**
 * Class PriceProviderFactory
 */
class PriceProviderFactory
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
     * @return IPriceProvider|null
     * @throws SettingsServiceException
     */
    public function getPriceProvider(): ?IPriceProvider
    {
        $priceProvider = null;

        try {
            switch ((int)$this->settingsService->get('admin_price_provider')) {
                case 1:
                    $priceProvider = new EveMarketerPriceProvider($this->settingsService);
                    break;
                case 2:
                    $priceProvider = new EvePraisalPriceProvider($this->settingsService);
                    break;
            }
        } catch (SettingsServiceException $e) {
            throw new SettingsServiceException(trans('buyback::global.error'));
        }

        return $priceProvider;
    }
}