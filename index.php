<?php
require_once __DIR__ . '/config/conexao.php';

// Captura o termo digitado na busca (se houver)
$busca = trim($_GET['q'] ?? '');

try {
    if (!empty($busca)) {
        // Busca filtrada por nome, categoria, bairro ou descrição
        $sql = "SELECT * FROM empreendedores 
                WHERE status = 'ativo' 
                AND (nome_negocio LIKE :busca OR categoria LIKE :busca OR bairro LIKE :busca OR descricao LIKE :busca)
                ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca', '%' . $busca . '%');
        $stmt->execute();
    } else {
        // Busca todos os ativos (mais recentes primeiro)
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
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Barra de Navegação Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-shop me-2"></i>Conecta Local</a>
            <a href="cadastrar.php" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-circle me-1"></i> Cadastrar Negócio</a>
        </div>
    </nav>

    <div class="container py-4">
        
        <!-- Cabeçalho e Campo de Busca -->
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

        <!-- Cards de Empreendedores -->
        <div class="row g-4">
            <?php if (count($empreendedores) > 0): ?>
                <?php foreach ($empreendedores as $item): ?>
                    <?php 
                        // Limpa o número de WhatsApp para gerar o link do wa.me apenas com números
                        $whatsapp_num = preg_replace('/[^0-9]/', '', $item['whatsapp']);
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
                                       class="btn btn-success w-100 fw-medium">
                                        <i class="bi bi-whatsapp me-2"></i>Falar no WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center py-4" role="alert">
                        <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                        Nenhum empreendedor encontrado <?= !empty($busca) ? 'para a busca "' . htmlspecialchars($busca) . '"' : 'cadastrado até o momento.' ?>.
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>