<?php

$host = "localhots";
$db_name = "biblioteca";
$username = "root";
$password = "sucesso";

try{
    $conn = new PDO("mysql: host=$host; dbname=$db_name", $username, $password);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error){
    echo "Erro na conexão: " . $error->getMessage();

}

?>