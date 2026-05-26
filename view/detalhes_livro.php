<?php
session_start();
require_once "../controller/conexao.php";

$idLivro = intval($_GET["id"] ?? 0);
$mensagem = $_GET["mensagem"] ?? "";

$sql = "SELECT l.id_livro, l.titulo, l.editora, l.categoria, l.ano_publicacao, l.quantidade, l.descricao, l.imagem, a.nome AS autor FROM livros l INNER JOIN autores a ON l.id_autor = a.id_autor WHERE l.id_livro = ? LIMIT 1";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idLivro);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$livro = mysqli_fetch_assoc($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Livro - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="../index.php">Catálogo</a>
            <a href="cadastro_leitor.php">Cadastro de Leitor</a>
            <a href="cadastro_funcionario.php">Cadastro de Funcionário</a>
            <?php if (isset($_SESSION["id_usuario"])): ?>
                <?php if ($_SESSION["tipo_usuario"] === "funcionario"): ?>
                    <a href="dashboard.php">Dashboard</a>
                <?php endif; ?>
                <a href="../controller/auth.php?acao=logout">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php if ($livro): ?>
            <section class="detalhe-livro">
                <figure>
                    <img src="../<?php echo htmlspecialchars($livro["imagem"] ?: "assets/img/livro.svg"); ?>" alt="Capa do livro <?php echo htmlspecialchars($livro["titulo"]); ?>">
                </figure>

                <article>
                    <h2><?php echo htmlspecialchars($livro["titulo"]); ?></h2>

                    <?php if ($mensagem !== ""): ?>
                        <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
                    <?php endif; ?>

                    <p><strong>Autor:</strong> <?php echo htmlspecialchars($livro["autor"]); ?></p>
                    <p><strong>Editora:</strong> <?php echo htmlspecialchars($livro["editora"]); ?></p>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($livro["categoria"]); ?></p>
                    <p><strong>Ano:</strong> <?php echo intval($livro["ano_publicacao"]); ?></p>
                    <p><strong>Quantidade disponível:</strong> <?php echo intval($livro["quantidade"]); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($livro["descricao"])); ?></p>

                    <?php if (isset($_SESSION["id_usuario"]) && $_SESSION["tipo_usuario"] === "leitor"): ?>
                        <form action="../controller/emprestimos.php" method="post">
                            <input type="hidden" name="acao" value="solicitar">
                            <input type="hidden" name="id_livro" value="<?php echo intval($livro["id_livro"]); ?>">
                            <button type="submit">Solicitar empréstimo</button>
                        </form>
                    <?php elseif (!isset($_SESSION["id_usuario"])): ?>
                        <p><a class="botao" href="login.php">Faça login para solicitar empréstimo</a></p>
                    <?php else: ?>
                        <p class="aviso">Funcionários podem aprovar empréstimos no dashboard.</p>
                    <?php endif; ?>
                </article>
            </section>
        <?php else: ?>
            <section>
                <h2>Livro não encontrado</h2>
                <p>Volte para o catálogo e tente novamente.</p>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>Alexandria - Biblioteca pública</p>
    </footer>
</body>
</html>
