const formularios = document.querySelectorAll("form");

formularios.forEach((formulario) => {
    formulario.addEventListener("submit", () => {
        const botao = formulario.querySelector("button");

        if (botao) {
            botao.disabled = true;
            botao.textContent = "Processando...";
        }
    });
});

const chatPopup = document.getElementById('chat-popup');
const openChat = document.getElementById('open-chat');
const closeChat = document.getElementById('close-chat');
const chatInput = document.getElementById('chat-input');
const sendChat = document.getElementById('send-chat');
const chatBody = document.getElementById('chat-body');

if (openChat && closeChat && chatPopup) {
    openChat.addEventListener('click', () => {
        chatPopup.style.display = 'flex';
        openChat.style.display = 'none';
    });

    closeChat.addEventListener('click', () => {
        chatPopup.style.display = 'none';
        openChat.style.display = 'flex';
    });
}

if (sendChat && chatInput) {
    sendChat.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
}

async function sendMessage() {
    const text = chatInput.value.trim();
    if (!text) return;

    appendMessage('user', text);
    chatInput.value = '';

    try {
        const response = await fetch('controller/gemini_chat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: text })
        });
        const data = await response.json();
        appendMessage('bot', data.reply);
    } catch (error) {
        appendMessage('bot', 'Erro ao processar a mensagem.');
    }
}

function appendMessage(sender, text) {
    const msgDiv = document.createElement('div');
    msgDiv.textContent = text;
    msgDiv.classList.add('chat-msg');
    msgDiv.classList.add(sender === 'user' ? 'msg-user' : 'msg-bot');
    
    chatBody.appendChild(msgDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}