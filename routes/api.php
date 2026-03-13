use App\Http\Controllers\ChatbotController;

Route::get('/chatbot/health', [ChatbotController::class, 'health']);
Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage']);
