<?php
session_start();
require_once "../controller/seguranca.php";
$mensagem = $_GET["mensagem"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Autor - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="gerenciar_autores.php">Autores</a>
            <a href="cadastro_livro.php">Cadastrar Livro</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main class="pagina-formulario">
        <section>
            <h2>Cadastro de autor</h2>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <form action="../controller/cadastros.php" method="post">
                <input type="hidden" name="acao" value="cadastrar_autor">

                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>

                <label for="nacionalidade">Nacionalidade</label>
                <input type="text" id="nacionalidade" name="nacionalidade">

                <label for="biografia">Biografia</label>
                <textarea id="biografia" name="biografia" rows="5"></textarea>

                <button type="submit">Cadastrar autor</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Alexandria - Área administrativa</p>
    </footer>
</body>
</html>
