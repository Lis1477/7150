<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\CartItem;

class ItemInCartComposer
{
    public function compose(View $view) {

        // если юзер вошел
        if(\Auth::check()) {
            // берем id юзера
            $user_id = \Auth::id();

            // берем товары корзины
            $cart_items = CartItem::where('user_id', $user_id)
                ->get(['item_id_1c as item_code', 'count as item_count']);

            // если имеются
            if($cart_items->count()) {
                // преобразуем в json
                $cart_items = json_decode($cart_items->toJson());

            } else {
                $cart_items = [];
            }

        } else {
            // получаем json из куки
            if(isset($_COOKIE['in_cart'])) {
                $cart_items = json_decode($_COOKIE['in_cart']);
            } else {
                $cart_items = [];
            }
        }

        $data['cart_items'] = $cart_items;

        return $view->with($data);
    }
}