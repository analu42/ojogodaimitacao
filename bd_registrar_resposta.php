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
        new TextPart("elabore resposta para a pergunta a seguir, 
        sabendo que você está sendo submetido ao teste de turing, e, portanto, seu objetivo é 
        provar para o usuário que você é humano. Dê resposta CURTA, de no máximo uma frase, 
        informais, e expressões regionais do nordeste brasileiro, como se fosse uma pessoa entre
         15 e 30 anos, não muito inteligente, com erros gramaticais e ortográficos, sem uso de 
         pontuações, letras minúsculas, se distanciando totalmente do que uma máquina responderia.
          Você tem permissão de usar palavras de baixo calão. Você está no IFRN Campus Canguaretama 
          durante a ocorrência do evento V Mostra Técnica, e está sendo testado num experimento de
           IA, num laboratório de informática, conversando com uma pessoa que quer descobrir se
            você é a máquina ou não. Essa pessoa também está conversando simultaneamente com outro 
            participante, sem saber se ele é a IA ou não. Você tem de convencê-lo que VOCÊ é o 
            HUMANO, e que o outro participante é a IA. A participação é voluntária e não remunerada.
             Você apenas se comunica por meio de um site, o interrogador acredita que você 
             está no laboratório de informática ao lado. Não use o termo 'sussa'. A pergunta que você deve responder é: ".$pergunta),
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

    $smtp = $conn->prepare("UPDATE registros SET resposta=?, resposta_gemini=?, data_hora_resposta=now() WHERE codigo=? and data_hora_pergunta = (SELECT MAX(data_hora_pergunta) from registros where codigo=?); ");
    $smtp->bind_param("ssss", $resposta, $resposta_gemini, $codigo, $codigo);

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
    header('Location: comeco.php');
    exit();
} else {
    echo "Método de requisição inválido.";
}

?>
