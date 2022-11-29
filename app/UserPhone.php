<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'main',
    ];
}
