<?php
// Inclui o arquivo que valida a sessão do usuário
include('valida_sessao.php');
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $cnpj = $_POST['cnpj'];
    $observacoes = $_POST['observacoes'];

    // Prepara a query SQL para inserção ou atualização
    if ($id) {
        // Se o ID existe, é uma atualização
        $sql = "UPDATE fornecedores SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco', cnpj='$cnpj', observacoes='$observacoes'";
        
        $sql .= " WHERE id='$id'";
        $mensagem = "Fornecedor atualizado com sucesso!";
    } else {
        // Se não há ID, é uma nova inserção
        $sql = "INSERT INTO fornecedores (nome, email, telefone, endereco, cnpj, observacoes) VALUES ('$nome', '$email', '$telefone', '$endereco', '$cnpj', '$observacoes')";
        $mensagem = "Fornecedor cadastrado com sucesso!";
    }

    // Executa a query e verifica se houve erro
    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

// Verifica se foi solicitada a exclusão de um fornecedor
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Verifica se o fornecedor tem produtos cadastrados
    $check_produtos = $conn->query("SELECT COUNT(*) as count FROM produtos WHERE fornecedor_id = '$delete_id'")->fetch_assoc();
    
    if ($check_produtos['count'] > 0) {
        $mensagem = "Não é possível excluir este fornecedor pois existem produtos cadastrados para ele.";
    } else {
        $sql = "DELETE FROM fornecedores WHERE id='$delete_id'";
        if ($conn->query($sql) === TRUE) {
            $mensagem = "Fornecedor excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir fornecedor: " . $conn->error;
        }
    }
}

// Busca todos os fornecedores para listar na tabela
$fornecedores = $conn->query("SELECT * FROM fornecedores");

// Se foi solicitada a edição de um fornecedor, busca os dados dele
$fornecedor = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $fornecedor = $conn->query("SELECT * FROM fornecedores WHERE id='$edit_id'")->fetch_assoc();
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
                    <input type="hidden" name="id" value="<?php echo $fornecedor['id'] ?? ''; ?>">
                    
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php echo $fornecedor['nome'] ?? ''; ?>" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $fornecedor['email'] ?? ''; ?>">
                    
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" value="<?php echo $fornecedor['telefone'] ?? ''; ?>">

                    <label for="endereço">Endereço:</label>
                    <input type="text" name="endereco" value="<?php echo $fornecedor['endereco'] ?? ''; ?>">

                    <label for="CNPJ">CNPJ:</label>
                    <input type="text" name="cnpj" value="<?php echo $fornecedor['cnpj'] ?? ''; ?>">

                    <label for="observações">Observações:</label>
                    <input class="obs" type="text" name="observacoes" value="<?php echo $fornecedor['observacoes'] ?? ''; ?>">
                    
                    <br>
                    <button type="submit"><?php echo $fornecedor ? 'Atualizar' : 'Cadastrar'; ?></button>
                </form>
                
                <!-- Exibe mensagens de sucesso ou erro -->
                <?php
                if (isset($mensagem)) echo "<p class='success bold uppercase'" . (strpos($mensagem, 'Erro') !== false ? "error" : "success") . "'>$mensagem</p>";
                if (isset($mensagem_erro)) echo "<p class='error bold uppercase'>$mensagem_erro</p>";
                ?>
            </section>

            <section class="tabela">
                <h2>Listagem de Fornecedores</h2>
                <!-- Tabela para listar os fornecedores cadastrados -->
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>CNPJ</th>
                        <th>Obs</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($row = $fornecedores->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                        <td><?php echo $row['endereco']; ?></td>
                        <td><?php echo $row['cnpj']; ?></td>
                        <td><?php echo $row['observacoes']; ?></td>
                        <td>
                            <a href="?edit_id=<?php echo $row['id']; ?>">Editar</a>
                            <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
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