<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DbController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function uploadDb(Request $request)
    {
        $request->validate([
            'db_file' => 'required|file|mimes:sqlite,db,sql'
        ]);

        // Save DB file
        $path = $request->file('db_file')->storeAs('databases', 'uploaded.sqlite');

        return back()->with('success', 'Database uploaded successfully!');
    }

    public function processQuery(Request $request)
    {
        $userQuery = $request->input('user_query');
        $sql = $request->input('sql');

        if (!$sql) {
            // Call Gemini API to convert user query → SQL
            $sql = $this->getSqlFromGemini($userQuery);
        }

        $results = [];
        try {
            $results = DB::connection('sqlite_uploaded')->select($sql);
        } catch (\Exception $e) {
            return back()->withErrors(['sql' => $e->getMessage()]);
        }

        return view('home', compact('sql', 'results'));
    }

    private function getSqlFromGemini($query)
    {
        // TODO: Replace with actual Gemini API call
        // Example placeholder
        return "SELECT name FROM sqlite_master WHERE type='table' LIMIT 5;";
    }
}
