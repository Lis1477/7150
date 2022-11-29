<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\FavoriteItem;

class FavoriteItemController extends Controller
{
    public function index()
    {

        if(\Auth::check()) {

            // берем id юзера
            $user_id = \Auth::id();

            // берем избранные товары
            $favorite_objects = FavoriteItem::where('user_id', $user_id)
                ->get(['item_id_1c as item_code']);

            if($favorite_objects->count()) {
                // если есть
                $favorite_objects = json_decode($favorite_objects->toJson());
            } else {
                $favorite_objects = [];
            }
        } else {
            // если есть кука избранных
            if(isset($_COOKIE['favorite_items'])) {
                // берем избранные из куки
                $favorite_objects = json_decode($_COOKIE['favorite_items']);
            } else {
                $favorite_objects = [];
            }
        }

        if(count($favorite_objects)) {

            // берем коды избранного
            foreach($favorite_objects as $object) {
                $favorite_id_arr[] = $object->item_code;
            }

            // берем только уникальные
            $favorite_id_arr = array_unique($favorite_id_arr);

            // берем товары
                $favorite_items = Item::whereIn('id_1c', $favorite_id_arr)
                    ->orderBy('name')
                    ->get();

            $data['favorite_items'] = $favorite_items;

        } else {
            $data['favorite_items'] = '';
        }

// dd($data);
        return view('favorite_items_page')->with($data);
    }

    public function changeFavorite(Request $request)
    {
        // проверяем, авторизован ли пользователь
        if(\Auth::check()) {
            $user_checked = 1;
        } else {
            $user_checked = 0;
        }

        // количество позиций для миникорзины
        $favorite_item_count = '';

        // если юзер вошел
        if($user_checked) {
            // определяем id юзера
            $user_id = \Auth::id();

            // берем id_1c
            $item_code = intval($request->item_code);
            // определяем событие
            $event_type = $request->event_type;

            if($event_type == 'add') {

                // проверяем, есть ли позиция в бд
                $isset_item = FavoriteItem::where([['user_id', $user_id], ['item_id_1c', $item_code]])->first(['id']);

                // если пусто, добавляем
                if(!$isset_item) {
                    $favorite_item = new FavoriteItem;
                    $favorite_item->user_id = $user_id;
                    $favorite_item->item_id_1c = $item_code;
                    $favorite_item->save();
                }

            } else {
                // или удаляем
                FavoriteItem::where([['user_id', $user_id], ['item_id_1c', $item_code]])->delete();
            }

            // количество позиций для хэдера
            $favorite_item_count = FavoriteItem::where('user_id', $user_id)->get(['id'])->count();
        }

        $data['user_checked'] = $user_checked;
        $data['favorite_item_count'] = $favorite_item_count;

        return $data;
    }
}
