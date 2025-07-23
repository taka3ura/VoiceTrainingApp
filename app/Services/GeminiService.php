<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Gemini APIとの連携をカプセル化するサービス
 */
class GeminiService
{
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
    }

    /**
     * Gemini APIにテキスト生成リクエストを送信し、返信テキストを取得する。
     *
     * @param string $prompt Geminiに送る指示文（プロンプト）
     * @return string|null Geminiの返信テキスト、またはnull (エラー時)
     */
    public function generateText(string $prompt): ?string
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API Key is not set.');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}", [
                "contents" => [
                    [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                Log::error('Gemini API request failed:', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                    'prompt' => $prompt
                ]);
                return null;
            }

            $result = $response->json();

            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                Log::warning('Unexpected Gemini API response structure:', [
                    'response' => $result,
                    'prompt' => $prompt
                ]);
                return null;
            }

            return $result['candidates'][0]['content']['parts'][0]['text'];
        } catch (\Exception $e) {
            Log::error('Error calling Gemini API:', [
                'message' => $e->getMessage(),
                'prompt' => $prompt
            ]);
            return null;
        }
    }
}
