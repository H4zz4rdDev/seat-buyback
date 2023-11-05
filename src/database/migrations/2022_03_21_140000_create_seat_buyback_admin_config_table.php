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

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatBuybackAdminConfigTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('buyback_admin_config', function (Blueprint $table): void {
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

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_contract_expiration',
            'value' => '4 Weeks'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('buyback_admin_config');
    }
}