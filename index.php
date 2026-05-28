<?php
session_start();
require_once "controller/conexao.php";

$sql = "SELECT l.id_livro, l.titulo, l.editora, l.categoria, l.ano_publicacao, l.quantidade, l.descricao, l.imagem, a.nome AS autor FROM livros l INNER JOIN autores a ON l.id_autor = a.id_autor ORDER BY l.id_livro DESC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alexandria</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="index.php">
            <img src="assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="index.php">Catálogo</a>
            <a href="view/cadastro_leitor.php">Cadastro de Leitor</a>
            <a href="view/cadastro_funcionario.php">Cadastro de Funcionário</a>
            <?php if (isset($_SESSION["id_usuario"])): ?>
                <?php if ($_SESSION["tipo_usuario"] === "funcionario"): ?>
                    <a href="view/dashboard.php">Dashboard</a>
                <?php endif; ?>
                <a href="controller/auth.php?acao=logout">Sair</a>
            <?php else: ?>
                <a href="view/login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <figure class="hero-imagem">
            <img src="assets/img/hero.webp" alt="Explore o acervo de Alexandria">
        </figure>

        <section>
            <h2>Catálogo de livros</h2>

            <section class="catalogo">
                <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                    <?php while ($livro = mysqli_fetch_assoc($resultado)): ?>
                        <article class="card-livro">
                            <figure>
                                <img src="<?php echo htmlspecialchars($livro["imagem"] ?: "assets/img/livro.svg"); ?>" alt="Capa do livro <?php echo htmlspecialchars($livro["titulo"]); ?>">
                            </figure>
                            <h3><?php echo htmlspecialchars($livro["titulo"]); ?></h3>
                            <p><strong>Autor:</strong> <?php echo htmlspecialchars($livro["autor"]); ?></p>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($livro["categoria"]); ?></p>
                            <p><strong>Disponíveis:</strong> <?php echo intval($livro["quantidade"]); ?></p>
                            <a class="botao" href="view/detalhes_livro.php?id=<?php echo intval($livro["id_livro"]); ?>">Ver detalhes</a>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <article class="card-livro">
                        <h3>Nenhum livro cadastrado</h3>
                        <p>Entre como funcionário para cadastrar autores e livros.</p>
                    </article>
                <?php endif; ?>
            </section>
        </section>
    </main>

    <footer>
        <p>Alexandria - Sistema acadêmico de biblioteca pública</p>
    </footer>

    <div id="chat-popup" class="chat-popup">
        <div class="chat-header">
            <h3>Assistente Alexandria</h3>
            <button id="close-chat">X</button>
        </div>
        <div class="chat-body" id="chat-body"></div>
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Digite sua dúvida...">
            <button id="send-chat">Enviar</button>
        </div>
    </div>
    <button id="open-chat" class="chat-btn">💬</button>
    <script src="assets/js/script.js"></script>
</body>
</html>
