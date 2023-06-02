<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan_recommendation extends Model
{
    use HasFactory;

    public $fillable=['plan_id','recomondations_id'];
}
