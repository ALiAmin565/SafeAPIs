<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Massage extends Model
{
    use HasFactory;
    public $fillable=['user_id','plan_id','massage','img'];


    public function user()
    {
        return $this->hasOne(User::class,'user_id','id');
    }
}
