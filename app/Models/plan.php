<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan extends Model
{
    use HasFactory;

    protected $table='planes';


    protected $fillable=[
            'title',
            'name',
            'desc',
            'discount',
            'price',
            'currency',
            'percentage',
            'number_point',

    ];


    public function recommendation()
    {
        return $this->belongsToMany(recommendation::class);

    }
}
