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

namespace H4zz4rdDev\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Seat\Web\Http\Controllers\Controller;
use H4zz4rdDev\Seat\SeatBuyback\Helpers;

/**
 * Class BuybackController.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback\Http\Controllers
 */
class BuybackController extends Controller
{
    private const MaxContractIdLength = 6;

    /**
     * @var int
     */
    private $_maxAllowedItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_maxAllowedItems = Helpers\SettingsHelper::getInstance()->getMaxAllowedItems();
    }

    /**
     * @return View
     */
    public function getHome() : View
    {
        return view('buyback::buyback', [
            'maxAllowedItems' => $this->_maxAllowedItems
        ]);
    }

    /**
     * @return View
     */
    public function checkItems(Request $request)
    {
        $request->validate([
            'items' => 'required',
        ]);

        $parsedItems = Helpers\EvePraisalHelper::getInstance()->parseEveItemData($request->get('items'));

        if(!array_key_exists("parsed", $parsedItems)) {
            return redirect('buyback')->withErrors(['errors' => trans('buyback::global.empty_item_field')]);
        }

        $maxAllowedItems = Helpers\SettingsHelper::getInstance()->getMaxAllowedItems();

        if (count($parsedItems) > $maxAllowedItems) {
            return redirect('buyback')->withErrors(
                ['errors' => 'Too much items posted. Max allowed items: ' . $maxAllowedItems]);
        }

        $finalPrice = Helpers\PriceCalculationHelper::calculateFinalPrice($parsedItems["parsed"]);

        return view('buyback::buyback', [
            'eve_item_data' => $parsedItems,
            'maxAllowedItems' => $this->_maxAllowedItems,
            'finalPrice' => $finalPrice,
            'contractId' => Helpers\MiscHelper::generateRandomString(self::MaxContractIdLength)
        ]);
    }
}
