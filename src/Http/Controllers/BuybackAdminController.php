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

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Eveapi\Models\Sde\InvType;
use Seat\Web\Http\Controllers\Controller;
use H4zz4rdDev\Seat\SeatBuyback\Helpers;
use H4zz4rdDev\Seat\SeatBuyback\Exceptions\SettingsException;
use H4zz4rdDev\Seat\SeatBuyback\Models\BuybackMarketConfig;

/**
 * Class BuybackAdminController.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback\Http\Controllers
 */
class BuybackAdminController extends Controller
{
    /**
     * @return mixed
     */
    public function getHome()
    {
        try {
            $settings = Helpers\SettingsHelper::getInstance()->getAllSettings();
        } catch (SettingsException $e) {
            return redirect('home')->withErrors(['errors' => $e->getMessage()]);
        }

        return view('buyback::buyback_admin', [
            'settings' => $settings,
            'marketConfigs' => BuybackMarketConfig::orderBy('typeName', 'asc')->get()

        ]);
    }

    public function updateSettings(Request $request) {

        $request->validate([
            'admin_price_cache_time' => 'required|numeric|between:300,3600',
            'admin_max_allowed_items' => 'required|numeric|between:1,50',
            'admin_contract_contract_to' => 'required|max:128',
            'admin_contract_expiration' => 'required|max:32'
        ]);

        if($request->all() == null) {
            return redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }
        Helpers\SettingsHelper::getInstance()->setAllSettings($request->all());

        return redirect()->back()
            ->with('success', 'Admin config successfully updated.');
    }

    public function addMarketConfig(Request $request) {

        $request->validate([
            'admin-market-typeId' => 'required|max:255',
            'admin-market-operation' => 'required',
            'admin-market-percentage' => 'required|numeric|between:0,99.99'
        ]);

        $item = BuybackMarketConfig::where('typeId', $request->get('admin-market-typeId'))->first();

        if($item != null) {
            return redirect()->route('buyback.admin')
                ->with(['error' => "There is already a config for Id: " . $item->typeId]);
        }

        $invType = InvType::where('typeID', $request->get('admin-market-typeId'))->first();

        BuybackMarketConfig::insert([
            'typeId' => $request->get('admin-market-typeId'),
            'typeName' => $invType->typeName,
            'marketOperationType' => $request->get('admin-market-operation'),
            'groupId' => $invType->groupID,
            'groupName' => $invType->group->groupName,
            'percentage' => $request->get('admin-market-percentage')
        ]);

        return  redirect()->route('buyback.admin')
            ->with('success', 'Market config successfully added.');
    }

    public function removeMarketConfig(Request $request, int $typeId) {

        if(!$request->isMethod('get') || empty($typeId) || !is_numeric($typeId))
        {
            return redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }

        BuybackMarketConfig::destroy($typeId);

        return redirect()->back()
            ->with('success', 'Market config successfully deleted.');
    }
}
