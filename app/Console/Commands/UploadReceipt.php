<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Receipt;
use Illuminate\Support\Facades\Http;

class UploadReceipt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:receipt {--limit=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload pending receipts to main server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mainServer =  env('MAIN_SERVER');
        $mainKey = env('MAIN_KEY');
        $mainValue = env('MAIN_VALUE');

        if (!$mainServer) {
            $this->error('MAIN_SERVER environment variable is not set');
            return 1;
        }

        $limit = (int) $this->option('limit');
        $receipts = Receipt::where('status', 'pending')
            ->limit($limit)
            ->get();

        if ($receipts->isEmpty()) {
            $this->info('No pending receipts to upload');
            return 0;
        }

        $this->info("Uploading {$receipts->count()} receipts...");

        foreach ($receipts as $receipt) {
            try {
                $response = Http::withHeaders([
                    $mainKey => $mainValue,
                ])->post($mainServer . '/api/cashDesk/receipt', 
                    json_decode($receipt->data, true)
                );

                if ($response->successful()) {
                    $receipt->update([
                        'status' => 'completed',
                        'retry_count' => 0,
                        'code' => $response->status(),
                    ]);
                    $this->line("<info>✓</info> Receipt #{$receipt->id} uploaded successfully");
                } else {
                    $this->handleFailedUpload($receipt, $response->status());
                }
            } catch (\Exception) {
                $this->handleFailedUpload($receipt, null);
            }
        }

        $this->info('Upload process completed');
        return 0;
    }

    private function handleFailedUpload(Receipt $receipt, ?int $code = null): void
    {
        $maxRetries = 3;
        $newRetryCount = $receipt->retry_count + 1;

        if ($newRetryCount <= $maxRetries) {
            $receipt->update([
                'status' => 'pending',
                'retry_count' => $newRetryCount,
                'code' => $code,
            ]);
            $this->line("<warn>⚠</warn> Receipt #{$receipt->id} failed (attempt {$newRetryCount}/{$maxRetries})");
        } else {
            $receipt->update([
                'status' => 'failed',
                'code' => $code,
            ]);
            $this->line("<error>✗</error> Receipt #{$receipt->id} failed permanently");
        }
    }
}
