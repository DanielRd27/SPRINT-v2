<?php 

include('valida_sessao.php');

$permissoes = [
    'acesso_CadUsuario' => false,
    'acesso_CadFornecedor' => false,
    'acesso_CadProdutos' => false,
    'acesso_ListaFornecedor' => false,
    'acesso_ListaProdutos' => false,
];

if ($_SESSION['nivel'] > 0) { 
    // Usuários de nível 2, 3 e 4 têm acesso limitado
    $permissoes = [

        // Apenas nivel 1
        'acesso_CadUsuario' => $_SESSION['nivel'] == 1,

        // Nivel 2 pra cima
        'acesso_CadFornecedor' => $_SESSION['nivel'] <= 2,

        // Nivel 3 pra cima
        'acesso_CadProdutos' => $_SESSION['nivel'] <= 3,

        // Nivel 4 e pra cima (todos)
        'acesso_ListaFornecedor' => true,
        'acesso_ListaProdutos' => true

    ];
}

$_SESSION['acesso_CadUsuario'] = $permissoes['acesso_CadUsuario'];
$_SESSION['acesso_CadFornecedor'] = $permissoes['acesso_CadFornecedor'];
$_SESSION['acesso_CadProdutos'] = $permissoes['acesso_CadProdutos'];
$_SESSION['acesso_ListaFornecedor'] = $permissoes['acesso_ListaFornecedor'];
$_SESSION['acesso_ListaProdutos'] = $permissoes['acesso_ListaProdutos'];

?>
<!-- Inclui o arquivo 'valida_sessao.php' para garantir que o usuário esteja autenticado -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login FutureByte</title>
</head>
<body class="imagem_fundo">
    <header class="fundo_headerTransparente">
        <div class="logo_container fundo_headerTransparente">
            <div class="Logo">
                <img src="img/logo.png" alt="">
                <p class="logo_nome uppercase bold">FutureByte</p>
            </div>

            <nav>
                <a href="index.php" class="uppercase bold">Home</a>

                <?php if($permissoes['acesso_CadUsuario']): ?>
                    <a href="cadastro_usuario.php" class="uppercase bold">Cadastrar-Funcionario</a>
                <?php endif; ?>

                <a href="logout.php" class="uppercase bold">Sair</a>
            </nav>
        </div>
    </header>

    <main class="main_index">
        <div class="container">
            <h2 class="bold uppercase bemvindo_index">Bem-vindo, <?php echo $_SESSION['usuario']; ?></h2>


            <section class="cardsIndex_container">
                <?php if($permissoes['acesso_CadFornecedor']): ?>
                    <!-- Card 1  Cadastrar fornecedor -->
                    <div class="cardIndex">
                        <h2 class="bold uppercase">Cadastrar Fornecedor</h2>
                        <div class="conteudo_card">

                            <div class="img_container">
                                <img src="img/user.png" alt="">
                            </div>

                            <div class="text_card">
                                <p>Adicione rapidamente novos fornecedores preenchendo informações como nome, endereço e contato, mantendo o cadastro sempre atualizado para facilitar a gestão.</p>
                                <a href="cadastro_fornecedor.php"><button class="uppercase bold">Cadastrar</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if($permissoes['acesso_CadProdutos']): ?>
                    <!-- Card 2 Cadastrar produto -->
                    <div class="cardIndex">
                        <h2 class="bold uppercase">Cadastrar Produto</h2>
                        <div class="conteudo_card">
                            
                            <div class="img_container">
                                <img src="img/add.png" alt="">
                            </div>

                            <div class="text_card">
                                <p>Registre novos produtos com facilidade. Informe detalhes como nome, descrição, preço e quantidade em estoque. Organize seu inventário de forma eficiente.</p>
                                <a href="cadastro_produto.php"><button class="uppercase bold">Cadastrar</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($permissoes['acesso_ListaFornecedor']): ?>
                    <!-- Card 3 tabela -->
                    <div class="cardIndex">
                        <h2 class="bold uppercase">Tabela de Fornecedores</h2>
                        <div class="conteudo_card">
                            
                            <div class="img_container">
                                <img src="img/conference.png" alt="">
                            </div>

                            <div class="text_card">
                                <p>Visualize e gerencie seus fornecedores em uma tabela prática. Consulte informações detalhadas e faça alterações conforme necessário para garantir um relacionamento eficaz.</p>
                                <a href="listagem_fornecedores.php"><button class="uppercase bold">Ver Tabela</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if($permissoes['acesso_ListaProdutos']): ?>
                    <!-- Card 4 tabela -->
                    <div class="cardIndex">
                        <h2 class="bold uppercase">Tabela de Produtos</h2>
                        <div class="conteudo_card">
                            
                            <div class="img_container">
                                <img src="img/table.png" alt="">
                            </div>

                            <div class="text_card">
                                <p>Acesse sua lista de produtos de forma rápida e fácil. Monitore estoque, preços e descrições, facilitando a tomada de decisão e o gerenciamento de inventário.</p>
                                <a href="listagem_produtos.php"><button class="uppercase bold">Ver Tabela</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer class="fundo_footerTransparente">
        <div class="container ">
            <p>FutureByte © 2024 - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>
