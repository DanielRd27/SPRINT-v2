<?php
// Inicia uma sessão para armazenar informações do usuário durante a navegação.
session_start();

// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Verifica se a requisição foi feita através do método POST (envio do formulário).
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados enviados pelo formulário (usuário e senha).
    $usuario = $_POST['usuario'];
    // Aplica o algoritmo MD5 para criptografar a senha antes de verificar no banco de dados.
    $senha = md5($_POST['senha']);

    // Monta a consulta SQL para verificar se o usuário e senha existem no banco.
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
    // Executa a consulta e armazena o resultado.
    $result = $conn->query($sql);

    // Verifica se a consulta retornou algum registro.
    if ($result->num_rows > 0) {
        // Se o usuário for encontrado, armazena seu nome na sessão.
        $_SESSION['usuario'] = $usuario;

        // Busca o dado nivel do usuario e armazena seu nivel de acesso
        $row = $result->fetch_assoc();
        $_SESSION['nivel'] = $row['nivel'];
        // Redireciona o usuário para a página inicial.
        header('Location: index.php');
    } else {
        // Se o login falhar, define uma mensagem de erro.
        $error = "Usuário ou senha inválidos.";
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
    <header class="fundo_headerTransparente">
        <div class="logo_container fundo_headerTransparente">
            <div class="Logo">
                <img src="img/logo.png" alt="">
                <p class="logo_nome uppercase bold">FutureByte</p>
            </div>

            <nav>
                <a href="login.php" class="uppercase bold">Login</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container login_container">
            <div class="card_login">
                <!-- Titulo -->
                <h1 class="uppercase noMargin">Entrar</h1>

                <!-- Textinho com orientação -->
                <p class="noMargin">Por favor, insira sua senha e login para continuar.</p>

                <form method="post" action="">
                    <!-- Inputs -->
                    <input type="text" placeholder="Usuario / Email" name="usuario" require>
                    <input type="password" placeholder="Senha" name="senha" require>

                    <!-- Esqueceu sua senha? (isso nao funciona) -->
                    <a href="#"><u><i>Esqueceu sua senha?</i></u></a>

                    <!-- Botão de login -->
                    <button type="submit">Login</button>

                    <!-- Exibe a mensagem de erro, se houver. -->
                    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
                </form>

                <!-- Redirecionar para a pagina de cadastro -->
                <p><i>Não Tem Uma Conta Ainda? Peça para seu superior</i></p>
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
