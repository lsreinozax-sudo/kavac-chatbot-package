<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kavac Chatbot API Configuration
    |--------------------------------------------------------------------------
    */
    
    'api_url' => env('KAVAC_API_URL', 'http://localhost:8000/api'),
    
    'timeout' => env('KAVAC_API_TIMEOUT', 30),
    
    'session_prefix' => env('KAVAC_SESSION_PREFIX', 'kavac_'),
];
