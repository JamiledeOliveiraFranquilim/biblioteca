<?php
require_once '../Controller/conexao.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$resultados = [];

if (!empty($busca)) {
    $sql = "SELECT * FROM livros WHERE titulo LIKE :busca";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':busca', '%' . $busca . '%');
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    $parametro = "%" . $busca . "%";
    $stmt->bindValue(':busca', $parametro, PDO::PARAM_STR);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Livros</title>
</head>
<body>
    <header>
        <nav> 
            <ul>
                <li><a href="../View/index.php">Página Inicial</a></li>
                <li><a href="../View/buscar_livro.php">Livros cadastrados</a></li>
                <li><a href="../View/index.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <div class="card1">
        <h1>Procure seu livro na Biblioteca Frank</h1>
        <form method="POST" action="../Controller/buscar_livro.php">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <button type="submit">Buscar</button>
        </form>
    </div>
</body>
</html>