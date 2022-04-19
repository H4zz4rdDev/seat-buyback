<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Seat\Web\Http\Controllers\Controller;
use WipeOutInc\Seat\SeatBuyback\Helpers;

/**
 * Class BuybackController.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Http\Controllers
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
            return redirect('buyback')->withErrors(['errors' => 'No items that could be used found! Please check you item list!']);
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
