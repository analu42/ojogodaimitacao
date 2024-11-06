<?php
require 'vendor/autoload.php';
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

// Defina a chave da API
$client = new Client('AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA');

// Inicialize a variável para a pergunta
$pergunta = "";

// Inclua o arquivo de conexão com o banco de dados
include 'banco/conexao.php';

// Defina o código (garanta que o código seja passado corretamente via GET, POST ou variável)
$codigo = $_GET['codigo'] ?? ''; // Ou de outra forma, conforme sua lógica

// Estabeleça a conexão com o banco de dados
$conn = conectar();

// Prepare a consulta para buscar a última pergunta associada ao código
$smtp = $conn->prepare("SELECT pergunta FROM registros WHERE codigo=? and data_hora_pergunta = (SELECT MAX(data_hora_pergunta) from registros)");
$smtp->bind_param("s", $codigo);

// Execute a consulta
$smtp->execute();

// Obtenha o resultado
$result = $smtp->get_result();

// Verifique se algum resultado foi encontrado
if ($row = $result->fetch_assoc()) {
    $pergunta = $row['pergunta']; // Armazene a pergunta
} else {
    die("Erro: Nenhuma pergunta encontrada para o código $codigo.");
}

// Feche a consulta e a conexão com o banco de dados
$smtp->close();
$conn->close();

// Verifique se a pergunta foi recuperada corretamente
if (empty($pergunta)) {
    die("Erro: A pergunta não pode estar vazia.");
}

// Use a pergunta recuperada do banco de dados com a Gemini API
$response = $client->geminiPro()->generateContent(
    new TextPart($pergunta)  // Passa a pergunta recuperada do banco de dados
);

// Exiba a resposta da API
echo $response->text();
?>
