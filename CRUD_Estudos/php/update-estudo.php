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

// Verifica se o formulário foi submetido através do método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados enviados pelo formulário
    $cadeira = $_POST['cadeira'];
    $situacao = $_POST['situacao'];
    $notas = $_POST['notas'];
    
    // Prepara a instrução SQL para atualizar os dados do aluno
    $stmt = $pdo->prepare("UPDATE estudos SET cadeira = ?, situacao = ?, notas = ? WHERE id = ?");
    
    // Executa a instrução SQL com os novos dados do formulário
    $stmt->execute([$cadeira, $situacao, $notas, $id]);
    
    // Redireciona para a página de listagem de alunos após a atualização
    header('Location: index-estudo.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudos</title>
    <link rel="stylesheet" href="../css/style.css">
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
        <h2>Editar Estudo</h2>
        <!-- Formulário para editar os dados do aluno -->
        <form method="POST">
            <label for="cadeira">Cadeira:</label>
            <!-- Campo para inserir o nome do aluno -->
            <input type="text" id="cadeira" name="cadeira" value="<?= $estudo['cadeira'] ?>" required>
            
            <label for="situacao">Situacao:</label>
            <!-- Campo para inserir a matrícula do aluno -->
            <input type="text" id="situacao" name="situacao" value="<?= $estudo['situacao'] ?>" required>
            
            
            <label for="notas">Notas:</label>
            <!-- Campo para inserir a matrícula do aluno -->
            <input type="text" id="notas" name="notas" value="<?= $estudo['notas'] ?>" required>

            
            <!-- Botão para submeter o formulário -->
            <button type="submit">Atualizar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 - Sistema de Gerenciamento de Status dos Estudos</p>
    </footer>
</body>
</html>
