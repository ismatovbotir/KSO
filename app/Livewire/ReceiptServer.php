<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Livewire\Component;


class ReceiptServer extends Component
{
    public $url = "";
    public $key = "";
    public $value = "";
    public function mount()
    {
        try {
            $setting = Setting::first();
            if ($setting) {
                $this->url = $setting->url;
                $this->key = $setting->key;
                $this->value = $setting->value;
            }
        } catch (\Exception $e) {
        }
    }

    public function testPOSServer()
    {
        if (empty($this->url)) {
            $this->dispatch(
                'show-modal',
                type: 'error',
                title: 'empty URL',
                message: 'please enter valid URL.'
            );
            return;
        }
        try {

            if (empty($this->key)) {
                $res = Http::get($this->url);
            } else {
                $res = Http::withHeaders([
                    $this->key => $this->value
                ])->get($this->url);
            }
        } catch (\Exception $e) {
            $this->dispatch(
                'show-modal',
                type: 'error',
                title: 'Connection Failed',
                message: $e->getMessage()
            );
        }
    }

    public function savePOSServer()
    {
        if (empty($this->url)) {
            $this->dispatch(
                'show-modal',
                type: 'error',
                title: 'empty URL',
                message: 'please enter valid URL.'
            );
            return;
        }
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'url' => $this->url,
                'key' => $this->key,
                'value' => $this->value,
                'path' => 'd:\log\receipts'
            ]
        );
        $this->dispatch(
                'show-modal',
                type: 'success',
                title: 'Data stored',
                message: 'Settings Stored'
            );
    }
    public function render()
    {
        return view('livewire.receipt-server');
    }
}
