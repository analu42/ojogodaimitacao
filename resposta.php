<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test de turing</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="centralize">
    
   <?php
    $codigo = $_GET['codigo'];
    ?>

        <div>
            <?php
            $pergunta = "";
            include 'banco/conexao.php';
            $conn = conectar();
            $smtp = $conn->prepare("SELECT pergunta FROM registros WHERE codigo=? and data_hora_pergunta = (SELECT MAX(data_hora_pergunta) from registros WHERE codigo=?)");
            $smtp->bind_param("ss", $codigo, $codigo);

            $smtp->execute();
            $result = $smtp->get_result();
            while ($row = $result->fetch_assoc()) {
                echo $row['pergunta'];
                $pergunta = $row['pergunta'];
            }
            desconectar($conn);
            ?>
         </div>

        
         <div class="centralize">
            <div class="padd3"></div>
            <h3>Responder:</h3>
            <div class="padd3"></div>
            <form action="bd_registrar_resposta.php" method="post" class="center" >
                <!--<input type="text" class="input" placeholder="Digite..">-->
                <textarea type="text" name="resposta" rows="5"></textarea>
                <!--<a href="index.php" class="btn ">Enviar</a>>-->
                <button type="comeco.php" class="button">RESPONDER</button>

                <?php
                echo "<input type='hidden' name='codigo' value='$codigo' />";
                echo "<input type='hidden' name='pergunta' value='$pergunta' />";
                ?>  
            </form>
         </div>
       
</body>
</html>
