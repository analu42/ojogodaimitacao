<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
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
            $codigo = $_GET['codigo'];
        ?>

            <div><b>A</b></div>
            
                
        <div class="font">
        <div>
           a
         </div>
             </div>
        </div>

        <div class="padd2"></div>

        <div><b>B</b></div>

        <div class="font">
        <div>
            <?php
            $resposta = "";
            include 'banco/conexao.php';
            $conn = conectar();
            $smtp = $conn->prepare("SELECT resposta FROM registros WHERE codigo=? and data_hora_resposta = (SELECT MAX(data_hora_resposta) from registros)");
            $smtp->bind_param("s", $codigo);

            $smtp->execute();
            $result = $smtp->get_result();
            while ($row = $result->fetch_assoc()) {
                echo $row['resposta'];
                $pergunta = $row['resposta'];
            }
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
