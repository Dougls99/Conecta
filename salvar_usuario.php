<?php
require_once __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($nome) || empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    try {
        // Verifica se o e-mail já existe
        $stmtCheck = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmtCheck->bindValue(':email', $email);
        $stmtCheck->execute();

        if ($stmtCheck->fetch()) {
            header('Location: criar_conta.php?erro=email_existe');
            exit;
        }

        // Criptografa a senha antes de gravar
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere o novo usuário
        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, 'empreendedor')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->execute();

        header('Location: login.php?sucesso=conta_criada');
        exit;

    } catch (PDOException $e) {
        die("Erro ao cadastrar usuário: " . $e->getMessage());
    }
} else {
    header('Location: criar_conta.php');
    exit;
}