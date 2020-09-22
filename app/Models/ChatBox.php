<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender', 'receiver', 'message'
    ];
    protected $casts = ['created_at','updated_at'];
    function receiver(){
        return $this->hasOne('App\Models\User','id','receiver');
    }
}
