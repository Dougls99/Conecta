<?php
require_once __DIR__ . '/config/conexao.php';

try {
    // 1. Tabela de usuários
    $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        perfil ENUM('admin', 'empreendedor') DEFAULT 'empreendedor',
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sqlUsuarios);
    echo "Tabela 'usuarios' criada com sucesso!<br>";

    // 2. Adiciona a coluna usuario_id na tabela empreendedores
    $colunaExiste = $pdo->query("SHOW COLUMNS FROM empreendedores LIKE 'usuario_id'")->fetch();
    if (!$colunaExiste) {
        $sqlAlter = "ALTER TABLE empreendedores ADD COLUMN usuario_id INT NULL AFTER id;";
        $pdo->exec($sqlAlter);
        echo "Coluna 'usuario_id' adicionada em 'empreendedores'!<br>";
    } else {
        echo "A coluna 'usuario_id' já existe na tabela 'empreendedores'.<br>";
    }

    echo "<br><strong>Banco de dados atualizado com sucesso!</strong>";

} catch (PDOException $e) {
    die("Erro ao atualizar o banco de dados: " . $e->getMessage());
}