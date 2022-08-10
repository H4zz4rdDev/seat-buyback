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

Route::group([
    'namespace' => 'H4zz4rdDev\Seat\SeatBuyback\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
], function () {

    Route::prefix('/buyback')
        ->group(function () {

            //Show buyback request form
            Route::get('/')
                ->name('buyback.home')
                ->uses('BuybackController@getHome');

            // Show buyback calculation results
            Route::post('/')
                ->name ('buyback.check')
                ->uses('BuybackController@checkItems');

            // Show characters contracts
            Route::get('/myContracts')
                ->name('buyback.character.contracts')
                ->uses('BuybackContractController@getCharacterContracts');

            // Show characters contracts
            Route::prefix('/contracts')
                ->group(function () {

                // Show all open contracts
                Route::get('/')
                    ->name('buyback.contract')
                    ->uses('BuybackContractController@getHome');

                // Insert new contract
                Route::post('/insert')
                    ->name('buyback.contracts.insert')
                    ->uses('BuybackContractController@insertContract');

                // Delete contract
                Route::get('/delete/{contractId}')
                    ->name('buyback.contracts.delete')
                    ->uses('BuybackContractController@deleteContract');

                // Succeed contract
                Route::get('/succeed/{contractId}')
                    ->name('buyback.contracts.succeed')
                    ->uses('BuybackContractController@succeedContract');
                });


            Route::prefix('items')
                ->group(function () {
                    // Show items page
                    Route::get('/')
                        ->name('buyback.item')
                        ->uses('BuybackItemController@getHome');

                    // Add market config
                    Route::post('/addMarketConfig')
                        ->name('buyback.item.market.add')
                        ->uses('BuybackItemController@addMarketConfig');

                    // Remove market config
                    Route::get('/removeMarketConfig/{typeId}')
                        ->name('buyback.item.market.remove')
                        ->uses('BuybackItemController@removeMarketConfig');
                });

            Route::prefix('/admin')
                ->group(function () {

                    // Show admin view
                    Route::get('/')
                        ->name('buyback.admin')
                        ->uses('BuybackAdminController@getHome');

                    // Update plugin settings
                    Route::post('/')
                        ->name('buyback.admin.update')
                        ->uses('BuybackAdminController@updateSettings');
                });
        });

    // Select2 autocomplete
    Route::get('/autocomplete')
        ->name('autocompelte')
        ->uses('SearchController@autocomplete');
});
