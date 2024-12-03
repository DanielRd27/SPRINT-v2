<?php
// Inclui o arquivo que valida a sessão do usuário
include('valida_sessao.php');
// Inclui o arquivo de conexão com o banco de dados
include('conexao.php');

$permissoes = [
    // ações
    'acoes' => false,
];

if ($_SESSION['nivel'] > 0) { 
    // Usuários de nível 2, 3 e 4 têm acesso limitado
    $permissoes = [
        'acoes' => $_SESSION['nivel'] <= 2,
    ];
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
                <a href="index.php" class="uppercase bold">Home</a>

                <?php if($_SESSION['acesso_CadUsuario']): ?>
                    <a href="cadastro_usuario.php" class="uppercase bold">Cadastrar-Funcionario</a>
                <?php endif; ?>

                <a href="logout.php" class="uppercase bold">Sair</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
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
                        <?php if($permissoes['acoes']): ?>
                            <th>Ações</th>
                        <?php endif; ?>
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
                        <?php if($permissoes['acoes']): ?>
                            <td>
                                <a href="cadastro_fornecedor.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
                                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        <?php endif; ?>
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