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
     * @return \Illuminate\View\View
     */
    public function getHome()
    {
        return view('buyback::buyback', [
            'maxAllowedItems' => $this->_maxAllowedItems
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function checkItems(Request $request)
    {
        if (empty($request->get('items'))) {
            return redirect('buyback')->withErrors(['errors' => trans('buyback::global.itemcheck.error')]);
        }

        $parsedItems = Helpers\EvePraisalHelper::getInstance()->parseEveItemData($request->get('items'));

        if(!array_key_exists("parsed", $parsedItems)) {
            return redirect('buyback')->withErrors(['errors' => 'No items that could be used found! Please check you item list!']);
        }

        $maxAllowedItems = Helpers\SettingsHelper::getInstance()->getMaxAllowedItems();

        if (count($parsedItems) > $maxAllowedItems) {
            return redirect('buyback')->withErrors(
                ['errors' => 'Too much items posted. Max allowed items: ' . $maxAllowedItems]);
        }

        return view('buyback::buyback', [
            'eve_item_data' => $parsedItems,
            'maxAllowedItems' => $this->_maxAllowedItems
        ]);
    }
}
