<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use GuzzleHttp\Client;

class AiController extends Controller
{

    public function ask(Request $request): StreamedResponse
    {
        $request->validate([
            'message' => 'required|string|max:4000',
        ]);

        $userMessage = $request->input('message');

        return response()->stream(function () use ($userMessage) {
            $client = new Client();

            $response = $client->post(env('NVIDIA_API_URL'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('NVIDIA_API_KEY'),
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'text/event-stream',
                ],
                'json' => [
                    'model' => 'nvidia/nemotron-3-ultra-550b-a55b',
                    'messages' => [
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'temperature' => 1,
                    'top_p' => 0.95,
                    'max_tokens' => 16384,
                    'stream' => true,
                ],
                'stream' => true,
            ]);

            $body = $response->getBody();
            $buffer = '';

            while (!$body->eof()) {
                $buffer .= $body->read(1024);

                // SSE lines are separated by \n\n
                while (($pos = strpos($buffer, "\n\n")) !== false) {
                    $line = substr($buffer, 0, $pos);
                    $buffer = substr($buffer, $pos + 2);

                    if (!str_starts_with($line, 'data: ')) {
                        continue;
                    }

                    $data = trim(substr($line, 6));

                    if ($data === '[DONE]') {
                        echo "data: [DONE]\n\n";
                        ob_flush();
                        flush();
                        return;
                    }

                    $json = json_decode($data, true);
                    $content = $json['choices'][0]['delta']['content'] ?? null;

                    if ($content !== null) {
                        // re-emit as our own SSE event to the browser
                        echo 'data: ' . json_encode(['content' => $content]) . "\n\n";
                        ob_flush();
                        flush();
                    }
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}