<?php

namespace LaraSU\Logger\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use LaraSU\Logger\Services\LaraLog;

class LogServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/lara-log.php' => config_path('lara-log.php'),
        ], 'lara-log');
    }

    /**
     * Регистрация сервиса LogManager
     *
     * @return void
     */
    public function register()
    {
        App::singleton('LaraLog', static function () {
            return new LaraLog(config('lara-log'));
        });
    }

}