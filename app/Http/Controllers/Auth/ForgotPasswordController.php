<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Mail;
use App\User;

// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function mailNewPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // берем юзера
        $user = User::where('email', $request->email)->first();

        if($validator->fails() && $user) {

            // генерируем пароль
            $password = str_random(8);

            // меняем пароль
            $user->password = bcrypt($password);
            $user->update();

            // отправляем письмо
            Mail::send('auth.mail.remember_mail_to_user', ['password' => $password, 'name' => $user->name], function($message) use ($user) {
                $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
                $message->to($user->email)->subject('Восстановление пароля для сайта 7150.by');
            });


            $success = [
                'title' => "Восстановление пароля",
                'text' => '<p>Данные для входа отправлены на электронный адрес.</p>',
            ];

            return redirect()->back()->with('success', $success);

        } else {

            $errors = ['email' => 'Такой адрес не зарегистрирован или некорректный!'];

            return redirect()->back()->withInput($request->only('remember_form', 'email'))->withErrors($errors);
        }
 
    }

}
