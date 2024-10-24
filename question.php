<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Interrogador</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='index.css'>
    <script src='main.js'></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
</head>
<body class="center">
    <form action="bd_pergunta.php" method="POST">
        <div class="padd">
            Insira o código: 
            <input type="text" name="codigo" placeholder="Digite aqui..." required>
        </div>
        <div class="center">
            Faça sua pergunta:
            <div class="padd3"></div>
            <textarea type="text" name="pergunta" rows="5" placeholder="Digite aqui..." required></textarea>
        </div>
        <div class="padd2"></div>
        <div class="center">
                <button type="submit" class="button">ENVIAR</button>
        </div>
    </form>
    
</body>
</html>
