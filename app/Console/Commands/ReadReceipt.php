<?php

namespace App\Console\Commands;

use App\Models\Receipt;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Ramsey\Collection\Set;

class ReadReceipt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:read-receipt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $setting=Setting::first();
        if(!$setting){
            //$this->error("Settings not found or incomplete. Please check the settings table.");
            return;
        }
        //$path = storage_path($setting->path); // папка с файлами
        $path = $setting->path; // папка с файлами
        if (!File::exists($path)) {
            $this->error("Folder not found: $path");
            return;
        }

        $files = File::files($path);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'json') {
                continue;
            }

            try {
                $content = File::get($file->getPathname());
                //$data = json_decode($content,true);
                //$this->info(gettype($data));
                Receipt::create([
                     'data'=>$content
                ]);
                
                // 👉 тут твоя логика
                File::delete($file->getPathname());

                
            } catch (\Exception $e) {
                $this->error("Error: " . $file->getFilename() . ' - ' . $e->getMessage());
            }
        }

        $this->info("Done");
    }
}
