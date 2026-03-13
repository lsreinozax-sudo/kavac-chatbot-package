<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kavac AI - Asistente Inteligente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Contenedor principal del chat */
        .chat-container {
            width: 100%;
            max-width: 900px;
            height: 700px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        /* Cabecera del chat */
        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .bot-avatar {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .bot-info h1 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .bot-info p {
            font-size: 14px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #4ade80;
            border-radius: 50%;
            display: inline-block;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .session-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .session-badge i {
            font-size: 14px;
        }

        /* Área de mensajes */
        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Burbujas de mensajes */
        .message {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            max-width: 80%;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.user {
            margin-left: auto;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }

        .message.user .message-avatar {
            background: #4b5563;
        }

        .message-content {
            background: white;
            padding: 15px 20px;
            border-radius: 25px 25px 25px 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            line-height: 1.5;
            color: #1f2937;
            font-size: 15px;
            position: relative;
        }

        .message.user .message-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 25px 25px 5px 25px;
        }

        .message-content p {
            margin: 0;
        }

        .message-content .message-time {
            font-size: 11px;
            margin-top: 5px;
            opacity: 0.7;
            display: block;
        }

        .message.user .message-time {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Opciones rápidas */
        .options-container {
            padding: 20px 30px;
            background: white;
            border-top: 1px solid #e5e7eb;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .option-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            animation: fadeInUp 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .option-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .option-btn:active {
            transform: translateY(0);
        }

        /* Indicador de escritura */
        .typing-indicator {
            display: flex;
            gap: 5px;
            padding: 15px 20px;
            background: white;
            border-radius: 25px 25px 25px 5px;
            width: fit-content;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            background: #667eea;
            border-radius: 50%;
            animation: bounce 1.5s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-10px); }
        }

        /* Área de entrada de texto */
        .input-area {
            background: white;
            padding: 20px 30px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 15px;
        }

        .input-wrapper {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
        }

        #message-input {
            width: 100%;
            padding: 15px 25px;
            border: 2px solid #e5e7eb;
            border-radius: 30px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            background: #f8fafc;
        }

        #message-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        #send-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        #send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        #send-btn:active {
            transform: scale(0.95);
        }

        /* Scroll personalizado */
        .messages-area::-webkit-scrollbar {
            width: 8px;
        }

        .messages-area::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .messages-area::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        .messages-area::-webkit-scrollbar-thumb:hover {
            background: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            body {
                padding: 0;
            }

            .message {
                max-width: 90%;
            }

            .chat-header {
                padding: 15px 20px;
            }

            .bot-avatar {
                width: 40px;
                height: 40px;
                font-size: 22px;
            }

            .bot-info h1 {
                font-size: 18px;
            }

            .session-badge {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Cabecera -->
        <div class="chat-header">
            <div class="header-info">
                <div class="bot-avatar">🤖</div>
                <div class="bot-info">
                    <h1>Kavac AI</h1>
                    <p>
                        <span class="status-dot"></span>
                        {{ $health ? 'En línea' : 'Reconectando...' }}
                    </p>
                </div>
            </div>
            <div class="session-badge">
                <span>🔑 {{ substr($sessionId, 0, 8) }}...</span>
            </div>
        </div>

        <!-- Área de mensajes -->
        <div class="messages-area" id="messages-area">
            <div class="message bot">
                <div class="message-avatar">🤖</div>
                <div class="message-content">
                    <p>¡Hola! Soy el asistente inteligente de Kavac. ¿En qué puedo ayudarte hoy?</p>
                    <span class="message-time">Ahora</span>
                </div>
            </div>
        </div>

        <!-- Opciones rápidas -->
        <div class="options-container" id="options-container"></div>

        <!-- Área de entrada -->
        <div class="input-area">
            <div class="input-wrapper">
                <input type="text" id="message-input" placeholder="Escribe tu mensaje aquí..." autocomplete="off">
            </div>
            <button id="send-btn" onclick="sendMessage()">📤</button>
        </div>
    </div>

    <script>
        const messagesArea = document.getElementById('messages-area');
        const messageInput = document.getElementById('message-input');
        const optionsContainer = document.getElementById('options-container');
        let sessionId = '{{ $sessionId }}';
        let isTyping = false;

        // Auto-resize del input
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Enter para enviar
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function showTypingIndicator() {
            if (isTyping) return;
            isTyping = true;

            const typingDiv = document.createElement('div');
            typingDiv.className = 'message bot typing-indicator-container';
            typingDiv.id = 'typing-indicator';
            typingDiv.innerHTML = `
                <div class="message-avatar">🤖</div>
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            `;
            messagesArea.appendChild(typingDiv);
            scrollToBottom();
        }

        function hideTypingIndicator() {
            const typing = document.getElementById('typing-indicator');
            if (typing) {
                typing.remove();
            }
            isTyping = false;
        }

        function addMessage(text, isUser = false) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;

            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.textContent = isUser ? '👤' : '🤖';

            const content = document.createElement('div');
            content.className = 'message-content';

            const paragraph = document.createElement('p');
            paragraph.innerHTML = text.replace(/\n/g, '<br>');

            const time = document.createElement('span');
            time.className = 'message-time';
            const now = new Date();
            time.textContent = now.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

            content.appendChild(paragraph);
            content.appendChild(time);
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(content);

            messagesArea.appendChild(messageDiv);
            scrollToBottom();
        }

        function scrollToBottom() {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        function showOptions(options) {
            optionsContainer.innerHTML = '';

            if (!options || options.length === 0) {
                return;
            }

            options.forEach(option => {
                const btn = document.createElement('button');
                btn.className = 'option-btn';
                btn.textContent = option.texto;
                btn.onclick = () => {
                    messageInput.value = option.id || option.texto;
                    sendMessage();
                };
                optionsContainer.appendChild(btn);
            });

            scrollToBottom();
        }

        function sendMessage() {
    const message = messageInput.value.trim();

    if (!message) return;

    // Mostrar mensaje del usuario
    addMessage(message, true);
    messageInput.value = '';
    messageInput.style.height = 'auto';

    // Limpiar opciones anteriores
    optionsContainer.innerHTML = '';

    // Mostrar indicador de escritura
    showTypingIndicator();

    // IMPORTANTE: Usar el sessionId actual
    const currentSessionId = sessionId;
    
    console.log('Enviando mensaje:', { mensaje: message, sesion_id: currentSessionId });

    fetch('{{ route("chatbot.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            mensaje: message,
            sesion_id: currentSessionId
        })
    })
    .then(response => response.json())
    .then(data => {
        hideTypingIndicator();

        if (data.success) {
            addMessage(data.respuesta);
            if (data.opciones && data.opciones.length > 0) {
                showOptions(data.opciones);
            }
            // Actualizar el sessionId con el que devuelve Django
            if (data.session_id) {
                sessionId = data.session_id;
                document.querySelector('.session-badge span').textContent = '🔑 ' + sessionId.substring(0, 8) + '...';
            }
        } else {
            addMessage('❌ Error: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(error => {
        hideTypingIndicator();
        console.error('Error:', error);
        addMessage('❌ Error de conexión con el servidor. Por favor, intenta de nuevo.');
    });
}

        // Scroll inicial
        scrollToBottom();

        // Focus automático en el input
        messageInput.focus();
    </script>
</body>
</html>
