<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    use HasFactory;
    protected $table = "master_data";

    protected $fillable = [
        'no_article',
        'material_group',
        'description',
        'uom'
    ];
}
