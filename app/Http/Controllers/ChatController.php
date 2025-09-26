<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Gemini\Data\Content;
use Gemini\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Gemini;

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

        $isNewChat = !$chatId;
        if ($isNewChat) {
            $chat = Chat::create([
                'user_id' => $user->id,
                'name' => substr($messageContent, 0, 20)
            ]);
            $chatId = $chat->id;
        } else {
            $chat = Chat::findOrFail($chatId);
            if ($chat->user_id !== $user->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $historyMessages = $chat->messages()->orderBy('created_at')->get();

        Message::create([
            'chat_id' => $chatId,
            'sender' => 'user',
            'content' => $messageContent,
        ]);

        $history = [];
        foreach ($historyMessages as $message) {
            $role = $message->sender === 'user' ? Role::USER : Role::MODEL;
            $history[] = Content::parse(part: $message->content, role: $role);
        }

        try {
            $client = Gemini::client(env('GEMINI_API_KEY'));
            $chatInstance = $client->geminiPro()->startChat(history: $history);
            $response = $chatInstance->sendMessage($messageContent);
            $reply = $response->text();
        } catch (\Exception $e) {
            Log::error($e);
            $reply = 'I was unable to get a response. Please check your Gemini API key and server configuration.';
        }

        Message::create([
            'chat_id' => $chatId,
            'sender' => 'assistant',
            'content' => $reply,
        ]);

        $responseData = ['reply' => $reply];
        if ($isNewChat) {
            $responseData['chat'] = [
                'id' => $chat->id,
                'name' => $chat->name
            ];
        } else {
            $responseData['chat_id'] = $chatId;
        }

        return response()->json($responseData);
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

    public function newChat(Request $request)
    {
        $user = Auth::user();
        $chat = Chat::create([
            'user_id' => $user->id,
            'name' => $request->input('name', 'New Chat'),
        ]);
        return response()->json($chat);
    }

    public function renameChat(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'name' => 'required|string|max:255',
        ]);

        $chat = Chat::findOrFail($request->input('chat_id'));
        $user = Auth::user();

        if ($chat->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->name = $request->input('name');
        $chat->save();

        return response()->json(['message' => 'Chat renamed successfully']);
    }

    public function deleteChat($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $user = Auth::user();

        if ($chat->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->delete();

        return response()->json(['message' => 'Chat deleted successfully']);
    }
}