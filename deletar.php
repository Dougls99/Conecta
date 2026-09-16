<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

// Exige login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    try {
        // Validação: Deleta APENAS se o id pertencer ao usuário logado OU se o usuário for admin
        if ($_SESSION['usuario_perfil'] === 'admin') {
            $sql = "DELETE FROM empreendedores WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
        } else {
            $sql = "DELETE FROM empreendedores WHERE id = :id AND usuario_id = :usuario_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':usuario_id', $_SESSION['usuario_id']);
        }

        $stmt->execute();

        header('Location: index.php?msg=deletado');
        exit;

    } catch (PDOException $e) {
        die("Erro ao excluir registro: " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit;
}