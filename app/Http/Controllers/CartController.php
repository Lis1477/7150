<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Item;
use App\CartItem;

class CartController extends Controller
{
    public function index()
    {

        if(\Auth::check()) {

            // берем id юзера
            $user_id = \Auth::id();

            // берем товары корзины
            $cart_objects_bd = CartItem::where('user_id', $user_id)
                ->get(['item_id_1c as item_code', 'count as item_count']);

            // если есть
            if($cart_objects_bd->count()) {
                $cart_objects = json_decode($cart_objects_bd->toJson());

                // собираем данные юзера
                $user['name'] = \Auth::user()->name;
                $user['email'] = \Auth::user()->email;
                $user['profile'] = \Auth::user()->profile()->first();
                if(\Auth::user()->phones()->count()) {
                    $user['phone'] = \Auth::user()->phones()->where('main', 1)->first(['phone'])->phone;
                } else {
                    $user['phone'] = '';
                }
                $user['address'] = \Auth::user()->address()->orderByDesc('main')->get();
                $data['user'] = $user;
            } else {
                $cart_objects = [];
            }
        } else {
            // если есть кука корзины
            if(isset($_COOKIE['in_cart'])) {
                // берем данные корзины из куки
                $cart_objects = json_decode($_COOKIE['in_cart']);
            } else {
                $cart_objects = [];
            }

        }

        if(count($cart_objects)) {
            // создаем коллекцию товаров корзины
            $collect = new Collection;
            foreach($cart_objects as $object) {

                // берем товар
                $item = Item::where('id_1c', $object->item_code)
                    ->first([
                        'name',
                        'slug',
                        'id_1c',
                        'price',
                        'weight',
                        'is_new_item',
                        'is_action',
                        'action_price',
                        'comment_counter',
                        'comment_rate',
                    ]);

                // если товар существует, добавляем в коллекцию
                if($item) {
                    $collect->push([
                        'item' => $item,
                        'count' => $object->item_count,
                    ]);
                }
            }
            $data['cart_products'] = $collect;

        } else {
            $data['cart_products'] = '';
        }

        return view('cart_page')->with($data);
    }

    public function changeCart(Request $request)
    {
        // проверяем, авторизован ли пользователь
        if(\Auth::check()) {
            $user_checked = 1;
        } else {
            $user_checked = 0;
        }

        // количество позиций для миникорзины
        $cart_item_count = '';

        // если юзер вошел
        if($user_checked) {
            // определяем id юзера
            $user_id = \Auth::id();

            // берем id_1c и количество товара
            $item_code = intval($request->item_code);
            $item_count = intval($request->item_count);

            if($item_count == 0) {

                // если количество 0, удаляем позицию
                CartItem::where([['user_id', $user_id], ['item_id_1c', $item_code]])->delete();

            } else {

                // проверяем, есть ли позиция в бд
                $isset_item = CartItem::where([['user_id', $user_id], ['item_id_1c', $item_code]])->first();

                if(!$isset_item) {
                    // если пусто, добавляем
                    $cart_item = new CartItem;
                    $cart_item->user_id = $user_id;
                    $cart_item->item_id_1c = $item_code;
                    $cart_item->count = $item_count;
                    $cart_item->save();
                } else {
                    // если не пусто, обновляем
                    CartItem::where([['user_id', $user_id], ['item_id_1c', $item_code]])
                        ->update([
                            'count' => $item_count,
                        ]);
                }
            }

            // количество позиций для миникорзины
            $cart_item_count = CartItem::where('user_id', $user_id)->get(['id'])->count();
        }

        $data['user_checked'] = $user_checked;
        $data['cart_item_count'] = $cart_item_count;

        return $data;
    }
}
