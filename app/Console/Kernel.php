<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
{
    $schedule->command('subscriptions:deactivate')->daily();
}
    protected $commands = [
        \App\Console\Commands\RefreshSingleMigration::class,
    ];

    protected $routeMiddleware = [
        'verified.umkm' => \App\Http\Middleware\CheckVerifiedUmkm::class,
    ];
    
}
