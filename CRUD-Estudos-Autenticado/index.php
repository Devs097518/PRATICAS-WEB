<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD disciplinas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gerenciamento de disciplinas</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="php/index-disciplina.php">Listar disciplinas</a></li>
                    <li><a href="php/create-disciplina.php">Adicionar disciplina</a></li>
                    <li><a href="php/logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li><a href="php/user-login.php">Login</a></li>
                    <li><a href="php/user-register.php">Registrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bem-vindo ao CRUD de disciplinas</h2>
        <p>Utilize o menu acima para navegar pelo sistema.</p>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gerenciamento de disciplinas</p>
    </footer>
</body>
</html>
