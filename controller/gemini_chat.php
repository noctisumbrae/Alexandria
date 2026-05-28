<?php
header('Content-Type: application/json');

$dados = json_decode(file_get_contents('php://input'), true);
$mensagem = $dados['message'] ?? '';

if (empty($mensagem)) {
    echo json_encode(['reply' => 'Mensagem vazia.']);
    exit;
}

$apiKey = 'SUA_CHAVE_API_AQUI';
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

$payload = [
    "systemInstruction" => [
        "parts" => [
            ["text" => "Você é o assistente virtual do Alexandria, um sistema acadêmico de biblioteca pública. Ajude os usuários (leitores e funcionários) com dúvidas sobre o acervo, funcionamento e cadastros. Seja cordial, direto e use o contexto de uma biblioteca clássica."]
        ]
    ],
    "contents" => [
        [
            "parts" => [
                ["text" => $mensagem]
            ]
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$resposta = curl_exec($ch);
$erro = curl_error($ch);
curl_close($ch);

if ($erro) {
    echo json_encode(['reply' => 'Erro na comunicação com a API.']);
    exit;
}

$dadosResposta = json_decode($resposta, true);
$textoResposta = $dadosResposta['candidates'][0]['content']['parts'][0]['text'] ?? 'Não foi possível gerar uma resposta.';

echo json_encode(['reply' => $textoResposta]);