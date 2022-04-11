<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Helpers;
use WipeOutInc\Seat\SeatBuyback\Exceptions\SettingsException;
use WipeOutInc\Seat\SeatBuyback\Models\BuybackMarketConfig;

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
            'settings' => $settings,
            'marketConfigs' => BuybackMarketConfig::orderBy('typeName', 'asc')->get()

        ]);
    }

    public function updateSettings(Request $request) {

        if($request->all() == null) {
            return redirect()->back()
                ->with(['error' => "An error occurred!"]);
        }
        Helpers\SettingsHelper::getInstance()->setAllSettings($request->all());

        return redirect()->back()
            ->with('success', 'Admin config successfully updated.');
    }

    public function addMarketConfig(Request $request) {

        if($request->all() == null) {
            return redirect()->route('buyback.admin')
                ->with(['error' => "An error occurred!"]);
        }

        $item = BuybackMarketConfig::where('typeId', $request->get('admin-market-typeId'))->first();

        if($item != null) {
            return redirect()->route('buyback.admin')
                ->with(['error' => "There is already a config for Id: " . $item->typeId]);
        }

        $itemDetails = Helpers\ItemHelper::getItemDetails($request->get('admin-market-typeId'));

        BuybackMarketConfig::insert([
            'typeId' => $request->get('admin-market-typeId'),
            'typeName' => $itemDetails->typeName,
            'marketOperationType' => $request->get('admin-market-operation'),
            'groupId' => $itemDetails->groupID,
            'groupName' => $itemDetails->groupName,
            'percentage' => $request->get('admin-market-percentage')
        ]);

        return  redirect()->route('buyback.admin')
            ->with('success', 'Market config successfully added.');
    }

    public function deleteMarketConfig(Request $request, int $typeId) {

            if(!$request->isMethod('get') || empty($typeId))
            {
                return redirect()->back()
                    ->with(['error' => "An error occurred!"]);
            }

            BuybackMarketConfig::destroy($typeId);

            return redirect()->back()
                ->with('success', 'Market config successfully deleted.');
    }
}
