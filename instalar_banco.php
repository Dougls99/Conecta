<?php
require_once __DIR__ . '/config/conexao.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS empreendedores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_negocio VARCHAR(150) NOT NULL,
        nome_responsavel VARCHAR(150) NOT NULL,
        whatsapp VARCHAR(20) NOT NULL,
        categoria VARCHAR(80) NOT NULL,
        descricao TEXT,
        bairro VARCHAR(100),
        status ENUM('ativo', 'inativo') DEFAULT 'ativo',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($sql);
    echo "Conexão realizada e tabela 'empreendedores' criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao conectar ou criar a tabela: " . $e->getMessage();
}