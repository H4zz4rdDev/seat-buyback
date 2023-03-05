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

class AddingDiscordConfigDefaultValues extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_discord_webhook_url',
            'value' => 'http://'
        ]);

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_discord_status',
            'value' => 0
        ]);

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_discord_webhook_color',
            'value' => '#1928f5'
        ]);

        DB::table('buyback_admin_config')->insert([
            'name' => 'admin_discord_webhook_bot_name',
            'value' => 'SeAT BuyBack Notification'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
