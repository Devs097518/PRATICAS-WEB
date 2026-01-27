<?php
require_once 'config.php';

// CREATE
if(isset($_POST['criar'])) {
    $stmt = $pdo->prepare("INSERT INTO medico (nome, crm, especialidade) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['crm'], $_POST['especialidade']]);
    header('Location: medico.php');
    exit;
}

// UPDATE
if(isset($_POST['atualizar'])) {
    $stmt = $pdo->prepare("UPDATE medico SET nome=?, crm=?, especialidade=? WHERE id=?");
    $stmt->execute([$_POST['nome'], $_POST['crm'], $_POST['especialidade'], $_POST['id']]);
    header('Location: medico.php');
    exit;
}

// DELETE
if(isset($_GET['deletar'])) {
    $stmt = $pdo->prepare("DELETE FROM medico WHERE id=?");
    $stmt->execute([$_GET['deletar']]);
    header('Location: medico.php');
    exit;
}

// READ
$medicos = $pdo->query("SELECT * FROM medico ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Buscar dados para edição
$editando = null;
if(isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM medico WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Médicos</title>
</head>
<body>
    <h1>Gerenciar Médicos</h1>
    <p><a href="index.php">← Voltar ao Menu</a></p>
    
    <h2><?= $editando ? 'Editar' : 'Cadastrar' ?> Médico</h2>
    <form method="POST">
        <?php if($editando): ?>
            <input type="hidden" name="id" value="<?= $editando['id'] ?>">
        <?php endif; ?>
        
        <p>
            <label>Nome: <input type="text" name="nome" value="<?= $editando['nome'] ?? '' ?>" required></label>
        </p>
        <p>
            <label>CRM: <input type="text" name="crm" value="<?= $editando['crm'] ?? '' ?>" required></label>
        </p>
        <p>
            <label>Especialidade: <input type="text" name="especialidade" value="<?= $editando['especialidade'] ?? '' ?>" required></label>
        </p>
        <p>
            <button type="submit" name="<?= $editando ? 'atualizar' : 'criar' ?>">
                <?= $editando ? 'Atualizar' : 'Cadastrar' ?>
            </button>
            <?php if($editando): ?>
                <a href="medico.php"><button type="button">Cancelar</button></a>
            <?php endif; ?>
        </p>
    </form>
    
    <h2>Lista de Médicos</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Ações</th>
        </tr>
        <?php foreach($medicos as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>
            <td><?= $m['nome'] ?></td>
            <td><?= $m['crm'] ?></td>
            <td><?= $m['especialidade'] ?></td>
            <td>
                <a href="?editar=<?= $m['id'] ?>">Editar</a> |
                <a href="?deletar=<?= $m['id'] ?>" onclick="return confirm('Deseja realmente deletar?')">Deletar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>