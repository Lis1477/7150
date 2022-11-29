<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function index()
    {
        // берем новости
        $news = News::where([['is_active', 1], ['for_retail', 1]])->orderByDesc('created_at')->get();
        $data['news'] = $news;

        $data['title'] = "Новости | Интернет-магазин 7150.by";

        return view('news_page')->with($data);
    }

    public function showNews($alias)
    {

        // берем новость
        $news = News::where([['is_active', 1], ['for_retail', 1], ['alias', $alias]])->first();
        $data['news'] = $news;

        // если такой нет, идем на страницу новостей
        if(!$news) {
            return redirect('novosty');
        }

        $data['title'] = $news->title." | Интернет-магазин 7150.by";

        return view('news_show_page')->with($data);
    }
}
