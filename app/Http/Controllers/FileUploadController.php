<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\File;
use App\Models\Message;
use Gemini\Laravel\Facades\Gemini;
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

        $fileContent = $file->get();
        $prompt = "Analyze the following file and provide a summary: \n\n" . $fileContent;

        try {
            $result = Gemini::geminiPro()->generateContent($prompt);
            $reply = $result->text();

            Message::create([
                'chat_id' => $chatId,
                'sender' => 'assistant',
                'content' => $reply,
            ]);

            return response()->json(['message' => 'File uploaded and analyzed successfully', 'chat_id' => $chatId, 'reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
}