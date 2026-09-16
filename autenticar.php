<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch();

        // Compara a senha digitada com o Hash armazenado no banco
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Guarda as informações na sessão do PHP
            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nome']   = $usuario['nome'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];

            header('Location: index.php');
            exit;
        } else {
            header('Location: login.php?erro=dados_invalidos');
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao autenticar: " . $e->getMessage());
    }
} else {
    header('Location: login.php');
    exit;
}