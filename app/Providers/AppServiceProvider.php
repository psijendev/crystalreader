<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\PingCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Health::checks([
            SecurityAdvisoriesCheck::new(),

            DatabaseConnectionCountCheck::new()
            ->failWhenMoreConnectionsThan(100),

            DatabaseSizeCheck::new()
        ->failWhenSizeAboveGb(errorThresholdGb: 5.0),


            PingCheck::new()->url('https://example.com'),

            CacheCheck::new(),

            UsedDiskSpaceCheck::new(),

            DatabaseCheck::new(),

            CpuLoadCheck::new()
            ->failWhenLoadIsHigherInTheLast5Minutes(2.0),

            OptimizedAppCheck::new(),

            DebugModeCheck::new(),

            EnvironmentCheck::new(),
        ]);
    }
}
