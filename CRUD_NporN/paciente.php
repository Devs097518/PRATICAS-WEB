<?php
require_once 'config.php';

// CREATE
if(isset($_POST['criar'])) {
    $stmt = $pdo->prepare("INSERT INTO paciente (nome, cpf, telefone) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['cpf'], $_POST['telefone']]);
    header('Location: paciente.php');
    exit;
}

// UPDATE
if(isset($_POST['atualizar'])) {
    $stmt = $pdo->prepare("UPDATE paciente SET nome=?, cpf=?, telefone=? WHERE id=?");
    $stmt->execute([$_POST['nome'], $_POST['cpf'], $_POST['telefone'], $_POST['id']]);
    header('Location: paciente.php');
    exit;
}

// DELETE
if(isset($_GET['deletar'])) {
    $stmt = $pdo->prepare("DELETE FROM paciente WHERE id=?");
    $stmt->execute([$_GET['deletar']]);
    header('Location: paciente.php');
    exit;
}

// READ
$pacientes = $pdo->query("SELECT * FROM paciente ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Buscar dados para edição
$editando = null;
if(isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM paciente WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Pacientes</title>
</head>
<body>
    <h1>Gerenciar Pacientes</h1>
    <p><a href="index.php">← Voltar ao Menu</a></p>
    
    <h2><?= $editando ? 'Editar' : 'Cadastrar' ?> Paciente</h2>
    <form method="POST">
        <?php if($editando): ?>
            <input type="hidden" name="id" value="<?= $editando['id'] ?>">
        <?php endif; ?>
        
        <p>
            <label>Nome: <input type="text" name="nome" value="<?= $editando['nome'] ?? '' ?>" required></label>
        </p>
        <p>
            <label>CPF: <input type="text" name="cpf" value="<?= $editando['cpf'] ?? '' ?>" required></label>
        </p>
        <p>
            <label>Telefone: <input type="text" name="telefone" value="<?= $editando['telefone'] ?? '' ?>"></label>
        </p>
        <p>
            <button type="submit" name="<?= $editando ? 'atualizar' : 'criar' ?>">
                <?= $editando ? 'Atualizar' : 'Cadastrar' ?>
            </button>
            <?php if($editando): ?>
                <a href="paciente.php"><button type="button">Cancelar</button></a>
            <?php endif; ?>
        </p>
    </form>
    
    <h2>Lista de Pacientes</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <?php foreach($pacientes as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['nome'] ?></td>
            <td><?= $p['cpf'] ?></td>
            <td><?= $p['telefone'] ?></td>
            <td>
                <a href="?editar=<?= $p['id'] ?>">Editar</a> |
                <a href="?deletar=<?= $p['id'] ?>" onclick="return confirm('Deseja realmente deletar?')">Deletar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>