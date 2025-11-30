<?php
  try {
// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // PEGANDO OS DADOS VINDOS DO FORMULÁRIO
    $codigo = $_POST['codigo'];
    $pergunta = $_POST['pergunta'];
    //$data_atual = date('d/m/Y');
    //$hora_atual = date('H:i:s');

    // CONFIGURAÇÕES DE CREDENCIAIS
    //$server = 'localhost';
    //$usuario = 'root';
    //$senha = '';
    //$banco = 'perguntas';
  
        
   
    include 'banco/conexao.php';
    $conn = conectar();

    // CONEXÃO COM O BANCO DE DADOS
    //$conn = new mysqli($server, $usuario, $senha, $banco);

    // VERIFICAR CONEXÃO
    //if ($conn->connect_error) {
        //die("Falha ao se comunicar com o banco de dados: " . $conn->connect_error);
    //}

    $smtp = $conn->prepare("INSERT INTO registros (codigo, pergunta, data_hora_pergunta) VALUES (?, ?, now())");
    $smtp->bind_param("ss", $codigo, $pergunta);

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
    header('Location: perguntar.php');
    exit();
} else {
    echo "Método de requisição inválido.";
}

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>
