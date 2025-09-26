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
                $user = Auth::user();
                $chats = Chat::where('user_id', $user->id)->latest()->get();
                $user->name = $user->firstname . ' ' . $user->lastname;
                $name_parts = explode(' ', $user->name);
                $initials = count($name_parts) > 1
                    ? strtoupper(substr($name_parts[0], 0, 1) . substr(end($name_parts), 0, 1))
                    : strtoupper(substr($user->name, 0, 2));
            } else {
                $chats = [];
                $initials = '';
            }
            $view->with(compact('chats', 'initials'));
        });
    }
}