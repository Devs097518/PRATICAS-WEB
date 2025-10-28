<?php include 'db.php'; ?>

<h2>Usuários</h2>
<a href="create.php">Adicionar novo</a>

<table border="1" cellpadding="5">
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Ações</th>
  </tr>

  <?php
  $res = $conn->query("SELECT * FROM usuarios");
  while($row = $res->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['nome']}</td>
      <td>
        <a href='update.php?id={$row['id']}'>Editar</a> |
        <a href='delete.php?id={$row['id']}'>Excluir</a>
      </td>
    </tr>";
  }
  ?>
</table>
