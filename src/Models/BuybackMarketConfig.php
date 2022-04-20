<?php

namespace H4zz4rdDev\Seat\SeatBuyback\Models;

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
    protected $primaryKey = 'typeId';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
