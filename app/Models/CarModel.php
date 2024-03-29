<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'model_image'
    ];
}
