<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//Permite acesso dos metodos GET, POST, PUT E DELETE
//PUT é utilizado para fazer um UPDATE no banco
//DELETE é utilizado para deletar algo no banco
header('Access-Control-Allow-Headers: Content-Type'); 
//Permite com que qualquer header consiga acessar o sistema

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}

include 'conexao.php';
//Inclue os dados de conexao com o bd no sistema abaixo

//Rota para obter todos os livros
//Utilizando o GET

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM livros");
    $stmt -> execute();
    $livros = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($livros);
    //Converter dados em json
}


// ---------------------------------------
//Rota para inserir livros
//Utilizando o POST

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano_publicacao = $_POST['ano_publicacao'];

    $stmt = $conn -> prepare ("INSERT INTO livros (titulo, autor, ano_publicacao) VALUES (:titulo, :autor, :ano_publicacao)");
    //Inserindo dados no banco

    $stmt -> bindParam (':titulo', $titulo);
    $stmt -> bindParam (':autor', $autor);
    $stmt -> bindParam (':ano_publicacao', $ano_publicacao);

    if($stmt->execute()){
        echo "Livro criado com sucesso";
    } else {
        echo "Erro ao criar livro";
    }
}

//Rota para atualizar um livro existente

if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])){
    //Convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_GET['id'];
    $novoTitulo = $_PUT['titulo'];
    $novoAutor = $_PUT['autor'];
    $novoAno = $_PUT['ano_publicacao'];


    $stmt = $conn->prepare("UPDATE livros SET titulo = :titulo, autor = :autor, ano_publicacao = :ano_publicacao WHERE id = :id");
    $stmt->bindParam('titulo', $novoTitulo);
    $stmt->bindParam('autor', $novoAutor);
    $stmt->bindParam('ano_publicacao', $novoAno);
    $stmt->bindParam('id', $id);

    if($stmt->execute()){
        echo "livro atualizado com sucesso";
    } else{
        echo "erro ao att livro";
    }
}

//Rota para deletar um livro existente
if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){

    $id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM livros WHERE id = :id");
    $stmt->bindParam (':id', $id);

    if($stmt->execute()){
        echo "Livro deletado com sucesso";
    } else {
        echo "Erro ao excluir livro";
    }
}




?>