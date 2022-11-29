<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    protected $fillable = [
        'user_id',
        'first_name',
        'second_name',
        'family_name',
        'city',
        'street',
        'house',
        'corpus',
        'flat',
        'entrance',
        'floor',
        'main',
    ];

}
