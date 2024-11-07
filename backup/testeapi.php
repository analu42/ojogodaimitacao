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
            // API URL e chave
            $url = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5:generateContent';
            $apiKey = 'AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA';  // Insira sua chave de API válida aqui

            // Conexão com o banco de dados
            include 'banco/conexao.php';
            $codigo = $_GET['codigo'] ?? '';

            $conn = conectar();
            $smtp = $conn->prepare("SELECT pergunta FROM registros WHERE codigo=? AND data_hora_pergunta = (SELECT MAX(data_hora_pergunta) FROM registros)");
            $smtp->bind_param("s", $codigo);
            $smtp->execute();
            $result = $smtp->get_result();
            
            // Obtém a pergunta
            if ($row = $result->fetch_assoc()) {
                $pergunta = $row['pergunta'];
            } else {
                die("Erro: Nenhuma pergunta encontrada para o código $codigo.");
            }

            $smtp->close();
            $conn->close();

            // Enviar a pergunta para a API Gemini
            $data = [
                'prompt' => [
                    'text' => $pergunta
                ],
                'model' => 'gemini-1.5'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?key=' . $apiKey);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            // Execução e verificação de erros
            $response = curl_exec($ch);
            if ($response === false) {
                die('Erro ao chamar a API: ' . curl_error($ch));
            }
            curl_close($ch);

            $responseData = json_decode($response, true);

            if (isset($responseData['candidates'][0]['text'])) {
                echo $responseData['candidates'][0]['text'];
            } else {
                echo "Erro ao gerar resposta: " . print_r($responseData, true);
            }
            ?>
        </div>

        <div class="padd2"></div>

        <div><b>B</b></div>

        <div class="font">
            <div>
                <?php
                // Obtém a última resposta do banco de dados
                $conn = conectar();
                $smtp = $conn->prepare("SELECT resposta FROM registros WHERE codigo=? AND data_hora_resposta = (SELECT MAX(data_hora_resposta) FROM registros)");
                $smtp->bind_param("s", $codigo);
                $smtp->execute();
                $result = $smtp->get_result();

                if ($row = $result->fetch_assoc()) {
                    echo $row['resposta'];
                }

                desconectar($conn);
                ?>
            </div>
        </div>

        <div class="padd2"></div>
        <div class="center">
            <a href="question.php" class="button">CONTINUAR PERGUNTANDO</a>
        </div>
    </div>
</body>
</html>
