<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Vaneves\Bitcoin\Network;
use Vaneves\Bitcoin\Bitcoin;

class BitcoinServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(Bitcoin::class, function ($app) {
            $config = config('bitcoin');
            $dsn = 'http://'. $config['username'] .':'. $config['password'] .'@'. $config['host'] .':'. $config['port'];
            $network = new Network($dsn);
            $bitcoin = new Bitcoin($network);

            return $bitcoin;
        });
    }

    public function provides()
    {
        return [Bitcoin::class];
    }
}
