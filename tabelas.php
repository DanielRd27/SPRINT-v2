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

                <!-- Card 3 -->
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

                <!-- Card 4 -->
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
