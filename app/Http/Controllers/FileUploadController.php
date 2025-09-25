<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'chat_id' => 'nullable|exists:chats,id',
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->store('uploads');
        $user = Auth::user();
        $chatId = $request->input('chat_id');

        if (!$chatId) {
            $chat = Chat::create(['user_id' => $user->id]);
            $chatId = $chat->id;
        }

        File::create([
            'filename' => $filename,
            'path' => $path,
            'user_id' => $user->id,
            'chat_id' => $chatId,
        ]);

        return response()->json(['message' => 'File uploaded successfully', 'chat_id' => $chatId]);
    }
}