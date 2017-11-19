<?php

namespace App\Providers;

use App\Ideas\QueryAnalyzer;
use App\Http\Requests\IdeaRequest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // The QueryAnalyzer instance
        $this->app->bind('analyzer', function () {
            return new QueryAnalyzer(new IdeaRequest);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
