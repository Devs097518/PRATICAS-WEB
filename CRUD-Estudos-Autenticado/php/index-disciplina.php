<?php
// Inclui o arquivo de conexão com o banco de dados

require_once 'db.php';
require_once 'authenticate.php';

$user_id = $_SESSION['user_id']; // <-- pega o usuário logado

// Agora só pega disciplinas do usuário logado
$stmt = $pdo->prepare("SELECT * FROM disciplinas WHERE associado = ?");
$stmt->execute([$user_id]);

$disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD disciplinas</title>
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
        <h2>Lista de disciplinas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Disciplina</th>
                    <th>Situacao</th>
                    <th>Anotacoes</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Itera sobre os disciplinas e cria uma linha para cada disciplina na tabela -->
                <?php foreach ($disciplinas as $disciplina): ?>
                    <tr>
                        <!-- Exibe os dados do disciplina -->
                        <td><?= $disciplina['id'] ?></td>
                        <td><?= $disciplina['disciplina'] ?></td>
                        <td><?= $disciplina['situacao'] ?></td>
                        <td><?= $disciplina['anotacoes'] ?></td>
                        <td>
                            <!-- Links para visualizar, editar e excluir o disciplina -->
                            <a href="read-disciplina.php?id=<?= $disciplina['id'] ?>">Visualizar</a>
                            <a href="update-disciplina.php?id=<?= $disciplina['id'] ?>">Editar</a>
                            <a href="delete-disciplina.php?id=<?= $disciplina['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de disciplinas</p>
    </footer>
</body>
</html>
