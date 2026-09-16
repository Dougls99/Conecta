<?php
session_start();
require_once __DIR__ . '/config/conexao.php';

$busca = trim($_GET['q'] ?? '');

try {
    if (!empty($busca)) {
        $sql = "SELECT * FROM empreendedores 
                WHERE status = 'ativo' 
                AND (nome_negocio LIKE :busca OR categoria LIKE :busca OR bairro LIKE :busca OR descricao LIKE :busca)
                ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca', '%' . $busca . '%');
        $stmt->execute();
    } else {
        $sql = "SELECT * FROM empreendedores WHERE status = 'ativo' ORDER BY id DESC";
        $stmt = $pdo->query($sql);
    }
    $empreendedores = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao consultar empreendedores: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conecta - Catálogo de Empreendedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Barra de Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shop me-2"></i>Conecta Local</a>
            
            <div class="d-flex align-items-center gap-2">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <span class="text-white small d-none d-md-inline me-2">
                        <i class="bi bi-person-circle me-1"></i>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </span>
                    <a href="cadastrar.php" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-circle me-1"></i> Criar Card</a>
                    <a href="logout.php" class="btn btn-danger btn-sm" title="Sair"><i class="bi bi-box-arrow-right"></i></a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i> Entrar</a>
                    <a href="criar_conta.php" class="btn btn-light btn-sm fw-bold">Cadastrar-se</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        
        <!-- Cabeçalho e Busca -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h3 class="mb-1 text-dark fw-bold">Empreendedores Locais</h3>
                <p class="text-muted mb-0">Encontre serviços e produtos perto de você</p>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
                <form action="index.php" method="GET" class="d-flex gap-2">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por nome, categoria ou bairro..." value="<?= htmlspecialchars($busca) ?>">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                    <?php if (!empty($busca)): ?>
                        <a href="index.php" class="btn btn-outline-secondary" title="Limpar busca"><i class="bi bi-x-circle"></i></a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Cards do Catálogo -->
        <div class="row g-4">
            <?php if (count($empreendedores) > 0): ?>
                <?php foreach ($empreendedores as $item): ?>
                    <?php 
                        $whatsapp_num = preg_replace('/[^0-9]/', '', $item['whatsapp']);

                        // Lógica de permissão: Pode gerenciar se for O DONO DO CARD ou se for ADMIN
                        $pode_gerenciar = false;
                        if (isset($_SESSION['usuario_id'])) {
                            if ($_SESSION['usuario_id'] == $item['usuario_id'] || $_SESSION['usuario_perfil'] === 'admin') {
                                $pode_gerenciar = true;
                            }
                        }
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                                        <?= htmlspecialchars($item['categoria']) ?>
                                    </span>
                                    <?php if (!empty($item['bairro'])): ?>
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($item['bairro']) ?></small>
                                    <?php endif; ?>
                                </div>

                                <h5 class="card-title text-dark fw-bold mb-1"><?= htmlspecialchars($item['nome_negocio']) ?></h5>
                                <p class="card-subtitle text-muted small mb-3">Responsável: <?= htmlspecialchars($item['nome_responsavel']) ?></p>

                                <p class="card-text text-secondary flex-grow-1">
                                    <?= !empty($item['descricao']) ? nl2br(htmlspecialchars($item['descricao'])) : '<em>Sem descrição cadastrada.</em>' ?>
                                </p>

                                <div class="mt-3 pt-3 border-top">
                                    <a href="https://wa.me/55<?= $whatsapp_num ?>?text=Olá,%20vi%20seu%20negócio%20no%20Conecta!" 
                                       target="_blank" 
                                       class="btn btn-success w-100 fw-medium mb-2">
                                        <i class="bi bi-whatsapp me-2"></i>Falar no WhatsApp
                                    </a>

                                    <!-- Exibe Editar/Excluir APENAS se for o dono ou admin -->
                                    <?php if ($pode_gerenciar): ?>
                                        <div class="d-flex gap-2">
                                            <a href="editar.php?id=<?= $item['id'] ?>" class="btn btn-outline-primary btn-sm flex-fill">
                                                <i class="bi bi-pencil me-1"></i>Editar
                                            </a>
                                            <a href="deletar.php?id=<?= $item['id'] ?>" 
                                               class="btn btn-outline-danger btn-sm flex-fill" 
                                               onclick="return confirm('Tem certeza que deseja excluir este cadastro?');">
                                                <i class="bi bi-trash me-1"></i>Excluir
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-4" role="alert">
                        Nenhum empreendedor encontrado.
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>