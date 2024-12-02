<?php 

include('valida_sessao.php');


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
                <a href="tabelas.php" class="uppercase bold">Tabelas</a>
                <a href="index.php" class="uppercase bold">Home</a>
                <a href="cadastrar_dados.php" class="uppercase bold">Cadastro</a>
                <a href="logout.php" class="uppercase bold">Sair</a>
            </nav>
        </div>
    </header>

    <main class="main_index">
        <div class="container">
            <h2 class="bold uppercase bemvindo_index">Bem-vindo, <?php echo $_SESSION['usuario']; ?></h2>

            <section class="cardsIndex_container">
                <!-- Card 1 -->
                <div class="cardIndex">
                    <h2 class="bold uppercase">registrar Fornecedor</h2>
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

                <!-- Card 2 -->
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
