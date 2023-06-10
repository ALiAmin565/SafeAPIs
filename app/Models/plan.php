<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class plan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'planes';


    protected $fillable = [
        'title',
        'name',
        'desc',
        'discount',
        'price',
        'percentage',
    ];


    public function recommendation()
    {
        return $this->belongsToMany(recommendation::class);
    }

    public function telegram()
    {
        return $this->belongsToMany(telegram::class,'plan_telgram_group','planes_id','telgram_groups_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
