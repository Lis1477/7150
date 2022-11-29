<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class FeedbackController extends Controller
{
    public function callback(Request $request)
    {
        $captcha = \App::make('\App\Helpers\ReCaptchaHelper');

        $captchaState = $captcha->check($request->get('g-recaptcha-response'), $request->ip());

        if(!$captchaState){
            return redirect()->back()->with('note', "Упс... Что-то пошло не так!\n\nПопробуйте еще раз.");
        }

        $this->validate($request, [
            'client_name' => 'string | required',
            'client_phone' => 'string | max:19 | required',
            'first_time' => 'string | max:5 | required',
            'second_time' => 'string | max:5 | required',
            'comment' => 'string | max:6000 | nullable',
        ]);

        // данные для письма
        $data['client_name'] = $request->client_name;
        $data['client_phone'] = $request->client_phone;
        $data['first_time'] = $request->first_time;
        $data['second_time'] = $request->second_time;
        $data['comment'] = $request->comment;

        // отправляем письмо администратору
        Mail::send('mail.callback_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['info_email'])->subject('Заказ Обратного Звонка на сайте 7150.by');
        });

        $note = "Спасибо, Ваш запрос принят!\n\nОжидайте звонок нашего специалиста.";

        return redirect()->back()->with('note', $note);
    }

    public function feedback(Request $request)
    {
        $captcha = \App::make('\App\Helpers\ReCaptchaHelper');

        $captchaState = $captcha->check($request->get('g-recaptcha-response'), $request->ip());

        if(!$captchaState){
            return redirect()->back()->with('note', "Упс... Что-то пошло не так!\n\nПопробуйте еще раз.");
        }

        $this->validate($request, [
            'client_name' => 'string | required',
            'client_phone' => 'string | max:19 | required',
            'client_email' => 'email | nullable',
            'comment' => 'string | max:6000 | nullable',
        ]);

        // данные для письма
        $data['client_name'] = $request->client_name;
        $data['client_phone'] = $request->client_phone;
        $data['client_email'] = $request->client_email;
        $data['comment'] = $request->comment;

        // отправляем письмо администратору
        Mail::send('mail.feedback_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['info_email'])->subject('Сообщение из формы обратной связи на сайте 7150.by');
        });

        $note = "Спасибо, Ваше сообщение принято!\n\nОжидайте ответ нашего специалиста.";

        return redirect()->back()->with('note', $note);
    }

    public function wantСheaper(Request $request)
    {
        $captcha = \App::make('\App\Helpers\ReCaptchaHelper');

        $captchaState = $captcha->check($request->get('g-recaptcha-response'), $request->ip());

        if(!$captchaState){
            return redirect()->back()->with('note', "Упс... Что-то пошло не так!\n\nПопробуйте еще раз.");
        }

        $this->validate($request, [
            'item_name' => 'string | required',
            'client_name' => 'string | required',
            'client_phone' => 'string | max:19 | required',
            'first_time' => 'string | max:5 | required',
            'second_time' => 'string | max:5 | required',
            'comment' => 'string | max:6000 | nullable',
        ]);

        // данные для письма
        $data['item_name'] = $request->item_name;
        $data['client_name'] = $request->client_name;
        $data['client_phone'] = $request->client_phone;
        $data['first_time'] = $request->first_time;
        $data['second_time'] = $request->second_time;
        $data['comment'] = $request->comment;

        // отправляем письмо администратору
        Mail::send('mail.want_cheaper_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['info_email'])->subject('Запрос Хочу дешевле на сайте 7150.by');
        });

        $note = "Спасибо, Ваш запрос принят!\n\nОжидайте звонок нашего специалиста.";

        return redirect()->back()->with('note', $note);
    }

}
