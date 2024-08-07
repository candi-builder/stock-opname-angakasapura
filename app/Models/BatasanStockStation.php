<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatasanStockStation extends Model
{
    use HasFactory;
    protected $table = "batasan_stock_stations";

    protected $fillable = [
        'station_id',
        'item_id',
        'batasan'
    ];
}
