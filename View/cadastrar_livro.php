<?php
require_once '../Controller/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $título = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $descricao = $_POST['descricao'];

    if (empty($título) || empty($autor) || empty($genero) || empty($ano_publicacao) || empty($descricao)) {
        echo "Todos os campos são obrigatórios.";
    } else {
        $sql = "INSERT INTO livros (titulo, autor, genero, ano_publicacao, descricao) VALUES (:titulo, :autor, :genero, :ano_publicacao, :descricao)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':titulo', $título);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':ano_publicacao', $ano_publicacao);
        $stmt->bindParam(':descricao', $descricao);

        if ($stmt->execute()) {
            echo "Livro cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o livro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Model/css/cadastrar_livro.css">
    <title>Cadastrar Livros</title>
</head>
<header>
    <nav> 
        <ul>
            <li><a href="../View/index.php">Página Inicial</a></li>
            <li><a href="../View/buscar_livro.php">Livros cadastrados</a></li>
            <li><a href="../View/index.php">Sair</a></li>
        </ul>
    </nav>
</header>
<body>
    <div class="card1">
        <h1> Adicione seu livro na Biblioteca Frank</h1>
        <form method="POST" action="">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>

            <label for="genero">Gênero:</label>
            <input type="text" id="genero" name="genero" required>

            <label for="ano_publicacao">Ano de Publicação:</label>
            <input type="number" id="ano_publicacao" name="ano_publicacao" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <button type="submit">Cadastrar Livro</button>
        </form>
    </div>
</body>
</html>