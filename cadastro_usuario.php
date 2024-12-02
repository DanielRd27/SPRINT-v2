<!-- 2ª Digitação (Aqui) -->
<?php
// Inicia uma sessão para armazenar informações do usuário durante a navegação.
session_start();

// Inclui o arquivo de conexão com o banco de dados.
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $usuario = $_POST['usuario'];
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

    <main>
        <div class="container">
            <section class="formulario">
                <h2>Cadastro de Fornecedor</h2>
                <!-- Formulário para cadastro/edição de fornecedor -->
                <form method="post" action="" enctype="multipart/form-data" class="formularios_posLogin">
                    <input type="hidden" name="id" value="<?php echo $produto['id'] ?? ''; ?>">
                    
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php echo $produto['nome'] ?? ''; ?>" required>

                    <label for="codigo">Código:</label>
                    <input type="text" name="codigo" value="<?php echo $produto['codigo'] ?? ''; ?>" required>

                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" value="<?php echo $produto['usuario'] ?? ''; ?>" required>

                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" value="<?php echo $produto['senha'] ?? ''; ?>" required>

                    <label for="nivel">Nivel:</label>
                    <select name="nivel" required>
                        <option value="">1</option>
                        <option value="">2</option>
                    </select>

                    <br>
                    <button type="submit"><?php echo $produto ? 'Atualizar' : 'Cadastrar'; ?></button>
                </form>
                
                <!-- Exibe mensagens de sucesso ou erro -->
                <?php
                if (isset($mensagem)) echo "<p class='message success bold uppercase'" . (strpos($mensagem, 'Erro') !== false ? "error" : "success") . "'>$mensagem</p>";
                if (isset($mensagem_erro)) echo "<p class='message error bold uppercase'>$mensagem_erro</p>";
                ?>
            </section>

            <section class="tabela">
                <h2>Listagem de Usuarios</h2>
                <!-- Tabela para listar os produtos cadastrados -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Usuario</th>
                            <th>Senha</th>
                            <th>Nivel</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $produtos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td><?php echo $row['senha']; ?></td>
                            <td><?php echo $row['nivel']; ?></td>

                            <td>
                                <a href="cadastro_produto.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
                                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <div class="actions">
                    <a href="index.php" class="back-button"><button>Voltar</button></a>
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