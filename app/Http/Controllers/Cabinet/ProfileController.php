<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\UserPhone;
use App\UserAddress;

class ProfileController extends Controller
{
    public function index()
    {
        // проверяем, создан ли профайл юзера
        $user_profile_exist = \Auth::user()->profile()->count();
        if($user_profile_exist == 0) {
            // если нет, создаем
            $profile = new UserProfile;
            $profile->user_id = \Auth::id();
            $profile->client_type = "Физическое лицо";
            $profile->save();
        }

        // берем юзера
        $user = User::where('id', \Auth::id())->with('profile', 'phones', 'address')->first(['id', 'name', 'email']);
        $data['user'] = $user;

        return view('cabinet.profile_page')->with($data);
    }

    public function editProfile(Request $request)
    {

        // валидация
        $this->validate($request, [
            'client_type' => 'string | alpha_dash | required',
            'name' => 'string | required',
            'gender_type' => 'string | alpha_dash | nullable',
            'birthday' => 'date | nullable',
            'phone[]' => 'string | max:19',
            'main' => 'string | max:19',
            'email' => 'email | required',
            'company_name' => 'string | max:255 | nullable',
            'company_unp' => 'string | alpha_num | nullable',
            'requisites' => 'string | max:1000 | nullable',
            'password' => 'string | min:6 | nullable',
        ]);

        // берем id юзера
        $user_id = \Auth::id();

        // берем данные для таблицы User
        $name = trim($request->name);
        $email = trim($request->email);
        $password = trim($request->password);

        // если данные изменились, обновляем
        if($name != \Auth::user()->name) {
            User::where('id', $user_id)->update(['name' => $name]);
        }
        if($email != \Auth::user()->email) {
            User::where('id', $user_id)->update(['email' => $email]);
        }
        if($password) {
            User::where('id', $user_id)->update([
                'password' => bcrypt($password)
            ]);
        }

        // берем данные для таблицы UserProfile
        if($request->client_type == "company") {
            $client_type = "Юридическое лицо";
        } else {
            $client_type = "Физическое лицо";
        }

        if($request->gender_type == "woman") {
            $gender = "Женский";
        } elseif($request->gender_type == "man") {
            $gender = "Мужской";
        } else {
            $gender = "";
        }

        $birthday = $request->birthday;

        if($request->client_type == "company") {
            $company_name = trim($request->company_name);
            $unp = trim($request->company_unp);
            $requisites = trim($request->requisites);
        } else {
            $company_name = "";
            $unp = "";
            $requisites = "";
        }

        // обновляем или добавляем
        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user_id,],
            [
                'client_type' => $client_type,
                'gender' => $gender,
                'birthday' => $birthday,
                'company_name' => $company_name,
                'unp' => $unp,
                'requisites' => $requisites,
            ]
        );

        // ищем в бд телефоны юзера и удаляем
        UserPhone::where('user_id', $user_id)->delete();

        // добавляем новые телефоны
        $phones = $request->phone;
        $phones = array_filter($phones);
        // берем главный телефон
        $main_phone = $request->main;

        if(count($phones)) {
            foreach($phones as $phone) {
                // ставим метку для главного телефона
                if(count($phones) == 1 || $main_phone == $phone) {
                    $main = 1;
                } else {
                    $main = 0;
                }

                // проверяем, есть ли такой телефон в БД
                $ph = UserPhone::where([['user_id', $user_id], ['phone', $phone]])->first();
                // если нет
                if(!$ph) {
                    // добавляем
                    UserPhone::create([
                        'user_id' => $user_id,
                        'phone' => $phone,
                        'main' => $main,
                    ]);
                }
            }
        }

        $note = "Персональные данные изменены.";

        return redirect()->back()->with('note', $note);
    }

    public function addAddress(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'string | max:50 | nullable',
            'second_name' => 'string | max:50 | nullable',
            'family_name' => 'string | max:50 | nullable',
            'city' => 'string | max:50 | required',
            'street' => 'string | max:100 | required',
            'house' => 'string | max:10 | required',
            'corpus' => 'string | max:10 | nullable',
            'flat' => 'string | max:10 | nullable',
            'entrance' => 'string | max:10 | nullable',
            'floor' => 'string | max:10 | nullable',
            'main' => 'string | max:1 | required',
        ]);

        // берем id юзера
        $user_id = \Auth::id();

        // берем адреса юзера
        $addresses = UserAddress::where('user_id', $user_id);

        // берем main из запроса
        $main = intval($request->main);

        // если есть адреса
        if($addresses->get()->count() && $main == 1) {
            // убираем метку главный со всех адресов
            $addresses->update([
                'main' => 0,
            ]);
        }

        // добавляем адрес
        UserAddress::create([
            'user_id' => $user_id,
            'first_name' => trim($request->first_name),
            'second_name' => trim($request->second_name),
            'family_name' => trim($request->family_name),
            'city' => trim($request->city),
            'street' => trim($request->street),
            'house' => trim($request->house),
            'corpus' => trim($request->corpus),
            'flat' => trim($request->flat),
            'entrance' => trim($request->entrance),
            'floor' => trim($request->floor),
            'main' => $main,
        ]);

        if($request->page == 'cart') {

            // берем все адреса
            $addresses = UserAddress::where('user_id', $user_id)->orderByDesc('main')->get();

            return view('includes.new_address_ajax', compact('addresses'));
        } else {

            return redirect()->back();

        }
    }


    public function updateAddress(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'string | max:50 | nullable',
            'second_name' => 'string | max:50 | nullable',
            'family_name' => 'string | max:50 | nullable',
            'city' => 'string | max:50 | required',
            'street' => 'string | max:100 | required',
            'house' => 'string | max:10 | required',
            'corpus' => 'string | max:10 | nullable',
            'flat' => 'string | max:10 | nullable',
            'entrance' => 'string | max:10 | nullable',
            'floor' => 'string | max:10 | nullable',
            'main' => 'string | max:1 | required',
            'address_id' => 'string | required',
        ]);

        // берем id юзера
        $user_id = \Auth::id();

        // берем адрес
        $address = UserAddress::where([['user_id', $user_id], ['id', intval($request->address_id)]]);

        // формируем данные
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
        $main = intval($request->main);


        // если адрес существует
        if($address->first(['id'])) {
            // обновляем адрес
            $address->update([
                'first_name' => $first_name,
                'second_name' => $second_name,
                'family_name' => $family_name,
                'city' => $city,
                'street' => $street,
                'house' => $house,
                'corpus' => $corpus,
                'flat' => $flat,
                'entrance' => $entrance,
                'floor' => $floor,
                'main' => $main,
            ]);

            // если главный адрес
            if($main == 1) {
                // берем остальные адреса юзера
                $no_main = UserAddress::where([['user_id', $user_id], ['id', '!=', intval($request->address_id)]]);
                // снимаем обязательность
                if($no_main->get(['main'])->count()) {
                    $no_main->update([
                        'main' => 0,
                    ]);
                }
            }
        }

        // если пришел ajax запрос из корзины
        if($request->page == 'cart') {
            // формируем строку адреса


            $address_str = "{$city}, ул. {$street}, дом. {$house}";
            if($corpus) {
                $address_str .= ", кор. {$corpus}";
            }
            if($flat) {
                $address_str .= ", кв. {$flat}";
            }
            if($entrance) {
                $address_str .= ", под. {$entrance}";
            }
            if($floor) {
                $address_str .= ", эт. {$floor}";
            }
            $address_str .= ".";

            if($first_name || $second_name || $family_name) {
                $address_str .= "<br><span class='recipient-title'>Получатель:</span> {$family_name} {$first_name} {$second_name}.";
            }

            return $address_str;

        } else {
            //или возвращаемся в кабинет
            return redirect()->back();
        }
    }

    public function deleteAddress(Request $request)
    {
        // берем id юзера
        $user_id = \Auth::id();

        // id адреса
        $address_id = intval($request->address_id);

        // удаляем адрес
        $del_address = UserAddress::where([['user_id', $user_id], ['id', $address_id]])->delete();

        return $del_address;
    }
}
