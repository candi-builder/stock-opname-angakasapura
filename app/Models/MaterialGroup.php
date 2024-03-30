<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialGroup extends Model
{
    use HasFactory;
    protected $table = "material_group";

    protected $fillable = [
        'name'
    ];


}
