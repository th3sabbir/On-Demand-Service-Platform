<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
       $this->apiKey = config('services.openai.key'); 
       $this->apiUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function chat(array $messages)
    {
        $response = Http::withToken($this->apiKey)
            ->post($this->apiUrl, [
                'model' => 'gpt-4', // Specify the model (e.g., gpt-3.5-turbo, gpt-4)
                'messages' => $messages,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error communicating with OpenAI: ' . $response->body());
    }
}
