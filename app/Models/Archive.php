<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    public $table='archives';
    protected $fillable=['desc','recomondation_id','user_id'];



    protected $hidden = [
        'updated_at',


    ];



    public function recommendation()
    {

        return $this->belongsTo(recommendation::class,'recomondation_id','id');
    }

    public function user()
    {

        return $this->belongsTo(user::class,'user_id','id');
    }

}
