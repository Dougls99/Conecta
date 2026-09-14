<?php
require_once __DIR__ . '/config/conexao.php';

// Verifica se os dados vieram do formulário via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura e limpa as entradas do formulário
    $nome_negocio     = trim($_POST['nome_negocio'] ?? '');
    $nome_responsavel = trim($_POST['nome_responsavel'] ?? '');
    $whatsapp         = trim($_POST['whatsapp'] ?? '');
    $categoria        = trim($_POST['categoria'] ?? '');
    $bairro           = trim($_POST['bairro'] ?? '');
    $descricao        = trim($_POST['descricao'] ?? '');

    // Validação simples de campos obrigatórios
    if (empty($nome_negocio) || empty($nome_responsavel) || empty($whatsapp) || empty($categoria)) {
        die("Por favor, preencha todos os campos obrigatórios.");
    }

    try {
        // Query com Prepared Statement (Seguro contra SQL Injection)
        $sql = "INSERT INTO empreendedores (nome_negocio, nome_responsavel, whatsapp, categoria, bairro, descricao) 
                VALUES (:nome_negocio, :nome_responsavel, :whatsapp, :categoria, :bairro, :descricao)";

        $stmt = $pdo->prepare($sql);

        // Associa os valores aos parâmetros da consulta
        $stmt->bindValue(':nome_negocio', $nome_negocio);
        $stmt->bindValue(':nome_responsavel', $nome_responsavel);
        $stmt->bindValue(':whatsapp', $whatsapp);
        $stmt->bindValue(':categoria', $categoria);
        $stmt->bindValue(':bairro', $bairro);
        $stmt->bindValue(':descricao', $descricao);

        // Executa a gravação no banco
        $stmt->execute();

        // Redireciona de volta com parâmetro de sucesso na URL
        header('Location: cadastrar.php?sucesso=1');
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar no banco de dados: " . $e->getMessage());
    }
} else {
    // Se tentarem acessar salvar.php diretamente pela URL
    header('Location: cadastrar.php');
    exit;
}