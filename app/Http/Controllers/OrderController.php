<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\OneClickOrder;
use App\Item;
use App\OrderProduct;
use App\CartItem;
use App\PromoCode;
use Mail;
use Illuminate\Support\Collection;


class OrderController extends Controller
{
    public function postOrder(Request $request)
    {

        // валидация
        $this->validate($request, [
            'email' => 'email | required',
            'items_total' => 'numeric | required',
            'items_economy' => 'numeric | present',
            'delivery_price' => 'numeric | present',
            'promo_code_id' => 'numeric | nullable',
            'items_weight' => 'numeric | present',
            'client_type' => 'string | alpha_dash | required',
            'name' => 'string | required',
            'phone' => 'string | max:19 | required',
            'company_name' => 'string | max:255 | nullable',
            'company_unp' => 'string | alpha_num | nullable',
            'requisites' => 'string | max:1000 | nullable',
            'delivery_type' => 'string | alpha_dash | required',
            'shipping' => 'string | max:50 | nullable',
            'first_name' => 'string | max:50 | nullable',
            'second_name' => 'string | max:50 | nullable',
            'family_name' => 'string | max:50 | nullable',
            'city' => 'string | max:50 | nullable',
            'street' => 'string | max:100 | nullable',
            'house' => 'string | max:10 | nullable',
            'corpus' => 'string | max:10 | nullable',
            'flat' => 'string | max:10 | nullable',
            'entrance' => 'string | max:10 | nullable',
            'floor' => 'string | max:10 | nullable',
            'euro_pv' => 'string | max:255 | nullable',
            'comment' => 'string | max:2000 | nullable',
            'paying_type' => 'string | alpha_dash | required',
            'money_type' => 'string | alpha_dash',
        ]);

        // имя заказчика
        $client_name = trim($request->name);
        // телефон
        $phone = $request->phone;
        // email
        $email = trim($request->email);

        // проверяем, есть ли зарегистрированный пользователь
        $reg = \Auth::check();

        // для почты..
        $data['password'] = "";
        $data['new_user'] = false;

        // если не зарегистрирован
        if(!$reg) {
            // проверяем, есть ли юзер с таким емайл в базе
            $user = User::where('email', $email)->first(['id']);

            if($user) {
                // запоминаем id
                $user_id = $user->id;
            } else {
                // генерируем пароль
                $password = $data['password'] = str_random(8);
                // для почты
                $data['new_user'] = true;

                // создаем нового юзера
                $result = User::create([
                    'name' => $client_name,
                    'email' => $email,
                    'password' => bcrypt($password),
                ]);
                // если успешно
                if($result) {
                    // узнаем id юзера
                    $user = User::where('email', $email)->first(['id']);
                    $user_id = $user->id;
                }
            }
        } else {
            // узнаем id юзера
            $user_id = \Auth::id();
        }

        // тип клиента
        if($request->client_type == 'individual') {
            $client_type = 'физическое лицо';
            $company_name = '';
            $company_unp = '';
            $company_requisites = '';
        } elseif($request->client_type == 'company') {
            $client_type = 'юридическое лицо';
            $company_name = trim($request->company_name);
            $company_unp = trim($request->company_unp);
            $company_requisites = trim($request->requisites);
        }

        // тип доставки
        if($request->delivery_type == 'pickup') {
            $delivery_type = 'самовывоз';

            // вариант доставки
            $shipping = 'самовывоз';

            $first_name = '';
            $second_name = '';
            $family_name = '';
            $city = '';
            $street = '';
            $house = '';
            $corpus = '';
            $flat = '';
            $entrance = '';
            $floor = '';
            $euro_pv = '';

            $comment = '';

        } elseif($request->delivery_type == 'shipping') {
            $delivery_type = 'доставка';

            // вариант доставки
            if($request->shipping == 'minsk') {
                $shipping = 'по Минску до дома';

                $first_name = '';
                $second_name = '';
                $family_name = '';
                $city = 'Минск';
                $street = trim($request->street);
                $house = trim($request->house);
                $corpus = trim($request->corpus);
                $flat = trim($request->flat);
                $entrance = trim($request->entrance);
                $floor = trim($request->floor);
                $euro_pv = '';

            } elseif($request->shipping == 'euro_punkt') {
                $shipping = 'Европочтой до Пункта Выдачи';

                $first_name = trim($request->first_name);
                $second_name = trim($request->second_name);
                $family_name = trim($request->family_name);
                $city = '';
                $street = '';
                $house = '';
                $corpus = '';
                $flat = '';
                $entrance = '';
                $floor = '';
                $euro_pv = trim($request->euro_pv);

            } elseif($request->shipping == 'euro_door') {
                $shipping = 'Европочтой до двери';

                $first_name = trim($request->first_name);
                $second_name = trim($request->second_name);
                $family_name = trim($request->family_name);
                $city = trim($request->city);
                $street = trim($request->street);
                $house = trim($request->house);
                $corpus = trim($request->corpus);
                $flat = trim($request->flat);
                $entrance = trim($request->entrance);
                $floor = trim($request->floor);
                $euro_pv = '';

            } elseif($request->shipping == 'alfasad') {
                $shipping = 'по РБ службой Альфасад до дома';

                $first_name = '';
                $second_name = '';
                $family_name = '';
                $city = trim($request->city);
                $street = trim($request->street);
                $house = trim($request->house);
                $corpus = trim($request->corpus);
                $flat = trim($request->flat);
                $entrance = trim($request->entrance);
                $floor = trim($request->floor);
                $euro_pv = '';
            }

            $comment = trim($request->comment);
        }

        // типы оплаты
        if($request->paying_type == 'upon_delivery') {
            $paying_type = 'при получении';

        } elseif ($request->paying_type == 'site_online') {
            $paying_type = 'онлайн';
        } elseif ($request->paying_type == 'invoice') {
            $paying_type = 'безналичная оплата по счету';
        }

        // варианты оплаты
        if($request->money_type == 'cash') {
            $money_type = 'наличными';
        } elseif($request->money_type == 'card') {
            $money_type = 'картой';
        } elseif($request->money_type == 'card_online') {
            $money_type = 'картой (онлайн)';
        } elseif($request->money_type == 'card_installment') {
            $money_type = 'картой рассрочки';
        } elseif($request->money_type == 'erip') {
            $money_type = 'через ЕРИП';
        } else {
            $money_type = '';
        }

        // записываем ордер в дазу данных
        $order = New Order;

        $order->user_id = $user_id;
        $order->email = $data['email'] = $email;
        $order->price_total = $data['total_price'] = $request->items_total;
        $order->price_economy = $data['total_economy'] = $request->items_economy;
        $order->price_delivery = $data['delivery_price'] = $request->delivery_price;
        $order->weight = $data['total_weight'] = $request->items_weight;
        $order->client_type = $data['client_type'] = $client_type;
        $order->client_name = $data['client_name'] = $client_name;
        $order->phone = $data['phone'] = $phone;
        $order->company_name = $data['company_name'] = $company_name;
        $order->company_unp = $data['company_unp'] = $company_unp;
        $order->requisites = $data['company_requisites'] = $company_requisites;
        $order->delivery_type = $data['delivery_type'] = $delivery_type;
        $order->shipping = $data['shipping'] = $shipping;
        $order->first_name = $data['first_name'] = $first_name;
        $order->second_name = $data['second_name'] = $second_name;
        $order->family_name = $data['family_name'] = $family_name;
        $order->city = $data['city'] = $city;
        $order->street = $data['street'] = $street;
        $order->house = $data['house'] = $house;
        $order->corpus = $data['corpus'] = $corpus;
        $order->flat = $data['flat'] = $flat;
        $order->entrance = $data['entrance'] = $entrance;
        $order->floor = $data['floor'] = $floor;
        $order->euro_pv = $data['euro_pv'] = $euro_pv;
        $order->comment = $data['comment'] = $comment;
        $order->paying_type = $data['paying_type'] = $paying_type;
        $order->money_type = $data['money_type'] = $money_type;

        // записываем
        $order_save_result = $order->save();

        // если неуспешно, редиректим назад с ошибкой, или продолжаем
        if(!$order_save_result) {
            return back()->withInput()->with('note', 'Упс! Что-то пошло не так. Попробуйте еще раз.');
        }

        // узнаем id ордера
        $order_id = Order::where('user_id', $user_id)->orderByDesc('id')->first(['id'])->id;

        //массив товаров со скидкой
        $items_arr = [];
        // если есть строка товаров со скидкой
        if(trim($request->items_string)) {
            // делим строку
            $arr = explode('|', trim($request->items_string));

            // делим как id_1c => скидка, добавляем в массив
            foreach($arr as $el) {
                $arr_2 = explode('-', $el);
                $items_arr[$arr_2[0]] = $arr_2[1];
            }
        }

        // добавляем товары в БД ***********************
        // если пользователь авторизован
        if(\Auth::check()) {

            // берем товары корзины из бд
            $cart_objects_bd = CartItem::where('user_id', $user_id)
                ->get(['item_id_1c as item_code', 'count as item_count']);

            $cart_objects = json_decode($cart_objects_bd->toJson());

        } else {
            // берем данные корзины из куки
            $cart_objects = json_decode($_COOKIE['in_cart']);
        }

        // если использован промокод
        if($request->promo_code_id) {
            // берем промокод
            $promo_code = PromoCode::find($request->promo_code_id);
            // уменьшаем счетчик количества использований на 1
            if($promo_code->num_use > 0) {
                PromoCode::where('id', $request->promo_code_id)
                    ->update([
                        'num_use' => $promo_code->num_use - 1,
                    ]);
            }
        }

        //создаем коллекцию товаров для письма
        $collect = new Collection;
        // берем товары
        foreach($cart_objects as $object) {
            // берем товар
            $item = Item::where('id_1c', $object->item_code)
                ->first([
                    'id_1c',
                    'name',
                    'price',
                ]);
            // записываем
            $order_product = new OrderProduct;
            $order_product->order_id = $order_id;
            $order_product->item_id_1c = $item->id_1c;
            $order_product->name = $item->name;
            $order_product->count = $object->item_count;
            $order_product->price = $item->price;
            // если есть экономия
            if(count($items_arr)) {
                if(array_key_exists($item->id_1c, $items_arr)) {
                    $economy = floatval($items_arr[$item->id_1c]);
                } else {
                    $economy = 0;
                }
            } else {
                $economy = 0;
            }
            $order_product->economy = $economy;

            $order_product->save();

            $collect->push([
                'name' => $item->name,
                'price' => $item->price,
                'count' => $object->item_count,
                'economy' => $economy,
            ]);
        }
        $data['items'] = $collect;


        // отправляем письмо администратору
        Mail::send('mail.order_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['order_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['order_email'])->subject('Заказ с сайта 7150.by');
        });

        // отправляем письмо клиенту
        Mail::send('mail.order_to_client', $data, function($message) use ($data) {
            $message->from(config('email')['order_email'], 'Интернет-магазин 7150.by');
            $message->to($data['email'])->subject('Ваш заказ на сайте 7150.by');
        });

        // удаляем товары из корзины
        // если пользователь авторизован
        if(\Auth::check()) {
            // в бд
            CartItem::where('user_id', $user_id)->delete();
        } else {
            // в куке
            setcookie('in_cart', '', time() - 3600);
        }

        $note = "Спасибо, Ваш заказ принят в обработку!";

        return redirect('/')->with('note', $note);
    }

    public function oneClickOrder(Request $request)
    {
        // валидация
        $this->validate($request, [
            'client_email' => 'email | nullable',
            'client_name' => 'string | required',
            'client_phone' => 'string | max:19 | required',
            'comment' => 'string | max:2000 | nullable',
            'item_name' => 'string | max:255 | required',
            'item_id_1c' => 'numeric| required',
        ]);

        // берем данные
        $client_email = $request->client_email;
        $client_name = $request->client_name;
        $client_phone = $request->client_phone;
        $comment = $request->comment;
        $item_name = $request->item_name;
        $item_id_1c = $request->item_id_1c;



        // проверяем, есть ли зарегистрированный пользователь
        $reg = \Auth::check();
        // если есть
        if($reg) {
            // узнаем id клиента
            $user_id = \Auth::id();
        } else {
            $user_id = 0;

            // если емайл не пустой
            if($client_email) {
                // смотрим, зарегистрирован ли
                $reg_email = User::where('email', $client_email)->first();
                // если зарегистрирован
                if($reg_email) {
                    // переписываем id клиента
                    $user_id = $reg_email->id;
                }
            }
        }

        // регистрируем заказ
        $one_click_order = new OneClickOrder;
        $one_click_order->user_id = $user_id;
        $one_click_order->client_name = $client_name;
        $one_click_order->email = $client_email;
        $one_click_order->phone = $client_phone;
        $one_click_order->item_id_1c = $item_id_1c;
        $one_click_order->comment = $comment;
        $result = $one_click_order->save();

        // если успешно
        if($result) {
            // узнаем id ордера
            $order_id = OneClickOrder::where('phone', $client_phone)->orderByDesc('id')->first(['id'])->id;

            //формируем данные для письма
            $data['order_id'] = "1.".$order_id;
            $data['client_email'] = $client_email;
            $data['client_name'] = $client_name;
            $data['client_phone'] = $client_phone;
            $data['comment'] = $comment;
            $data['item_name'] = $item_name;
            $data['item_id_1c'] = $item_id_1c;

            // отправляем письмо администратору
            $mail_to_admin = Mail::send('mail.one_click_order_to_admin', $data, function($message) use ($data) {
                $message->from(config('email')['order_email'], 'Интернет-магазин 7150.by');
                $message->to(config('email')['order_email'])->subject('Заказ в 1 клик с сайта 7150.by');
            });

            // отправляем письмо клиенту
            if($client_email) {
                Mail::send('mail.one_click_order_to_client', $data, function($message) use ($data) {
                    $message->from(config('email')['order_email'], 'Интернет-магазин 7150.by');
                    $message->to($data['client_email'])->subject('Ваш заказ на сайте 7150.by');
                });
            }

            $note = "Спасибо за заказ!
Ожидайте звонок от нашего менеджера.";

            return redirect()->back()->with('note', $note);

        } else {

            $note = "Упс! Что-то пошло не так!
Попробуйте еще раз.";

            return redirect()->back()->with('note', $note);
        }
    }
}
