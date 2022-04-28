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

namespace H4zz4rdDev\Seat\SeatBuyback;

use H4zz4rdDev\Seat\SeatBuyback\Factories\PriceProviderFactory;
use H4zz4rdDev\Seat\SeatBuyback\Services\ItemService;
use H4zz4rdDev\Seat\SeatBuyback\Services\SettingsService;
use Seat\Services\AbstractSeatPlugin;

/**
 * Class SeatBuybackServiceProvider.
 *
 * @package H4zz4rdDev\Seat\SeatBuyback
 */
class SeatBuybackServiceProvider extends AbstractSeatPlugin
{
    public function boot()
    {
        $this->add_routes();

        $this->add_publications();

        $this->add_views();

        $this->add_translations();

        $this->add_migrations();

        $this->registerDependencyInjectionClasses();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/buyback.config.php', 'buyback.config');
        $this->mergeConfigFrom(__DIR__ . '/Config/buyback.locale.php', 'buyback.locale');

        // Overload sidebar with your package menu entries
        $this->mergeConfigFrom(__DIR__ . '/Config/Menu/package.sidebar.php', 'package.sidebar');

        // Merge PriceProvider config
        $this->mergeConfigFrom(__DIR__ . '/Config/PriceProvider/buyback.priceProvider.php', 'buyback.priceProvider');

        // Register generic permissions
        $this->registerPermissions(__DIR__ . '/Config/Permissions/buyback.php', 'buyback');
    }

    /**
     * Register dependency injection classes
     */
    private function registerDependencyInjectionClasses()
    {
        // Settings Service
        $this->app->singleton(SettingsService::class, function () {
            return new SettingsService();
        });

        // Price Provider Factory
        $this->app->singleton(PriceProviderFactory::class, function ($app) {
            return new PriceProviderFactory($app->make(SettingsService::class));
        });

        // Settings Service
        $this->app->singleton(ItemService::class, function ($app) {
            return new ItemService($app->make(PriceProviderFactory::class));
        });
    }

    /**
     * Include routes.
     */
    private function add_routes()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }

    /**
     * Import API annotations used to generate Swagger documentation (using Open Api Specifications syntax).
     */
    private function add_api_endpoints()
    {
        $this->registerApiAnnotationsPath([
            __DIR__ . '/Http/Resources',
            __DIR__ . '/Http/Controllers/Api/V2',
        ]);
    }

    /**
     * Add content which must be published (generally, configuration files or static ones).
     */
    private function add_publications()
    {
        $this->publishes([
            __DIR__ . '/resources/css' => public_path('web/css'),
            __DIR__ . '/resources/img' => public_path('your-package/img'),
            __DIR__ . '/resources/js' => public_path('your-package/js'),
        ], ['public', 'seat']);
    }

    /**
     * Import translations.
     */
    private function add_translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'buyback');
    }

    /**
     * Import views.
     */
    private function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'buyback');
    }

    /**
     * Add SDE tables to be imported.
     */
    private function add_sde_tables()
    {
        $this->registerSdeTables([
            'mapJumps',
        ]);
    }

    /**
     * Import database migrations.
     */
    private function add_migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     * @example SeAT Web
     *
     */
    public function getName(): string
    {
        return 'Seat Corp-Buyback';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/H4zz4rdDev/seat-buyback';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     * @example web
     *
     */
    public function getPackagistPackageName(): string
    {
        return 'seat-buyback';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     * @example eveseat
     *
     */
    public function getPackagistVendorName(): string
    {
        return 'H4zz4rdDev';
    }

    /**
     * Return the plugin installed version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return config('buyback.config.version');
    }
}
