<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use Illuminate\Console\Command;

class RetryFailed extends Command
{
    protected $signature = 'app:retry-failed';
    protected $description = 'Reset failed receipts back to pending for resubmission';

    const MAX_RETRIES = 3;

    public function handle()
    {
        $count = Receipt::where('status', 'failed')
            ->where('retry_count', '<', self::MAX_RETRIES)
            ->update(['status' => 'pending']);

        $this->info("Reset {$count} failed receipt(s) to pending.");
    }
}
