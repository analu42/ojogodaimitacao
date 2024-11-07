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

            <div class="font">
                <div>
                    <?php
                    // Importação das dependências e configuração da API
                    //require 'vendor/autoload.php';
                    //use GeminiAPI\Client;
                    //use GeminiAPI\Resources\Parts\TextPart;

                    // Defina a chave da API
                    //$client = new Client('AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA');

                    // Inicialize a variável para a pergunta
                    $pergunta = "";

                    // Conexão com o banco de dados
                    include 'banco/conexao.php';

                    // Estabelecendo conexão com o banco e buscando a pergunta
                    $conn = conectar();
                    $smtp = $conn->prepare("SELECT * FROM registros WHERE codigo=?");
                    $smtp->bind_param("s", $codigo);

                    // Executando a consulta
                    $smtp->execute();
                    $result = $smtp->get_result();

                    // Verificando se a pergunta foi encontrada
                    while ($row = $result->fetch_assoc()) {
                        echo "<p>Pergunta: ".$row['pergunta']."</p>";
                        echo "<p>Resposta 1: ".$row['resposta']."</p>";
                        echo "<p>Resposta 2: ".$row['resposta_gemini']."</p>";
                        echo "<hr />";
                    } 

                    // Fechando a consulta e a conexão com o banco
                    $smtp->close();
                    $conn->close();

                   

                    // Envia a pergunta para a API do Gemini
                    //$response = $client->geminiPro()->generateContent(new TextPart($pergunta));

                    // Verificando a estrutura da resposta da API
                    //var_dump($response); // Mostra a estrutura da resposta da API (para depuração)

                    // Exibe o conteúdo gerado pela API
                    //echo $response->text(); // Aqui deve ser o texto gerado pela API
                
                    ?>
                </div>
            </div>
        </div>

        <div class="padd2"></div>



        

        <div class="padd2"></div>
        <div class="padd2"></div>

        <div class="center">
            <a href="index.php" class="button">CONTINUAR PERGUNTANDO</a>
        </div>
    </div>
</body>
</html>

