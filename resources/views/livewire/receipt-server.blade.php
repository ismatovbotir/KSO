<div class="top-row">
    <input type="text" placeholder="Enter POS server address..." wire:model="url">
     <input type="text" placeholder="Enter Header Key" wire:model="key">
    <input type="text" placeholder="Enter Header Value" wire:model="value">
    <button class="btn-save" wire:click="testPOSServer">Test</button>
    <button class="btn-save" wire:click="savePOSServer">Save</button>
</div>