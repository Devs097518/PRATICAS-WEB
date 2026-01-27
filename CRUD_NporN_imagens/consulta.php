<?php
require_once 'config.php';

// CREATE
if(isset($_POST['criar'])) {
    $stmt = $pdo->prepare("INSERT INTO consulta (medico_id, paciente_id, data_consulta, horario, observacoes) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['medico_id'], $_POST['paciente_id'], $_POST['data_consulta'], $_POST['horario'], $_POST['observacoes']]);
    header('Location: consulta.php');
    exit;
}

// UPDATE
if(isset($_POST['atualizar'])) {
    $stmt = $pdo->prepare("UPDATE consulta SET medico_id=?, paciente_id=?, data_consulta=?, horario=?, observacoes=? WHERE id=?");
    $stmt->execute([$_POST['medico_id'], $_POST['paciente_id'], $_POST['data_consulta'], $_POST['horario'], $_POST['observacoes'], $_POST['id']]);
    header('Location: consulta.php');
    exit;
}

// DELETE
if(isset($_GET['deletar'])) {
    $stmt = $pdo->prepare("DELETE FROM consulta WHERE id=?");
    $stmt->execute([$_GET['deletar']]);
    header('Location: consulta.php');
    exit;
}

// READ - Consultas com JOIN
$consultas = $pdo->query("
    SELECT c.*, m.nome as medico_nome, m.especialidade, p.nome as paciente_nome 
    FROM consulta c
    INNER JOIN medico m ON c.medico_id = m.id
    INNER JOIN paciente p ON c.paciente_id = p.id
    ORDER BY c.data_consulta DESC, c.horario DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Buscar médicos e pacientes para os selects
$medicos = $pdo->query("SELECT id, nome, especialidade FROM medico ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$pacientes = $pdo->query("SELECT id, nome FROM paciente ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Buscar dados para edição
$editando = null;
if(isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM consulta WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Consultas</title>
</head>
<body>
    <h1>Gerenciar Consultas</h1>
    <p><a href="index.php">← Voltar ao Menu</a></p>
    
    <h2><?= $editando ? 'Editar' : 'Cadastrar' ?> Consulta</h2>
    <form method="POST">
        <?php if($editando): ?>
            <input type="hidden" name="id" value="<?= $editando['id'] ?>">
        <?php endif; ?>
        
        <p>
            <label>Médico:
                <select name="medico_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach($medicos as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($editando && $editando['medico_id'] == $m['id']) ? 'selected' : '' ?>>
                            <?= $m['nome'] ?> - <?= $m['especialidade'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        
        <p>
            <label>Paciente:
                <select name="paciente_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach($pacientes as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($editando && $editando['paciente_id'] == $p['id']) ? 'selected' : '' ?>>
                            <?= $p['nome'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        
        <p>
            <label>Data: <input type="date" name="data_consulta" value="<?= $editando['data_consulta'] ?? '' ?>" required></label>
        </p>
        
        <p>
            <label>Horário: <input type="time" name="horario" value="<?= $editando['horario'] ?? '' ?>" required></label>
        </p>
        
        <p>
            <label>Observações:<br>
                <textarea name="observacoes" rows="4" cols="50"><?= $editando['observacoes'] ?? '' ?></textarea>
            </label>
        </p>
        
        <p>
            <button type="submit" name="<?= $editando ? 'atualizar' : 'criar' ?>">
                <?= $editando ? 'Atualizar' : 'Agendar Consulta' ?>
            </button>
            <?php if($editando): ?>
                <a href="consulta.php"><button type="button">Cancelar</button></a>
            <?php endif; ?>
        </p>
    </form>
    
    <h2>Lista de Consultas</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Médico</th>
            <th>Especialidade</th>
            <th>Paciente</th>
            <th>Data</th>
            <th>Horário</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>
        <?php foreach($consultas as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['medico_nome'] ?></td>
            <td><?= $c['especialidade'] ?></td>
            <td><?= $c['paciente_nome'] ?></td>
            <td><?= date('d/m/Y', strtotime($c['data_consulta'])) ?></td>
            <td><?= date('H:i', strtotime($c['horario'])) ?></td>
            <td><?= $c['observacoes'] ?></td>
            <td>
                <a href="?editar=<?= $c['id'] ?>">Editar</a> |
                <a href="?deletar=<?= $c['id'] ?>" onclick="return confirm('Deseja realmente deletar?')">Deletar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>