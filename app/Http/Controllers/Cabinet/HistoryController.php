<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Order;

class HistoryController extends Controller
{
    public function index()
    {
        // берем id юзера
        $user_id = \Auth::id();

        // берем ордера с товарами
        $orders = Order::where('user_id', $user_id)->orderByDesc('created_at')->with('items')->get();
        $data['orders'] = $orders;

        return view('cabinet.history_page')->with($data);
    }
}
