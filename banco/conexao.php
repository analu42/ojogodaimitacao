<?php

function conectar(){
    #$host = "localhost:3307";
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "turing";
    #$port = "3307";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("a conexão falhou!" . $conn->connect_error);
    }

    return $conn;
}

function desconectar($conn){
    $conn->close();
}


?>