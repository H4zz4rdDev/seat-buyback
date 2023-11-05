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

/**
 * Class EveMarketPriceProvider
 */
class EveMarketerPriceProvider extends AbstractEvePriceProvider implements IPriceProvider
{
    /**
     * @param SettingsService $settingsService
     */
    function __construct(SettingsService $settingsService)
    {
        parent::__construct($settingsService);

        $this->name = "eveMarketer";
    }

    /**
     * @param int $itemTypeId
     * @return BuybackPriceData|null
     * @throws NoMarketDataFoundException|SettingsServiceException
     */
    public function getItemPrice(int $itemTypeId): ?BuybackPriceData
    {
        $prices = $this->getPriceData($itemTypeId, $this->name);

        return new BuybackPriceData(
            $itemTypeId,
            $prices[0]["buy"]["fivePercent"]
        );
    }

    /**
     * @param string $itemTypeId
     * @return mixed
     */
    public function doCall(string $itemTypeId) {

        $url = config('buyback.priceProvider.'. $this->name .'.apiUrl')."?typeid=" . $itemTypeId;
        $data = @file_get_contents($url);

        if($data === false) {
            return null;
        }

        return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
    }
}