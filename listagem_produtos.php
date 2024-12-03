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
        'acoes' => $_SESSION['nivel'] <= 3,
    ];
}

// Verifica se foi solicitada a exclusão de um produto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM produtos WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $mensagem = "Produto excluído com sucesso!";
        $class = "success";
    } else {
        $mensagem = "Erro ao excluir produto: " . $stmt->error;
        $class = "error";
    }
}

// Busca todos os produtos para listar na tabela
$produtos = $conn->query("SELECT p.id,  p.codigo, p.nome, p.descricao, p.preco, p.quantidade, p.imagem, f.nome AS fornecedor_nome FROM produtos p JOIN fornecedores f ON p.fornecedor_id = f.id");

// Se foi solicitada a edição de um produto, busca os dados dele
$produto = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id=?");
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
                <h2>Listagem de Produtos</h2>
                <!-- Tabela para listar os produtos cadastrados -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Fornecedor</th>
                            <th>Imagem</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $produtos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['codigo']; ?></td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td><?php echo 'R$ ' . number_format($row['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $row['quantidade']; ?></td>
                            <td><?php echo $row['fornecedor_nome']; ?></td>
                            <td>
                                <?php if ($row['imagem']): ?>
                                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem do produto" class="thumbnail">
                                <?php else: ?>
                                    Sem imagem
                                <?php endif; ?>
                            </td>
                            <?php if($permissoes['acoes']): ?>
                                <td>
                                    <a href="cadastro_produto.php?edit_id=<?php echo $row['id']; ?>">Editar</a>
                                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                </td>
                            <?php endif; ?>
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