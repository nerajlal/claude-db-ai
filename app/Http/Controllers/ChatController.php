<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'chat_id' => 'nullable|exists:chats,id',
        ]);

        $messageContent = $request->input('message');
        $chatId = $request->input('chat_id');
        $user = Auth::user();

        if (!$chatId) {
            $chat = Chat::create(['user_id' => $user->id]);
            $chatId = $chat->id;
        } else {
            $chat = Chat::findOrFail($chatId);
            // Ensure the user owns the chat
            if ($chat->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        Message::create([
            'chat_id' => $chatId,
            'sender' => 'user',
            'content' => $messageContent,
        ]);

        try {
            $result = Gemini::geminiPro()->generateContent($messageContent);
            $reply = $result->text();

            Message::create([
                'chat_id' => $chatId,
                'sender' => 'assistant',
                'content' => $reply,
            ]);

            return response()->json(['reply' => $reply, 'chat_id' => $chatId]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }

    public function getChatHistory($chatId)
    {
        $chat = Chat::with('messages', 'files')->findOrFail($chatId);
        $user = Auth::user();

        if ($chat->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($chat);
    }

    public function newChat()
    {
        $user = Auth::user();
        $chat = Chat::create(['user_id' => $user->id]);
        return response()->json($chat);
    }
}