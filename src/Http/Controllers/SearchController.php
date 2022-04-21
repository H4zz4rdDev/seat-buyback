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

use Seat\Web\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class SearchController.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback\Http\Controllers
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
                ->orderBy('typeName', 'asc')
                ->get();
        }
        return response()->json($data);
    }
}
