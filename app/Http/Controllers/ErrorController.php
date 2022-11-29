<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ErrorController extends Controller
{
    public function page404(Request $request)
    {
        return response()->view('errors.404', [], 404);
    }

    public function mail500(Request $request)
    {

        $data['page'] = $request->page;

        // отправляем письмо администратору
        Mail::send('mail.error_page_to_admin', $data, function($message) use ($data) {
            $message->from(config('email')['info_email'], 'Интернет-магазин 7150.by');
            $message->to(config('email')['info_email'])->subject('ОШИБКА на сайте 7150.by');
        });

        $note = "Спасибо!\n\nПисьмо об ошибке отправлено.";

        return redirect('/')->with('note', $note);
    }
}
