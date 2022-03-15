<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

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
            'evepraisal' => Helpers\EvePraisalHelper::GetEvePraisalData()
        ]);
    }
}
