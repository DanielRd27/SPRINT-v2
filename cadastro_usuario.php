<?php
// Inclui o arquivo que valida a sessão do usuário
include('valida_sessao.php');
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');


// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];


    // Prepara a query SQL para inserção ou atualização
    if ($id) {
        // Se o ID existe, é uma atualização
        $sql = "UPDATE usuarios SET nome=?, codigo=?, usuario=?, senha=?, nivel=?";
        $params = [$nome, $codigo, $usuario, md5($senha), $nivel];
        $sql .= " WHERE id=?";
        $params[] = $id;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $mensagem = "Usuario atualizado com sucesso!";
    } else {
        // Se não há ID, é uma nova inserção
        $sql = "INSERT INTO usuarios (nome, codigo, usuario, senha, nivel) VALUES (?, ?, ?, md5(?), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $codigo, $usuario, $senha, $nivel);
        $mensagem = "Produto cadastrado com sucesso!";
    }

    // Executa a query e verifica se houve erro
    if ($stmt->execute()) {
        $class = "success";
    } else {
        $mensagem = "Erro: " . $stmt->error;
        $class = "error";
    }
}

// Verifica se foi solicitada a exclusão de um produto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $mensagem = "Usuario excluído com sucesso!";
        $class = "success";
    } else {
        $mensagem = "Erro ao excluir Usuario: " . $stmt->error;
        $class = "error";
    }
}

// Busca todos os usuarios para listar na tabela
$usuarios = $conn->query("SELECT * FROM usuarios");

// Se foi solicitada a edição de um produto, busca os dados dele
$produto = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produto = $result->fetch_assoc();
    $stmt->close();
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
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
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
                            <th>Nivel</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td><?php echo $row['nivel']; ?></td>

                            <td>
                                <a href="cadastro_usuario.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
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