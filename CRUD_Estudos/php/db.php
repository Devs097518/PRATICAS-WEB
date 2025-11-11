<?php

// ...existing code...
$host = '127.0.0.1'; // usar 127.0.0.1 em vez de localhost:8000
$port = 3306;        // porta padrão do MySQL
$db   = 'sistema_ifpe';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_TIMEOUT => 5, // timeout em segundos
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Em dev mostre o erro; em produção logue e exiba mensagem genérica
    die('Erro de conexão com o banco de dados: ' . $e->getMessage());
}
// ...existing code...
?>
