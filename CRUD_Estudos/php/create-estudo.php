<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';

// Verifica se o formulário foi submetido através do método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados enviados pelo formulário
    $cadeira = $_POST['cadeira'];
    $situacao = $_POST['situacao'];
    $notas = $_POST['notas'];


    // Prepara a instrução SQL para inserir um novo aluno no banco de dados
    $stmt = $pdo->prepare(query: "INSERT INTO estudos (cadeira, situacao, notas) VALUES (?, ?, ?)");

    // Executa a instrução SQL com os dados do formulário
    $stmt->execute(params: [$cadeira, $situacao, $notas]);

    // Redireciona para a página de listagem de alunos após a inserção
    header(header: 'Location: index-estudo.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Estudos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div id="container">
        <header>
            <h1>Bem-vindo ao Sistema de Gerenciamento de Alunos</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="index-estudo.php">Listar Disciplinas</a></li>
                    <li><a href="create-estudo.php">Adicionar Estudos</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <h2>Adicionar Estudo</h2>
            <!-- Formulário para adicionar um novo aluno -->
            <form method="POST">


                <label for="cadeira">Cadeira:</label>
                <input type="text" id="cadeira" name="cadeira" required>
                <br>

                <label for="situacao">Situacao:</label>
                <input type="text" id="situacao" name="situacao" required>
                <br>

                <label for="notas">Notas:</label>
                <input type="text" id="notas" name="notas" required>
                <br>

                <!-- Botão para submeter o formulário -->
                <button type="submit">Adicionar</button>
            </form>
        </main>

        <footer>
            <p>&copy; 2025 - Sistema de Gerenciamento de Status dos Estudos</p>
        </footer>
    </div>

</body>

</html>