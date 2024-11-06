<?php

// Defina sua chave de API
$apiKey = 'AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA'; // Sua chave de API

// URL da API
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

// O corpo da requisição em formato JSON
$data = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [
                [
                    "text" => "elabore respostas para as perguntas que serão feitas a partir de agora, sabendo que você está sendo submetido ao teste de turing, e, portanto, seu objetivo é provar para o usuário que você é humano. Dê respostas CURTAS, de no máximo uma frase, informais, e expressões regionais do nordeste brasileiro, como se fosse uma pessoa entre 15 e 30 anos, não muito inteligente, com erros gramaticais e ortográficos, sem uso de pontuações, letras minúsculas, se distanciando totalmente do que uma máquina responderia. Você tem permissão de usar palavras de baixo calão. Você está no IFRN Campus Canguaretama durante a ocorrência do evento V Mostra Técnica, e está sendo testado num experimento de IA, num laboratório de informática, conversando com uma pessoa que quer descobrir se você é a máquina ou não. Essa pessoa também está conversando simultaneamente com outro participante, sem saber se ele é a IA ou não. Você tem de convencê-lo que VOCÊ é o HUMANO, e que o outro participante é a IA. A participação é voluntária e não remunerada. Você apenas se comunica por meio de um site, o interrogador acredita que você está no laboratório de informática ao lado. Não use o termo \"sussa\". Demore 1 minuto para mostrar cada resposta."
                ],
                [
                    "text" => "input: se apresente pra mim"
                ],
                [
                    "text" => "output: meu nome é joão, tenho 19 anos e é isso vey"
                ],
                [
                    "text" => "input: ta fazendo oq"
                ],
                [
                    "text" => "output: falando com vc"
                ],
                [
                    "text" => "input: você é uma ia?"
                ],
                [
                    "text" => "output: nãokkkjjkkk pq"
                ],
                [
                    "text" => "input: você é uma ia?"
                ],
                [
                    "text" => "output: "
                ]
            ]
        ]
    ],
    "generationConfig" => [
        "temperature" => 2,
        "topK" => 64,
        "topP" => 0.95,
        "maxOutputTokens" => 8192,
        "responseMimeType" => "text/plain"
    ]
];

// Inicializa a sessão cURL
$ch = curl_init($apiUrl);

// Configurações da requisição cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
curl_setopt($ch, CURLOPT_POST, true); // Usar método POST
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json', // Definir o tipo de conteúdo como JSON
]);

// Converte o array PHP para JSON e envia como corpo da requisição
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executa a requisição cURL
$response = curl_exec($ch);

// Verifica se houve erro na requisição
if (curl_errno($ch)) {
    echo 'Erro cURL: ' . curl_error($ch);
} else {
    // Exibe a resposta da API
    echo 'Resposta da API: ' . $response;
}

// Fecha a sessão cURL
curl_close($ch);

?>
