<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	// связь с изображениями (в БД Альфастока)
    public function images()
    {
        return $this->hasMany('App\ItemImage', 'item_1c_id', 'id_1c');
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\Category', 'category_id_1c', 'id_1c');
    }

}
