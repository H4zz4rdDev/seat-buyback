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
            $data = DB::table('invTypes as t')
                ->join('invGroups as g', 't.groupID', '=', 'g.groupID')
                ->select(
                    't.typeID AS id',
                    DB::raw("CONCAT(t.typeName,' (',g.groupName, ')') as name"),
                )
                ->where('typeName', 'LIKE', "%" . $request->get('q') . "%")
                ->whereNotNull('marketGroupID')
                ->get();
        }
        return response()->json($data);
    }
}
