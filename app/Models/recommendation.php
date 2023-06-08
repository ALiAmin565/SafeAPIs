<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recommendation extends Model
{
    use HasFactory;

    public $table='recomondations';

    protected $fillable=[
        'title',
        'entry_price',
        'stop_price',
        'currency',
        'img',
        'archive',
        'active',
        'number_show',
        'user_id',
        'planes_id',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {

        return $this->belongsToMany(plan::class);

    }

    public function archive()
    {
        return $this->hasMany(Archive::class);
    }

     public function target()
     {
        return $this->hasMany(tagert::class,'recomondations_id','id');

     }


}


