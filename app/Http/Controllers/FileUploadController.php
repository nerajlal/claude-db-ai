<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file',
                'chat_id' => 'nullable|exists:chats,id',
            ]);

            $file = $request->file('file');
        } catch (\Exception $e) {
            Log::error('File upload validation failed: ' . $e->getMessage());
            return response()->json(['error' => 'File upload validation failed.'], 422);
        }
        $filename = $file->getClientOriginalName();
        $path = $file->store('uploads');
        $user = Auth::user();
        $chatId = $request->input('chat_id');

        if (!$chatId) {
            $chat = Chat::create([
                'user_id' => $user->id,
                'name' => $filename,
            ]);
            $chatId = $chat->id;
        } else {
            $chat = Chat::findOrFail($chatId);
            if ($chat->files()->exists()) {
                return response()->json(['error' => 'A file has already been uploaded to this chat. Please start a new chat to upload a new file.'], 409);
            }
            if ($chat->name === 'New Chat') {
                $chat->name = $filename;
                $chat->save();
            }
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