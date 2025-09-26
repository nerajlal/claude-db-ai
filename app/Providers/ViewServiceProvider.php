<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Chat;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('topsidebar', function ($view) {
            if (Auth::check()) {
                $chats = Chat::where('user_id', Auth::id())->latest()->get();
            } else {
                $chats = [];
            }
            $view->with('chats', $chats);
        });
    }
}