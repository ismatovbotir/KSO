<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'no' => $this->no,
            'barcode' => $this->barcode,
            'type' => $this->type,
            'total' => $this->total,
            'status' => $this->status,
            'code' => $this->code,
            'data' => $this->data ? json_decode($this->data, true) : null,
            'retry_count' => $this->retry_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
