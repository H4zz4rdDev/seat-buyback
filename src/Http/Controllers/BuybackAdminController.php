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

use H4zz4rdDev\Seat\SeatBuyback\Models\BuyBackPriceProvider;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Web\Http\Controllers\Controller;
use H4zz4rdDev\Seat\SeatBuyback\Models\BuybackMarketConfig;

/**
 * Class BuybackAdminController.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback\Http\Controllers
 */
class BuybackAdminController extends Controller
{
    /**
     * @var SettingsService
     */
    public $settingsService;

    /**
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @return mixed
     */
    public function getHome()
    {
        return view('buyback::buyback_admin', [
            'settings' => $this->settingsService->getAll(),
            'marketConfigs' => BuybackMarketConfig::orderBy('typeName', 'asc')->get(),
            'priceProvider' => BuyBackPriceProvider::orderBy('name', 'asc')->get(),
            ''
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateSettings(Request $request)
    {

        $request->validate([
            'admin_price_cache_time' => 'required|numeric|between:300,3600',
            'admin_max_allowed_items' => 'required|numeric|between:1,50',
            'admin_contract_contract_to' => 'required|max:128',
            'admin_contract_expiration' => 'required|max:32'
        ]);

        if ($request->all() == null) {
            return redirect()->back()
                ->with(['error' => trans('buyback::global.error')]);
        }

        $this->settingsService->setAll($request->all());

        return redirect()->back()
            ->with('success', trans('buyback::global.admin_success_config'));
    }
}
