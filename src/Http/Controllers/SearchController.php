<?php

namespace WipeOutInc\Seat\SeatBuyback\Http\Controllers;

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class SearchController.
 *
 * @package WipeOutInc\Seat\SeatBuyback\Http\Controllers
 */
class SearchController extends Controller {

    public function autocomplete(Request $request) {
        if($request->has('q')) {
            $data = DB::table('invGroups')
                ->select(
                    'groupID AS id',
                    'groupName AS name'
                )
                ->where('groupName', 'LIKE', "%" . $request->get('q') . "%")
                ->get();

        }
        return response()->json($data);
    }
}
