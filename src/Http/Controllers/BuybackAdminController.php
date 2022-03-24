<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Helpers;
use WipeOutInc\Seat\SeatBuyback\Exceptions\SettingsException;

/**
 * Class BuybackAdminController.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Http\Controllers
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
            'settings' => $settings
        ]);
    }

    public function updateSettings(Request $request) {

        if($request->all() == null) {
            redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }
        Helpers\SettingsHelper::getInstance()->setAllSettings($request->all());

        return redirect()->back()
            ->with('success', 'Admin config successfully updated.');
    }

}
