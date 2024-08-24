<?php
/**
 * This file is part of SeAT Discord Connector.
 *
 * Copyright (C) 2019, 2020  Warlof Tutsimo <loic.leuilliot@gmail.com>
 *
 * SeAT Discord Connector  is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * SeAT Discord Connector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace FeiBam\Seat\Connector\Drivers\QQ;

use Illuminate\Support\Facades\Event;
use Seat\Services\AbstractSeatPlugin;

/**
 * Class QQConnectorServiceProvider.
 *
 * @package FeiBam\Seat\Connector\Drivers\QQ
 */

class QQConnectorServiceProvider extends AbstractSeatPlugin {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        $this -> addRoutes();
        $this -> addViews();
        $this -> addTranslations();
    }

    public function register(){
        $this->mergeConfigFrom(
            __DIR__ . '/Config/qq-connector.config.php', 'qq-connector.config');

        $this->mergeConfigFrom(
            __DIR__ . '/Config/seat-connector.config.php', 'seat-connector.drivers.qq');
    }

    private function addRoutes(){
        if (! $this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }
    }

    private function addTranslations(){
        $this->loadTranslationsFrom(__DIR__ . './resources/lang', 'seat-qq-connector');
    }

    public function addViews(){

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'seat-qq-connector');
    }

    public function getName(): string{
        return 'QQ Connector';
    }

    /**
     * Return the plugin repository address.
     *
     * @example https://github.com/eveseat/web
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string{
        return 'https://github.com/feibam/seat-qq-connector';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @example web
     *
     * @return string
     */
    public function getPackagistPackageName(): string{
        return 'seat-qq-connector';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @example eveseat
     *
     * @return string
     */
    public function getPackagistVendorName(): string{
        return 'feibam';
    }
}