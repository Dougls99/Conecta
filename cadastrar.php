<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Cadastro - Conecta</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Cadastrar Empreendimento</h4>
                    </div>
                    <div class="card-body p-4">

                    <?php if (isset($_GET['sucesso'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Sucesso!</strong> Empreendimento cadastrado com êxito no banco de dados.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

                        <form action="salvar.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="nome_negocio" class="form-label">Nome do Negócio / Empresa *</label>
                                <input type="text" class="form-control" id="nome_negocio" name="nome_negocio" placeholder="Ex: Barbearia Silva" required>
                            </div>

                            <div class="mb-3">
                                <label for="nome_responsavel" class="form-label">Nome do Responsável *</label>
                                <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Ex: João da Silva" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp *</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="(21) 99999-9999" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="categoria" class="form-label">Categoria / Ramo *</label>
                                    <select class="form-select" id="categoria" name="categoria" required>
                                        <option value="">Selecione...</option>
                                        <option value="Alimentação">Alimentação</option>
                                        <option value="Beleza e Estética">Beleza e Estética</option>
                                        <option value="Serviços Técnicos">Serviços Técnicos</option>
                                        <option value="Comércio">Comércio</option>
                                        <option value="Outros">Outros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Ex: Centro">
                            </div>

                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição do Serviço / Produto</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Conte brevemente o que seu negócio oferece..."></textarea>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Salvar Cadastro</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>