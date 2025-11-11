CREATE DATABASE sistema_ifpe;

USE sistema_ifpe;


CREATE TABLE estudos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cadeira VARCHAR(20) NOT NULL,
    situacao VARCHAR(10) NOT NULL ,
    notas VARCHAR(500) NOT NULL 
);
