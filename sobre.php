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
                <a href="sobre.php" class="uppercase bold">Sobre</a>
                <a href="#" class="uppercase bold">Contato</a>
                <a href="login.php" class="uppercase bold">Login</a>
            </nav>
        </div>
    </header>

    <main class="main_sobre">
        <div class="container">
            <!-- Titulo do Main -->
            <h1 class="bold">Gestão de Fornecedores e Produtos</h1>

            <!-- Section para separar um tamanho especifico para o bloco -->
            <section class="elemento_principal_sobre">
                <section class="descrição_sobre">
                    <!-- Descrição da empresa -->
                    <div class="fundo-transparente_sobre"></div>
                    <p>FutureByte oferece uma plataforma ideal para gerenciar, armazenar e organizar os dados da sua empresa. Simplifique a gestão de seus fornecedores e produtos, ganhando eficiência e controle nas suas operações. Experimente a FutureByte e descubra como podemos transformar a maneira como você faz negócios!</p>
                </section>

                <section>       
                    <!-- Slogan chamativo -->
                    <p class="bold">Clique aqui para organizar sua vida e empresa!!</p>

                    <!-- Link para redirecionar para a Pagina de Cadastro -->
                    <a href="cadastro_usuario.php">    
                        <!-- Botão chamativo para fazer o Cadastro -->
                        <button class="uppercase bold botão_redirecionarCadastro">Crie uma conta e começe já !!</button>
                    </a>
                </section>
            </section>
        </div>
    </main>

    <footer class="fundo_footerTransparente">
        <div class="container">
            <p>FutureByte © 2024 - Todos os direitos reservados</p>
        </div>
    </footer>

</body>
</html>

<!-- por enquanto a programação é basica e apenas segue o que esta no figma, contem 6 arquivos HTML e 1 arquivo CSS com tela de login, uma pagina principal,
2 telas de cadastro de produtos e empresas e 2 telas para acessar as tabelas. No momento as paginas apenas conversão entre si com botoes para ir
de uma pagina para outra, no futuro (proximas sprints) agnt pretende melhorar o clean code e como ele é contruido, adicionar funções javascript e o banco
de dados com php

A programação foi feita com 6 arquivos HTML e 1 arquivo CSS com tela de login, uma pagina principal, 2 telas de cadastro de produtos e empresas e 
2 telas para acessar as tabelas, o HTML é simples e facil de entender porem no CSS falta um pouco de organização devido as alterações frequentes no 
desing da pagina, não foi dificil fazer os arquivos HTML nem CSS mas a falta de organização atrabalhou bastante -->