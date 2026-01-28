<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Verificar se o ID foi passado
if(!isset($_GET['id'])) {
    die('ID da consulta não informado');
}

// Buscar dados da consulta específica
$stmt = $pdo->prepare("
    SELECT c.*, 
           m.nome as medico_nome, m.especialidade, m.crm,
           p.nome as paciente_nome, p.cpf, p.telefone
    FROM consulta c
    INNER JOIN medico m ON c.medico_id = m.id
    INNER JOIN paciente p ON c.paciente_id = p.id
    WHERE c.id = ?
");
$stmt->execute([$_GET['id']]);
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$consulta) {
    die('Consulta não encontrada');
}

// Configurar DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Criar o HTML do relatório
$html = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            background-color: #f0f0f0;
            padding: 8px;
            margin-bottom: 10px;
        }
        .info-line {
            margin: 5px 0;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Consulta Médica</h1>
        <p>Gerado em: ' . date('d/m/Y H:i:s') . '</p>
    </div>
    
    <div class="section">
        <h3>Informações da Consulta</h3>
        <div class="info-line">
            <span class="label">ID:</span> ' . $consulta['id'] . '
        </div>
        <div class="info-line">
            <span class="label">Data:</span> ' . date('d/m/Y', strtotime($consulta['data_consulta'])) . '
        </div>
        <div class="info-line">
            <span class="label">Horário:</span> ' . date('H:i', strtotime($consulta['horario'])) . '
        </div>
    </div>
    
    <div class="section">
        <h3>Dados do Médico</h3>
        <div class="info-line">
            <span class="label">Nome:</span> ' . htmlspecialchars($consulta['medico_nome']) . '
        </div>
        <div class="info-line">
            <span class="label">Especialidade:</span> ' . htmlspecialchars($consulta['especialidade']) . '
        </div>
        ' . (isset($consulta['crm']) ? '<div class="info-line"><span class="label">CRM:</span> ' . htmlspecialchars($consulta['crm']) . '</div>' : '') . '
    </div>
    
    <div class="section">
        <h3>Dados do Paciente</h3>
        <div class="info-line">
            <span class="label">Nome:</span> ' . htmlspecialchars($consulta['paciente_nome']) . '
        </div>
        ' . (isset($consulta['cpf']) ? '<div class="info-line"><span class="label">CPF:</span> ' . htmlspecialchars($consulta['cpf']) . '</div>' : '') . '
        ' . (isset($consulta['telefone']) ? '<div class="info-line"><span class="label">Telefone:</span> ' . htmlspecialchars($consulta['telefone']) . '</div>' : '') . '
    </div>
    
    <div class="section">
        <h3>Observações</h3>
        <p>' . nl2br(htmlspecialchars($consulta['observacoes'] ?: 'Nenhuma observação registrada')) . '</p>
    </div>
    
    <div class="footer">
        <p>Este documento foi gerado automaticamente pelo sistema.</p>
    </div>
</body>
</html>
';

// Carregar HTML no DomPDF
$dompdf->loadHtml($html);

// Configurar tamanho e orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream("relatorio_consulta_" . $consulta['id'] . ".pdf", [
    "Attachment" => false // false para visualizar no navegador, true para forçar download
]);