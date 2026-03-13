<?php

namespace TuVendor\KavacChatbot;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class KavacChatbotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Fusionar configuración
        $this->mergeConfigFrom(
            __DIR__.'/config/kavac-chatbot.php', 'kavac-chatbot'
        );

        // Registrar el servicio en el contenedor
        $this->app->singleton('kavac-chatbot', function ($app) {
            return new Services\KavacChatbotService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Cargar rutas
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Cargar vistas
        $this->loadViewsFrom(__DIR__.'/resources/views', 'kavac-chatbot');

        // Publicar configuración
        $this->publishes([
            __DIR__.'/config/kavac-chatbot.php' => config_path('kavac-chatbot.php'),
        ], 'kavac-chatbot-config');

        // Publicar vistas
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/kavac-chatbot'),
        ], 'kavac-chatbot-views');

        // Publicar assets si los hubiera
        // $this->publishes([
        //     __DIR__.'/public' => public_path('vendor/kavac-chatbot'),
        // ], 'kavac-chatbot-assets');
    }
}
