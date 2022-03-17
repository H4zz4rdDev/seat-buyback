<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Seat\Web\Http\Controllers\Controller;

/**
 * Class BuybackAdminController.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Http\Controllers
 */
class BuybackAdminController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function getHome()
    {
        return view('buyback::buyback_admin');
    }
}
