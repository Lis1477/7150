<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    protected $fillable = [
        'user_id',
        'item_id_1c',
    ];
}
