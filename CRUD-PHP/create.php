<?php include 'db.php'; ?>

<form method="post">
  <input type="text" name="nome" placeholder="Nome" required>
  <button type="submit">Salvar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $conn->query("INSERT INTO usuarios (nome) VALUES ('$nome')");
  header("Location: index.php");
}
?>
