<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = "stocs";

    protected $fillable = [
        'item_id',
        'tanggal',
        'stock',
    ];
}
