<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\CartItem;
use App\FavoriteItem;
use App\UserProfile;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    // protected $redirectTo = '/home';

    protected function redirectTo()
    {
        return url()->previous();
    }

    protected function authenticated(Request $request, $user)
    {
        // проверяем, есть ли профайл
        $profile = UserProfile::where('user_id', $user->id)->first();

        // если нет, создаем
        if(!$profile) {
            $new_profile = new UserProfile;
            $new_profile->user_id = $user->id;
            $new_profile->save();
        }

        // объединение корзин *****************************
        // если есть кука корзины
        if(isset($_COOKIE['in_cart'])) {

            // берем корзину из куки
            $cookie_cart = json_decode($_COOKIE['in_cart']);

            // берем товары корзины из бд
            $bd_cart_items = CartItem::where('user_id', $user->id);

            // если есть
            if($bd_cart_items->count()) {
                // берем id_1c товаров корзины из бд
                $bd_cart_codes = $bd_cart_items->pluck('item_id_1c')->toArray();

                foreach($cookie_cart as $val) {

                    // если в элемент есть в бд
                    if(in_array($val->item_code, $bd_cart_codes)) {
                        // берем старое количество
                        $old_count = CartItem::where([['user_id', $user->id], ['item_id_1c', $val->item_code]])->first(['count'])->toArray()['count'];

                        // новое количество
                        $new_count = $old_count + $val->item_count;
                        // обновляем количество
                        CartItem::where([['user_id', $user->id], ['item_id_1c', $val->item_code]])
                            ->update([
                                'count' => $new_count,
                        ]);
                    } else {
                        // добавляем в бд
                        CartItem::create([
                            'user_id' => $user->id,
                            'item_id_1c' => $val->item_code,
                            'count' => $val->item_count,
                        ]);
                    }
                }
            } else {
                // если в БД товаров нет, добавляем все из корзины
                foreach($cookie_cart as $val) {
                    CartItem::create([
                        'user_id' => $user->id,
                        'item_id_1c' => $val->item_code,
                        'count' => $val->item_count,
                    ]);
                }

            }

            // удаляем куку корзины
            setcookie('in_cart', '', time() - 3600);

        }

        // объединение избранных товаров *****************************
        // если есть кука избранных
        if(isset($_COOKIE['favorite_items'])) {

            // берем товары из куки
            $cookie_favorite = json_decode($_COOKIE['favorite_items']);

            // берем избранные товары из бд
            $bd_favorite_items = FavoriteItem::where('user_id', $user->id);

            // если есть
            if($bd_favorite_items->count()) {
                // берем id_1c товаров из бд
                $bd_favorite_codes = $bd_favorite_items->pluck('item_id_1c')->toArray();

                foreach($cookie_favorite as $val) {
                    // если элементa нет в бд
                    if(!in_array($val->item_code, $bd_favorite_codes)) {
                        // добавляем в бд
                        FavoriteItem::create([
                            'user_id' => $user->id,
                            'item_id_1c' => $val->item_code,
                        ]);
                    }
                }
            } else {
                // если в БД товаров нет, добавляем все из куки
                foreach($cookie_favorite as $val) {
                    FavoriteItem::create([
                        'user_id' => $user->id,
                        'item_id_1c' => $val->item_code,
                    ]);
                }

            }

            // удаляем куку избранных
            setcookie('favorite_items', '', time() - 3600);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
