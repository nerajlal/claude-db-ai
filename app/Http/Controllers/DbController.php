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
        return view('home');
    }

}