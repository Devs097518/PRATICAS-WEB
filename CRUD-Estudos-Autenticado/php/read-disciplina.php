<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';
require_once 'authenticate.php';

// Pega o ID do usuário logado
$user_id = $_SESSION['user_id'];

// Obtém o ID do disciplina a partir da URL usando o método GET
$id = $_GET['id'];

// Prepara a instrução SQL para selecionar o disciplina pelo ID E pelo associado
$stmt = $pdo->prepare("SELECT * FROM disciplinas WHERE id = ? AND associado = ?");
// Executa a instrução SQL, passando o ID do disciplina E o ID do usuário
$stmt->execute([$id, $user_id]);

// Recupera os dados do disciplina como um array associativo
$disciplina = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do disciplina</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gerenciamento de disciplinas</h1>
        <nav>
            <ul>
                <li><a href="/index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/php/index-disciplina.php">Listar disciplinas</a></li>
                    <li><a href="/php/create-disciplina.php">Adicionar disciplina</a></li>
                    <li><a href="/php/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="/php/user-login.php">Login</a></li>
                    <li><a href="/php/user-register.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Detalhes do disciplina</h2>
        <?php if ($disciplina): ?>
            <!-- Exibe os detalhes do disciplina -->
            <p><strong>ID:</strong> <?= $disciplina['id'] ?></p>
            <p><strong>disciplina:</strong> <?= $disciplina['disciplina'] ?></p>
            <p><strong>Situação:</strong> <?= $disciplina['situacao'] ?></p>
            <p><strong>Anotações:</strong> <?= $disciplina['anotacoes'] ?></p>
            <p>
                <!-- Links para editar e excluir o disciplina -->
                <a href="update-disciplina.php?id=<?= $disciplina['id'] ?>">Editar</a>
                <a href="delete-disciplina.php?id=<?= $disciplina['id'] ?>">Excluir</a>
            </p>
        <?php else: ?>
            <!-- Exibe uma mensagem caso o disciplina não seja encontrado -->
            <p>disciplina não encontrado ou você não tem permissão para visualizá-lo.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de disciplinas</p>
    </footer>
</body>

</html>