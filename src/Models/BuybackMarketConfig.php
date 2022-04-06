<?php

namespace WipeOutInc\Seat\SeatBuyback\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BuybackMarketConfig extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buyback_market_config';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'groupId';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function getGroupDetails (int $groupId) : ?object {

        return DB::table('invGroups')
            ->select(
                'groupID',
                'categoryID',
                'groupName'
            )
            ->where('groupID', $groupId)
            ->first();
    }

    /**
     * @param $data
     * @return void
     */
    public function set($data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
