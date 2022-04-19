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

use WipeOutInc\Seat\SeatBuyback\Http\Controllers\BuybackController;
use WipeOutInc\Seat\SeatBuyback\Http\Controllers\BuybackAdminController;
use WipeOutInc\Seat\SeatBuyback\Http\Controllers\BuybackContractController;
use WipeOutInc\Seat\SeatBuyback\Http\Controllers\SearchController;

Route::group([
    'namespace' => 'WipeOutInc\Seat\SeatBuyback\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
], function () {
    Route::get('/buyback', [BuybackController::class, 'getHome'])->name("buyback.home");
    Route::post('/buyback', [BuybackController::class, 'checkItems'])->name("buyback.check");
    Route::get('/buyback/contracts', [BuybackContractController::class, 'getHome'])->name("buyback.contract");
    Route::post('/buyback/contracts/insert', [BuybackContractController::class, 'insetContract'])->name("buyback.contract-insert");
    Route::get('/buyback/contracts/delete/{contractId}', [BuybackContractController::class, 'deleteContract'])->name("buyback.contract-delete");
    Route::get('/buyback/contracts/succeed/{contractId}', [BuybackContractController::class , 'succeedContract'])->name("buyback.contract-succeed");
    Route::get('/buyback/admin', [BuybackAdminController::class, 'getHome'])->name("buyback.admin");
    Route::post('/buyback/admin', [BuybackAdminController::class, 'updateSettings'])->name("buyback.admin-update");
    Route::post('/buyback/admin/add-market-config', [BuybackAdminController::class, 'addMarketConfig'])->name("buyback.admin-market");
    Route::get('/buyback/admin/remove-market-config/{typeId}', [BuybackAdminController::class, 'deleteMarketConfig'])->name("buyback.admin-market-remove");
    Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name("autocomplete");
});
