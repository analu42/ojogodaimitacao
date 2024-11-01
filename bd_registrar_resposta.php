<?php
require 'vendor/autoload.php';
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // PEGANDO OS DADOS VINDOS DO FORMULÁRIO
    $codigo = $_POST['codigo'];
    $resposta = $_POST['resposta'];
    $pergunta = $_POST['pergunta'];
    

    // ==== REGISTRAR RESPOSTA DO GEMINI ====
    

    $client = new Client('AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA');
    $response = $client->geminiPro()->generateContent(
        new TextPart($pergunta),
    );

    //print $response->text();
    $resposta_gemini = $response->text();


    include 'banco/conexao.php';
    $conn = conectar();

    // CONEXÃO COM O BANCO DE DADOS
    //$conn = new mysqli($server, $usuario, $senha, $banco);

    // VERIFICAR CONEXÃO
    //if ($conn->connect_error) {
        //die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
    //}

    $smtp = $conn->prepare("UPDATE registros SET resposta=?, resposta_gemini=?, data_hora_resposta=now() WHERE codigo=? and data_hora_pergunta = (SELECT MAX(data_hora_pergunta) from registros); ");
    $smtp->bind_param("sss", $resposta, $resposta_gemini, $codigo);

    // Executar a consulta
    if ($smtp->execute()) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir dados: " . $smtp->error;
    }

    // Fechar a consulta e a conexão
    $smtp->close();
    $conn->close();

    // Redirecionar após a inserção
    header('Location: index.php');
    exit();
} else {
    echo "Método de requisição inválido.";
}

?>
