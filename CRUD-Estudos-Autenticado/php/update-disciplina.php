<?php
// Inclui o arquivo de conexão com o banco de dados
require_once 'db.php';
require_once 'authenticate.php';

// Obtém o ID do disciplina a partir da URL usando o método GET
$id = $_GET['id'];

// Prepara a instrução SQL para selecionar o disciplina pelo ID
$stmt = $pdo->prepare("SELECT * FROM disciplinas WHERE id = ?");

// Executa a instrução SQL, passando o ID do disciplina como parâmetro
$stmt->execute([$id]);

// Recupera os dados do disciplina como um array associativo
$disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o formulário foi submetido através do método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados enviados pelo formulário
    $disciplina = $_POST['disciplina'];
    $situacao = $_POST['situacao'];
    $anotacoes = $_POST['anotacoes'];
    
    // Prepara a instrução SQL para atualizar os dados do disciplina
    $stmt = $pdo->prepare("UPDATE disciplinas SET disciplina = ?, situacao = ?, anotacoes = ? WHERE id = ?");
    
    // Executa a instrução SQL com os novos dados do formulário
    $stmt->execute([$disciplina, $situacao, $anotacoes, $id]);
    
    // Redireciona para a página de listagem de disciplinas após a atualização
    header('Location: index-disciplina.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar disciplina</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gerenciamento de disciplinas</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="index-disciplina.php">Listar disciplinas</a></li>
                <li><a href="create-disciplina.php">Adicionar disciplina</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Editar disciplina</h2>
        <!-- Formulário para editar os dados do disciplina -->
        <form method="POST">
            <label for="disciplina">Disciplina:</label>
            <!-- Campo para inserir o disciplina do disciplina -->
            <input type="text" id="disciplina" name="disciplina" value="<?= $disciplina['disciplina'] ?>" required>
            
            <label for="situacao">Situação:</label>
            <!-- Campo para inserir a matrícula do disciplina -->
            <input type="text" id="situacao" name="situacao" value="<?= $disciplina['situacao'] ?>" required>
            
            <label for="anotacoes">Anotações:</label>
            <!-- Campo para inserir a data de nascimento do disciplina -->
            <input type="text" id="anotacoes" name="anotacoes" value="<?= $disciplina['anotacoes'] ?>" required>
            
            
            <!-- Botão para submeter o formulário -->
            <button type="submit">Atualizar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de disciplinas</p>
    </footer>
</body>
</html>
