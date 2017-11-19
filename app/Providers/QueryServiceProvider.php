<?php

namespace App\Providers;

use App\Contracts\Query\Analyzer;
use Illuminate\Support\ServiceProvider;

class QueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Analyzer::class, function () {
            $analyzer = config('query.analyzer');

            return new $analyzer(config('query.parsers'), config('query.builders'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
