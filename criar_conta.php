<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Conecta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Criar Conta</h4>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($_GET['erro']) && $_GET['erro'] === 'email_existe'): ?>
                        <div class="alert alert-danger">Este e-mail já está cadastrado.</div>
                    <?php endif; ?>

                    <form action="salvar_usuario.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Seu Nome Completo *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha *</label>
                            <input type="password" class="form-control" id="senha" name="senha" minlength="6" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Cadastrar</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small>Já tem uma conta? <a href="login.php">Fazer Login</a></small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>