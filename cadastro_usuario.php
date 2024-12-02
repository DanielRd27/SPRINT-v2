<!-- 2ª Digitação (Aqui) -->
<?php
// Inicia uma sessão para armazenar informações do usuário durante a navegação.
session_start();

// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Monta a consulta SQL para verificar se o usuário existem no banco.
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    // Executa a consulta e armazena o resultado.
    $result = $conn->query($sql);

    // Verifica se a consulta retornou algum registro.
    if ($result->num_rows > 0) {
        // Se o usuário for encontrado, mensagem de error
        $error = "Usuario ja existe";
    } else {
        // Caso não ache ninguem com esse user o adicione no banco de dados
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES ('$usuario', MD5('$senha'))";
        $mensagem = "Fornecedor cadastrado com sucesso!";
    }

    // Executa a query e verifica se houve erro
    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login FutureByte</title>
</head>
<body class="imagem_fundo">
    <header>
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
    </header class="fundo_headerTransparente">

    <main>
        <div class="container login_container">
            <div class="card_login">
                <!-- Titulo -->
                <h1 class="uppercase noMargin">Cadastro</h1>

                <!-- Textinho com orientação -->
                <p class="noMargin">Por favor, insira sua senha e login para continuar.</p>

                <form method="post" action="">
                    <!-- Inputs -->
                    <input type="text" placeholder="Usuario / Email" name="usuario" require>
                    <input type="password" placeholder="Senha" name="senha" require>

                    <!-- Esqueceu sua senha? (isso nao funciona) -->
                    <u><i>Não esqueça de confirir a senha</i></u>

                    <!-- Botão de login -->
                    <button type="submit">Cadastrar-se</button>

                    <!-- Exibe a mensagem de erro, se houver. -->
                    <?php
                        if (isset($mensagem)) echo "<p class='message' " . (strpos($mensagem, 'Erro') !== false ? "error" : "success") . "'>$mensagem</p>";
                        if (isset($mensagem_erro)) echo "<p class='error'>$mensagem_erro</p>";
                    ?>
                </form>

                <!-- Redirecionar para a pagina de cadastro -->
                <p><i>Já tem uma conta?</i> <a href="login.php"><i><u>Entre Nela</u></i></a></p>
            </div>
        </div>
    </main>

    <footer class="fundo_footerTransparente">
        <div class="container">
            <p>FutureByte © 2024 - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>