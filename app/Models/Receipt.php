<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    public $fillable = ['no', 'barcode', 'type', 'total', 'data', 'status', 'retry_count', 'code'];
}
