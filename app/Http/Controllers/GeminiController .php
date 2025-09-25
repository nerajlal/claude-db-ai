<?php

use Gemini\Client;

class GeminiController extends Controller
{
    public function ask()
    {
        $client = new Client(env('AIzaSyBMgwm_YmR2fLt8vVpGBiIGF8hFUh5YwwM'));

        $response = $client->geminiPro()->generateText("Hello Gemini from Laravel!");

        return response()->json([
            'reply' => $response->text(),
        ]);
    }
}
