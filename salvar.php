<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

// Impede gravação de não logados
if (!isset($_SESSION['usuario_id'])) {
    die("Acesso negado. Você precisa estar logado para cadastrar.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome_negocio     = trim($_POST['nome_negocio'] ?? '');
    $nome_responsavel = trim($_POST['nome_responsavel'] ?? '');
    $whatsapp         = trim($_POST['whatsapp'] ?? '');
    $categoria        = trim($_POST['categoria'] ?? '');
    $bairro           = trim($_POST['bairro'] ?? '');
    $descricao        = trim($_POST['descricao'] ?? '');
    $usuario_id       = $_SESSION['usuario_id']; // ID do usuário logado

    if (empty($nome_negocio) || empty($nome_responsavel) || empty($whatsapp) || empty($categoria)) {
        die("Por favor, preencha todos os campos obrigatórios.");
    }

    try {
        $sql = "INSERT INTO empreendedores (nome_negocio, nome_responsavel, whatsapp, categoria, bairro, descricao, usuario_id) 
                VALUES (:nome_negocio, :nome_responsavel, :whatsapp, :categoria, :bairro, :descricao, :usuario_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome_negocio', $nome_negocio);
        $stmt->bindValue(':nome_responsavel', $nome_responsavel);
        $stmt->bindValue(':whatsapp', $whatsapp);
        $stmt->bindValue(':categoria', $categoria);
        $stmt->bindValue(':bairro', $bairro);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':usuario_id', $usuario_id);

        $stmt->execute();

        header('Location: cadastrar.php?sucesso=1');
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
}