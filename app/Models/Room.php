<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = "room";
    public $timestamps = FALSE;
    protected $keyType = "string";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'user_id', "avatar",
    ];

    function user(){
        return $this->belongsTo("App\Models\User");
    }

    function userRooms(){
        return $this->hasMany("App\Models\UserRoom");
    }
}
