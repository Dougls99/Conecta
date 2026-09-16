<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Conecta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Acessar Conta</h4>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'conta_criada'): ?>
                        <div class="alert alert-success">Conta criada com sucesso! Faça login abaixo.</div>
                    <?php endif; ?>

                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'dados_invalidos'): ?>
                        <div class="alert alert-danger">E-mail ou senha incorretos.</div>
                    <?php endif; ?>

                    <form action="autenticar.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small>Ainda não tem conta? <a href="criar_conta.php">Cadastre-se</a></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>