<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class telegram extends Model
{
    use HasFactory;

    public $table='telgram_groups';

    public $fillable=['merchant','token','plan_id'];
}
