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
        'planes_id',
        'desc',
        'archive',
        'start_archive',
        'img',
        'user_id',
        'number_of_recived',
        'number_show',
        'active'
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



}


