 <div class="middle">
        {{--<div class="top-row">
            <button class="btn-update" onclick="showModal('success','Log Updated','The log has been updated successfully.')">Update Log</button>
            <button class="btn-log"    onclick="showModal('warning','Log Deleted','The log has been deleted.')">Delete Log</button>
            <button class="btn-upload" wire:click="submitReceipts">Upload All</button>
            <button class="btn-del-up" onclick="showModal('error','Deleted','All uploaded files have been removed.')">Delete Uploaded</button>
        </div>--}}
        <div class="top-row" style="overflow: auto; max-height: 400px;">
             <table>
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Code</th>
                    <th>Attempts</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                    <tr>
                        <td>{{ $item->no }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ $item->status}}</td>
                        <td>{{ $item->code}}</td>
                        <td>{{ $item->retry_count}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
       
    </div>

