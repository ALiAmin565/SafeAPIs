<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagert extends Model
{
    use HasFactory;

    protected $table="_recommindation_target";

    public $fillable=['recomondations_id','target'];
}
