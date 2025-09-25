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
        $chats = \App\Models\Chat::where('user_id', $user->id)->latest()->get();
        return view('home', compact('chats'));
    }

    public function uploadDb(Request $request)
    {
        try {
            $request->validate([
                'db_file' => 'required|file|mimes:sqlite,db,sql',
            ]);

            $user = Auth::user();
            $file = $request->file('db_file');

            // Create a unique path for the user's database file
            $path = $file->storeAs(
                'databases/' . $user->id,
                uniqid() . '.' . $file->getClientOriginalExtension()
            );

            // Create a record in the database
            UserDatabase::create([
                'login_id' => $user->id,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);

            return back()->with('success', 'Database uploaded and linked to your account successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['db_file' => 'An error occurred during upload: ' . $e->getMessage()]);
        }
    }

    public function processQuery(Request $request)
    {
        $userQuery = $request->input('user_query');
        $sql = $request->input('sql');

        // Find the latest database for the current user
        $userDatabase = UserDatabase::where('login_id', Auth::id())->latest()->first();

        if (!$userDatabase) {
            return back()->withErrors(['db' => 'You have not uploaded a database yet.']);
        }

        // Dynamically set the database connection config
        Config::set('database.connections.sqlite_uploaded.database', storage_path('app/' . $userDatabase->file_path));

        if (!$sql) {
            // Call Gemini API to convert user query → SQL
            $sql = $this->getSqlFromGemini($userQuery);
        }

        $results = [];
        try {
            // Use the dynamically configured connection
            $results = DB::connection('sqlite_uploaded')->select($sql);
        } catch (\Exception $e) {
            return back()->withErrors(['sql' => $e->getMessage()]);
        }

        return view('home', compact('sql', 'results'));
    }

    private function getSqlFromGemini($query)
    {
        // TODO: Replace with actual Gemini API call
        // This is a placeholder
        return "SELECT name FROM sqlite_master WHERE type='table' LIMIT 5;";
    }
}