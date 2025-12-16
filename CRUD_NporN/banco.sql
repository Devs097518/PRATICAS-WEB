CREATE DATABASE IF NOT EXISTS clinica;
USE clinica;

CREATE TABLE medico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    crm VARCHAR(20) NOT NULL,
    especialidade VARCHAR(50) NOT NULL
);

CREATE TABLE paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(20)
);

CREATE TABLE consulta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medico_id INT NOT NULL,
    paciente_id INT NOT NULL,
    data_consulta DATE NOT NULL,
    horario TIME NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (medico_id) REFERENCES medico(id) ON DELETE CASCADE,
    FOREIGN KEY (paciente_id) REFERENCES paciente(id) ON DELETE CASCADE
);

-- Dados de exemplo
INSERT INTO medico (nome, crm, especialidade) VALUES 
('Dr. João Silva', 'CRM-12345', 'Cardiologia'),
('Dra. Maria Santos', 'CRM-67890', 'Pediatria');

INSERT INTO paciente (nome, cpf, telefone) VALUES 
('Carlos Oliveira', '123.456.789-00', '(81) 98765-4321'),
('Ana Paula', '987.654.321-00', '(81) 91234-5678');