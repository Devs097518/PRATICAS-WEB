<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';
require_once 'authenticate.php';

// $result = $conn->query("SELECT username FROM usuarios WHERE id = 1");
// $row = $result->fetch_assoc();

// echo $row['disciplina'];

// Verifica se o formulário foi submetido através do método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    }

    $user_id = $_SESSION['user_id']; // Obtém o disciplina de usuário da sessão ////////////////////////

    // Obtém os dados enviados pelo formulário
    $disciplina = $_POST['disciplina'];
    $situacao = $_POST['situacao'];
    $anotacoes = $_POST['anotacoes'];


    // Prepara a instrução SQL para inserir um novo disciplina no banco de dados
    $stmt = $pdo->prepare("INSERT INTO disciplinas (disciplina, situacao, anotacoes, associado) VALUES (?, ?, ?, ?)");

    // Executa a instrução SQL com os dados do formulário
    $stmt->execute([$disciplina, $situacao, $anotacoes, $user_id]);

    // Redireciona para a página de listagem de disciplinas após a inserção
    header('Location: index-disciplina.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar disciplina</title>
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
        <h2>Adicionar disciplina</h2>

        <form method="POST">
            <label for="disciplina">Disciplina:</label>
            <!-- Campo para inserir o disciplina do disciplina -->
            <input type="text" id="disciplina" name="disciplina" required>

            <label for="situacao">Situação:</label>
            <!-- Campo para inserir a matrícula do disciplina -->
            <input type="text" id="situacao" name="situacao" required>

            <label for="anotacoes">Anotações</label>
            <!-- Campo para inserir a data de nascimento do disciplina -->
            <input type="text" id="anotacoes" name="anotacoes" required>


            <button type="submit">Adicionar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de disciplinas</p>
    </footer>
</body>

</html>