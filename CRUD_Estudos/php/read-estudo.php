<?php
    // Inclui o arquivo de conexão com o banco de dados
    require_once 'db.php';

    // Obtém o ID do aluno a partir da URL usando o método GET
    $id = $_GET['id'];

    // Prepara a instrução SQL para selecionar o aluno pelo ID
    $stmt = $pdo->prepare("SELECT * FROM estudos WHERE id = ?");
    // Executa a instrução SQL, passando o ID do aluno como parâmetro
    $stmt->execute([$id]);

    // Recupera os dados do aluno como um array associativo
    $estudo = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Estudo</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gerenciamento de Estudos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="index-estudo.php">Listar Estudos</a></li>
                <li><a href="create-estudo.php">Adicionar Estudos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Detalhes do Estudos</h2>
        <?php if ($estudo): ?>
            <!-- Exibe os detalhes do aluno -->
            <p><strong>ID:</strong> <?= $estudo['id'] ?></p>
            <p><strong>Cadeira:</strong> <?= $estudo['cadeira'] ?></p>
            <p><strong>Situacao:</strong> <?= $estudo['situacao'] ?></p>
            <p><strong>Notas:</strong> <?= $estudo['notas'] ?></p>
  
            <p>
                <!-- Links para editar e excluir o aluno -->
                <a href="update-estudo.php?id=<?= $estudo['id'] ?>">Editar</a>
                <a href="delete-estudo.php?id=<?= $estudo['id'] ?>">Excluir</a>
            </p>
        <?php else: ?>
            <!-- Exibe uma mensagem caso o aluno não seja encontrado -->
            <p>Estudo não encontrado.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 - Sistema de Gerenciamento de Status dos Estudos</p>
    </footer>
</body>
</html>
