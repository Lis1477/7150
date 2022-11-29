<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\CategoryTitlesComposer;
use App\Http\ViewComposers\CategoryButtonComposer;
use App\Http\ViewComposers\ItemInCartComposer;
use App\Http\ViewComposers\ItemInFavoriteComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['layouts.base'], CategoryTitlesComposer::class);
        view()->composer(['includes.button_category'], CategoryButtonComposer::class);
        view()->composer(['*'], ItemInCartComposer::class);
        view()->composer(['*'], ItemInFavoriteComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
