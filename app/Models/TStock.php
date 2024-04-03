<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TStock extends Model
{
    use HasFactory;

    protected $table = "t_stocks";

    protected $fillable = [
        'item_id',
        'report_id',
        'tanggal',
        'stock',
    ];
}
