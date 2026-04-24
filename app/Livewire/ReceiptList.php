<?php

namespace App\Livewire;

use App\Models\Receipt;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class ReceiptList extends Component
{
    public $data=[];

    public function mount()
    {
        $this->data = Receipt::where('status','pending')->get();
    }

    public function submitReceipts()
    {
        try {
            Artisan::call('app:submit-receipts');
            $this->dispatch('show-modal', ['type' => 'success', 'title' => 'Upload Complete', 'message' => 'All receipts have been uploaded.']);
            $this->data = Receipt::where('status','pending')->get();
        } catch (\Exception $e) {
            $this->dispatch('show-modal', ['type' => 'error', 'title' => 'Error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.receipt-list');
    }
}
