<?php

namespace App\Http\Controllers;

use App\Services\KavacChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(KavacChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Mostrar la interfaz del chatbot
     */
    public function index()
    {
        // Obtener session_id de la sesión de Laravel o crear uno nuevo
        $sessionId = Session::get('chatbot_session_id', uniqid('laravel_'));

        // Pasar a la vista
        return view('chatbot.index', [
            'sessionId' => $sessionId,
            'health' => $this->chatbotService->healthCheck(),
            'faqs' => $this->chatbotService->getFaqs(),
        ]);
    }

    /**
     * Enviar mensaje al chatbot (API endpoint)
     */
    public function sendMessage(Request $request)
{
    $request->validate([
        'mensaje' => 'required|string|max:500',
        'sesion_id' => 'nullable|string',
    ]);

    // Si viene un session_id del frontend, úsalo
    $sessionId = $request->input('sesion_id');
    
    // Si no viene, intenta recuperarlo de la sesión de Laravel
    if (!$sessionId) {
        $sessionId = Session::get('chatbot_session_id');
    }
    
    // Si aún no hay, genera uno nuevo
    if (!$sessionId) {
        $sessionId = uniqid('laravel_', true);
    }

    // Guardar en sesión de Laravel para futuras peticiones
    Session::put('chatbot_session_id', $sessionId);

    \Log::info('Enviando a Django', [
        'mensaje' => $request->input('mensaje'),
        'session_id' => $sessionId
    ]);

    $result = $this->chatbotService->sendMessage(
        $request->input('mensaje'),
        $sessionId
    );

    if ($result['success']) {
        return response()->json([
            'success' => true,
            'respuesta' => $result['data']['respuesta'] ?? '',
            'opciones' => $result['data']['opciones'] ?? [],
            'session_id' => $result['session_id'], // Devolver el session_id actualizado
        ]);
    }

    return response()->json([
        'success' => false,
        'error' => $result['error'],
    ], 500);
}

    /**
     * API endpoint para verificar salud (opcional)
     */
    public function health()
    {
        return response()->json([
            'kavac_api' => $this->chatbotService->healthCheck() ? 'ok' : 'error',
            'timestamp' => now(),
        ]);
    }
}
