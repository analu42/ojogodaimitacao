<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test de turing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="center">
    
    <?php 
    $codigo = $_GET['codigo'];
    ?>

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
                $resposta = $row['resposta'];
            }
            desconectar($conn);
            ?>
         </div>
        
        <h1>Responder:</h1>
        <form action="bd_registrar_resposta.php" method="post">
            <!--<input type="text" class="input" placeholder="Digite..">-->
            <textarea name="resposta"></textarea>
            <!--<a href="index.php" class="btn ">Enviar</a>>-->
            <button type="index.php" class="button">RESPONDER</button>
            <?php

            echo "<input type='hidden' name='codigo' value='$codigo' />";
            echo "<input type='hidden' name='pergunta' value='$resposta' />";
            ?>  
        </form>
</body>
</html>