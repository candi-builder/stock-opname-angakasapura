<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TStock extends Model
{
    use HasFactory;

    protected $table = "t_stocs";

    protected $fillable = [
        'item_id',
        'tanggal',
        'stock',
    ];
}
