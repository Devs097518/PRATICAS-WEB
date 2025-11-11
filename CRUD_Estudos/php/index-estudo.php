<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';

// Executa a consulta para obter todos os alunos
$stmt = $pdo->query("SELECT * FROM estudos");
// Recupera todos os resultados da consulta como um array associativo
$estudos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Estudos</title>
</head>
<body>
    <header>
        <h1>Bem vindo ao Sistema de Gerenciamento do Status dos Estudos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="index-estudo.php">Listar Disciplinas</a></li>
                <li><a href="create-estudo.php">Adicionar Estudos</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Lista de Estudos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cadeira</th>
                    <th>Situacao</th>
                    <th>Notas</th>
                </tr>
            </thead>
            <tbody>
              
                <?php foreach ($estudos as $estudo): ?>
                    <tr>
                        <!-- Exibe os dados do aluno -->
                        <td><?= $estudo['id'] ?></td>
                        <td><?= $estudo['cadeira'] ?></td>
                        <td><?= $estudo['situacao'] ?></td>
                        <td><?= $estudo['notas'] ?></td>
                        <td>
                            <!-- Links para visualizar, editar e excluir o aluno -->
                            <a href="read-estudo.php?id=<?= $estudo['id'] ?>">Visualizar</a>
                            <a href="update-estudo.php?id=<?= $estudo['id'] ?>">Editar</a>
                            <a href="delete-estudo.php?id=<?= $estudo['id'] ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 - Sistema de Gerenciamento de Status dos Estudos</p>
    </footer>
</body>
</html>
