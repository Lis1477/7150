<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\FavoriteItem;

class ItemInFavoriteComposer
{
    public function compose(View $view) {

        // если юзер вошел
        if(\Auth::check()) {
            // берем id юзера
            $user_id = \Auth::id();

            // берем избранные товары
            $favorite_items = FavoriteItem::where('user_id', $user_id)
                ->get(['item_id_1c as item_code']);

            // если имеются
            if($favorite_items->count()) {
                // преобразуем в json
                $favorite_items = json_decode($favorite_items->toJson());

            } else {
                $favorite_items = [];
            }

        } else {

            // получаем json из куки
            if(isset($_COOKIE['favorite_items'])) {
                $favorite_items = json_decode($_COOKIE['favorite_items']);
            } else {
                $favorite_items = [];
            }
        }

        $data['selected_items'] = $favorite_items;

        return $view->with($data);
    }
}