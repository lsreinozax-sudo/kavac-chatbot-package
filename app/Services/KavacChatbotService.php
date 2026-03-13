<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavacChatbotService
{
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = config('services.kavac.url');
        $this->timeout = config('services.kavac.timeout');
    }

    /**
     * Enviar un mensaje al chatbot
     */
    public function sendMessage(string $message, string $sessionId = null)
    {
        $sessionId = $sessionId ?: uniqid('chat_');

        try {
            $response = Http::timeout($this->timeout)
                ->post($this->baseUrl . '/chatbot/', [
                    'mensaje' => $message,
                    'sesion_id' => $sessionId,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'session_id' => $sessionId,
                ];
            }

            // Log error but don't expose to user
            Log::error('Kavac API error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'Error en la comunicación con el chatbot',
            ];

        } catch (\Exception $e) {
            Log::error('Kavac API exception', [
                'message' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'No se pudo conectar con el servicio de chatbot',
            ];
        }
    }

    /**
     * Verificar el estado de la API
     */
    public function healthCheck()
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl . '/health/');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtener documentación
     */
    public function getDocumentacion()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/documentacion/');

            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Obtener FAQs
     */
    public function getFaqs()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/faqs/');

            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
