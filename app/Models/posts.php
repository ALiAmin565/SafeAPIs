<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 

class posts extends Model
{
    use HasFactory;

    protected $table='posts';

    protected $fillable=[
        'title',
        'active',
        'img',
        'text'
    ];
}
