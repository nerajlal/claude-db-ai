<?php

namespace App\Http\Controllers;

use App\Models\UserDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DbController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->name = $user->firstname . ' ' . $user->lastname;
        $name_parts = explode(' ', $user->name);
        $initials = count($name_parts) > 1
            ? strtoupper(substr($name_parts[0], 0, 1) . substr(end($name_parts), 0, 1))
            : strtoupper(substr($user->name, 0, 2));
        return view('home', compact('initials'));
    }

}