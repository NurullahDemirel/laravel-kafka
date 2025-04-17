<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RdKafka\Conf;
use RdKafka\Producer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Producer::class, function ($app) {
            $conf = new Conf();
            $conf->set('metadata.broker.list', env('KAFKA_BROKER', 'kafka:9092'));
            return new Producer($conf);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
