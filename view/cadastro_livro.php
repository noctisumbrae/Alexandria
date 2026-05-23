<?php
session_start();
require_once "../controller/seguranca.php";
require_once "../controller/conexao.php";

$mensagem = $_GET["mensagem"] ?? "";
$autores = mysqli_query($conexao, "SELECT id_autor, nome FROM autores ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livro - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="gerenciar_livros.php">Livros</a>
            <a href="cadastro_autor.php">Cadastrar Autor</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main class="pagina-formulario">
        <section>
            <h2>Cadastro de livro</h2>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <form action="../controller/cadastros.php" method="post">
                <input type="hidden" name="acao" value="cadastrar_livro">

                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="id_autor">Autor</label>
                <select id="id_autor" name="id_autor" required>
                    <option value="">Selecione</option>
                    <?php while ($autor = mysqli_fetch_assoc($autores)): ?>
                        <option value="<?php echo intval($autor["id_autor"]); ?>"><?php echo htmlspecialchars($autor["nome"]); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="editora">Editora</label>
                <input type="text" id="editora" name="editora">

                <label for="categoria">Categoria</label>
                <input type="text" id="categoria" name="categoria">

                <label for="ano_publicacao">Ano de publicação</label>
                <input type="number" id="ano_publicacao" name="ano_publicacao">

                <label for="quantidade">Quantidade disponível</label>
                <input type="number" id="quantidade" name="quantidade" min="0" required>

                <label for="imagem">Caminho da imagem da capa</label>
                <input type="text" id="imagem" name="imagem" placeholder="assets/img/livro.svg">

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="5"></textarea>

                <button type="submit">Cadastrar livro</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Alexandria - Área administrativa</p>
    </footer>
</body>
</html>