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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>CRUD Estudos</title>
</head>

<body>
    <div id="container">
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
                            <td id="acoes">
                                <!-- Links para visualizar, editar e excluir o aluno -->
                                <a href="read-estudo.php?id=<?= $estudo['id'] ?>"><i class="bi bi-eye"></i></a>
                                <a href="update-estudo.php?id=<?= $estudo['id'] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="delete-estudo.php?id=<?= $estudo['id'] ?>"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>

        <footer>
            <p>&copy; 2025 - Sistema de Gerenciamento de Status dos Estudos</p>
        </footer>
    </div>

</body>

</html>