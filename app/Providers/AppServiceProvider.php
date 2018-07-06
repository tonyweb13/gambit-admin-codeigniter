<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\ActivityLog;
use App\Models\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        # Register Model's respective Observer here.
        Agent::observe(new \App\Models\Observers\Agent());
        ActivityLog::observe(new \App\Models\Observers\ActivityLog());
        Manager::observe(new \App\Models\Observers\Manager());

        // Database Query logging, except in production
        if (env('APP_ENV') <> 'production' AND env('LOG_DB_QUERIES')) {
            DB::listen(function($query) {
                Log::debug([$query->sql, $query->bindings, $query->time]);
            });
        }
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment() <> 'production') {
            $this->app->register('Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider');
        }
    }
}
