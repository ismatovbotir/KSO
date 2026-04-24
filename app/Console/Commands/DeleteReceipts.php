<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use Illuminate\Console\Command;

class DeleteReceipts extends Command
{
    protected $signature = 'app:delete-receipts';
    protected $description = 'Delete uploaded receipts older than 3 days';

    public function handle()
    {
        $thresholdDate = now()->subDays(3);

        $count = Receipt::where('status', 'uploaded')
            ->where('created_at', '<', $thresholdDate)
            ->delete();

        $this->info("Deleted {$count} old receipt(s).");
    }
}
