<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Gemini\Data\Content;
use Gemini\Enums\Role;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

        if (!$chatId) {
            return response()->json(['error' => 'Please upload a database file first to start a new chat.'], 422);
        }

        $chat = Chat::with('files')->findOrFail($chatId);

        if ($chat->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($chat->files->isEmpty()) {
            return response()->json(['error' => 'Please upload a database file for this chat before sending messages.'], 422);
        }

        $historyMessages = $chat->messages()->orderBy('created_at')->get();
        $history = [];
        $file = $chat->files()->first();

        if ($file) {
            $dbSchema = Storage::get($file->path);
            $systemPrompt = "You are a specialized SQL assistant. Your knowledge is strictly limited to the following database schema. When you provide a SQL query, you must wrap it in a ```sql block. Immediately after the SQL query, you must provide a plausible example of the query's output, and you must wrap it in a ```text block. Do not answer any questions that are not related to this schema. If a question is outside of this scope, you must respond with the exact phrase: \"That's beyond my scope. Try asking something about the database you uploaded.\"\n\nHere is the database schema:\n\n---\n\n{$dbSchema}\n\n---";

            // Add the system prompt as the first message from the 'user'
            $history[] = Content::parse(part: $systemPrompt, role: Role::USER);
            // Add a canned response from the model to acknowledge the instruction
            $history[] = Content::parse(part: 'Yes, I understand. I will provide a SQL query in a ```sql block and its example output in a ```text block, and I will only answer questions about the provided database schema.', role: Role::MODEL);
        }

        Message::create([
            'chat_id' => $chatId,
            'sender' => 'user',
            'content' => $messageContent,
        ]);

        foreach ($historyMessages as $message) {
            $role = $message->sender === 'user' ? Role::USER : Role::MODEL;
            $history[] = Content::parse(part: $message->content, role: $role);
        }

        try {
            $guzzleClient = new Client([
                'verify' => false,
            ]);

            $client = Gemini::factory()
                ->withApiKey(env('GEMINI_API_KEY'))
                ->withHttpClient($guzzleClient)
                ->make();

            $chatInstance = $client->generativeModel(env('GEMINI_MODEL', 'gemini-2.0-flash'))->startChat(history: $history);
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

        return response()->json(['reply' => $reply, 'chat_id' => $chatId]);
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