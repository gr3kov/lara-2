<?php

namespace App\Http\Controllers;

use App\Models\NotificationsNews;
use Artesaos\SEOTools\Facades\SEOMeta;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Список новостей
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function list()
    {
        SEOMeta::setTitle('Новости');
        SEOMeta::setDescription('Рубрика новости.');
        SEOMeta::setCanonical(route('news'));
        SEOMeta::addKeyword('новости');

        $notificationsNews = NotificationsNews::get();

        return view(
            'news.list',
            [
                'title' => 'Новости',
                'news' => $notificationsNews,
            ]
        );
    }
}
