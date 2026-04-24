<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SubmitReceipts extends Command
{
    protected $signature = 'app:submit-receipts';
    protected $description = 'Submit pending receipts to the POS server';

    public function handle()
    {
        $setting = Setting::first();
        if (!$setting || !$setting->url) {
            $this->error('POS server URL not configured.');
            return;
        }

        $receipts = Receipt::where('status', 'pending')->get();

        if ($receipts->isEmpty()) {
            $this->info('No pending receipts.');
            return;
        }

        $headers = ($setting->key && $setting->value) ? [$setting->key => $setting->value] : [];

        foreach ($receipts as $receipt) {
            try {
                $response = Http::withHeaders($headers)
                    ->post($setting->url, json_decode($receipt->data, true) ?? []);

                $receipt->update([
                    'status'      => $response->successful() ? 'uploaded' : 'failed',
                    'code'        => $response->status(),
                    'retry_count' => $receipt->retry_count + ($response->successful() ? 0 : 1),
                ]);
            } catch (\Exception $e) {
                $receipt->update([
                    'status'      => 'failed',
                    'retry_count' => $receipt->retry_count + 1,
                ]);
                $this->error("Receipt #{$receipt->id}: " . $e->getMessage());
            }
        }

        $this->info('Done');
    }
}
