<?php

function conectar(){
    #$host = "localhost:3307";
    $host = "localhost";
    $user = "testedeturing";
    $password = "1FRN@turig";
    $database = "testedeturing";
    #$port = "3307";
/*
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "turing";*/

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