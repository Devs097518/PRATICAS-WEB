CREATE DATABASE monitoramento_estudo;

USE monitoramento_estudo;

CREATE TABLE disciplinas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    disciplina VARCHAR(20) NOT NULL,
    situacao VARCHAR(20) NOT NULL,
    anotacoes VARCHAR(200) NOT NULL,
    associado VARCHAR(2) NOT NULL
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);