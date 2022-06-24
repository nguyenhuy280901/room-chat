<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    protected $table = "user_room";
    public $timestamps = FALSE;

    protected $fillable = [
        'user_id', 'room_id',
    ];

    function user(){
        return $this->belongsTo('App\Models\User');
    }

    function room(){
        return $this->belongsTo('App\Models\Room');
    }
}
