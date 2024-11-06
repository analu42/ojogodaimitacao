<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Interrogador</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <script src='main.js'></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
</head>
<body class="center" class="varela-round-regular">
    <div class="margin">
        <div>

            <?php
            // Captura o código via URL
            $codigo = $_GET['codigo'] ?? '';
            ?>

            <div><b>A</b></div>

            <div class="font">
                <div>
                    <?php
                    // Importação das dependências e configuração da API
                    require 'vendor/autoload.php';
                    use GeminiAPI\Client;
                    use GeminiAPI\Resources\Parts\TextPart;

                    // Defina a chave da API
                    $client = new Client('AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA');

                    // Inicialize a variável para a pergunta
                    $pergunta = "";

                    // Conexão com o banco de dados
                    include 'banco/conexao.php';

                    // Estabelecendo conexão com o banco e buscando a pergunta
                    $conn = conectar();
                    $smtp = $conn->prepare("SELECT pergunta FROM registros WHERE codigo=? and data_hora_pergunta = (SELECT MAX(data_hora_pergunta) from registros)");
                    $smtp->bind_param("s", $codigo);

                    // Executando a consulta
                    $smtp->execute();
                    $result = $smtp->get_result();

                    // Verificando se a pergunta foi encontrada
                    if ($row = $result->fetch_assoc()) {
                        $pergunta = $row['pergunta']; // Armazena a pergunta
                    } else {
                        die("Erro: Nenhuma pergunta encontrada para o código $codigo.");
                    }

                    // Fechando a consulta e a conexão com o banco
                    $smtp->close();
                    $conn->close();

                    // Verifica se a pergunta foi recuperada corretamente
                    if (empty($pergunta)) {
                        die("Erro: A pergunta não pode estar vazia.");
                    }

                    // Envia a pergunta para a API do Gemini
                    $response = $client->geminiPro()->generateContent(new TextPart($pergunta));

                    // Verificando a estrutura da resposta da API
                    //var_dump($response); // Mostra a estrutura da resposta da API (para depuração)

                    // Exibe o conteúdo gerado pela API
                    echo $response->text(); // Aqui deve ser o texto gerado pela API
                
                    ?>
                </div>
            </div>
        </div>

        <div class="padd2"></div>

        <div><b>B</b></div>

        <div class="font">
            <div>
                <?php
                // Inicializa a conexão e busca a última resposta
                $resposta = "";
                // Conexão com o banco de dados
                $conn = conectar();
                $smtp = $conn->prepare("SELECT resposta FROM registros WHERE codigo=? and data_hora_resposta = (SELECT MAX(data_hora_resposta) from registros)");
                $smtp->bind_param("s", $codigo);

                // Executando a consulta
                $smtp->execute();
                $result = $smtp->get_result();

                // Exibe a última resposta encontrada
                while ($row = $result->fetch_assoc()) {
                    echo $row['resposta'];
                    $resposta = $row['resposta']; // Armazena a resposta
                }

                // Fechar a conexão
                desconectar($conn);
                ?>
            </div>
        </div>

        <div class="padd2"></div>
        <div class="padd2"></div>

        <div class="center">
            <a href="question.php" class="button">CONTINUAR PERGUNTANDO</a>
        </div>
    </div>
</body>
</html>

