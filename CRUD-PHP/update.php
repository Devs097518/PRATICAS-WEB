<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM usuarios WHERE id=$id");
$row = $res->fetch_assoc();
?>

<form method="post">
  <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
  <button type="submit">Atualizar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $conn->query("UPDATE usuarios SET nome='$nome' WHERE id=$id");
  header("Location: index.php");
}
?>
