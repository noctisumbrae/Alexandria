<?php
session_start();
require_once "../controller/seguranca.php";
require_once "../controller/conexao.php";

$mensagem = $_GET["mensagem"] ?? "";
$sql = "SELECT l.id_livro, l.titulo, a.nome AS autor, l.editora, l.categoria, l.ano_publicacao, l.quantidade FROM livros l INNER JOIN autores a ON l.id_autor = a.id_autor ORDER BY l.titulo";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livros - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="cadastro_livro.php">Cadastrar Livro</a>
            <a href="gerenciar_autores.php">Autores</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Livros cadastrados</h2>
            <p>Visualização dos livros registrados no sistema.</p>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Editora</th>
                        <th>Categoria</th>
                        <th>Ano</th>
                        <th>Disponíveis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($livro = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo intval($livro["id_livro"]); ?></td>
                                <td><?php echo htmlspecialchars($livro["titulo"]); ?></td>
                                <td><?php echo htmlspecialchars($livro["autor"]); ?></td>
                                <td><?php echo htmlspecialchars($livro["editora"]); ?></td>
                                <td><?php echo htmlspecialchars($livro["categoria"]); ?></td>
                                <td><?php echo intval($livro["ano_publicacao"]); ?></td>
                                <td><?php echo intval($livro["quantidade"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Nenhum livro cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Alexandria - Área administrativa</p>
    </footer>
</body>
</html>
