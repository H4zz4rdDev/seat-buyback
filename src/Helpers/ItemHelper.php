<?php

namespace WipeOutInc\Seat\SeatBuyback\Helpers;

use Illuminate\Support\Facades\DB;

class ItemHelper {

    /**
     * @param int $typeId
     * @return object|null
     */
    public static function getItemDetails (int $typeId) : ?object {

        return DB::table('invTypes AS t')
            ->join('invGroups as g', 't.groupID' , '=', 'g.groupID')
            ->select(
                't.typeID',
                't.groupID',
                't.typeName',
                't.marketGroupID',
                'g.groupName'
            )
            ->where('typeID', $typeId)
            ->first();
    }
}
