<?php
require_once '../Controller/conexao.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$resultados = [];
$status = '';

if ($busca !== '') {
    $sql = "SELECT id, titulo, autor, disponivel FROM livros WHERE titulo LIKE :busca OR autor LIKE :busca";
    $stmt = $conn->prepare($sql);
    
    $parametro = "%" . $busca . "%";
    $stmt->bindValue(':busca', $parametro, PDO::PARAM_STR);
    $stmt->execute();
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Busca</title>
</head>
<body>
    <h2>Pesquisar Cadastros</h2>
    
    <form method="GET" action="">
        <input type="text" name="busca" placeholder="Digite o título ou autor..." value="<?php echo htmlspecialchars($busca); ?>">
        <button type="submit">Buscar</button>
    </form>

    <hr>

    <h3>Resultados:</h3>
    <?php if ($busca !== ''): ?>
        <?php if (count($resultados) > 0): ?>
            <table border="1" cellpadding="10">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($resultados as $linha): ?>
                    <tr>
                        <td><?php echo $linha['id']; ?></td>
                        <td><?php echo htmlspecialchars($linha['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($linha['autor']); ?></td>
                        <td><?php echo ($linha['disponivel'] == 1) ? '<span style="color: green;">✓ Disponível</span>' : '<span style="color: red;">✗ Indisponível</span>'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Nenhum registro encontrado.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Digite algo para pesquisar.</p>
    <?php endif; ?>
</body>
</html>
