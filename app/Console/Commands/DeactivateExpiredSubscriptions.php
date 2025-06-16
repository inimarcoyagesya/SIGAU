<?php

namespace App\Console\Commands;

use App\Models\Umkm;
use Illuminate\Console\Command;

class DeactivateExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:deactivate';
    protected $description = 'Deactivate expired subscriptions';

    public function handle()
    {
        Umkm::where('subscription_expired_at', '<', now())
            ->where('status', 'active')
            ->update(['status' => 'banned']);

        $this->info('Expired subscriptions deactivated successfully.');
    }
}