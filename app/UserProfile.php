<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'client_type',
        'gender',
        'birthday',
        'company_name',
        'unp',
        'requisites',
    ];
}
