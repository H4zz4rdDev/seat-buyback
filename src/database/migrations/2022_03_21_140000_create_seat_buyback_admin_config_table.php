<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatBuybackAdminConfigTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_admin_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });

        //Init table with default config entries
        $this->init();
    }

    /**
     * @return void
     */
    private function init() : void  {

        DB::table('buyback_admin_config')->insert([
           'name' => 'admin_price_cache_time',
           'value' => '3600'
        ]);

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_max_allowed_items',
            'value' => '20'
        ]);

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_contract_contract_to',
            'value' => 'EVECharacter'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyback_admin_config');
    }
}