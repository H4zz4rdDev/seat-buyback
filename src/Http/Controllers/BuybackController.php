<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Helpers;

/**
 * Class BuybackController.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Http\Controllers
 */
class BuybackController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function getHome()
    {
        return view('buyback::buyback', [
            'evepraisal' => Helpers\EvePraisalHelper::getEvePraisalData()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function checkItems(Request $request) {

        if(empty($request->get('items'))) {
            return redirect('buyback')->withErrors(['errors' => trans('buyback::global.itemcheck.error')]);
        }

        $parsedItems = Helpers\EvePraisalHelper::parseEveItemData($request->get('items'));

        return view('buyback::buyback', [
            'eve_item_data' => $parsedItems
        ]);
    }
}
