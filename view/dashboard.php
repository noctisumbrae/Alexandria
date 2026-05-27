<?php
session_start();
require_once "../controller/seguranca.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="../index.php">Catálogo</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main>
        <section class="painel">
            <article>
                <h3>Leitores</h3>
                <p>Visualizar leitores cadastrados.</p>
                <a class="botao" href="gerenciar_leitores.php">Gerenciar leitores</a>
            </article>

            <article>
                <h3>Funcionários</h3>
                <p>Visualizar funcionários cadastrados.</p>
                <a class="botao" href="gerenciar_funcionarios.php">Gerenciar funcionários</a>
            </article>

            <article>
                <h3>Autores</h3>
                <p>Cadastrar e visualizar autores.</p>
                <a class="botao" href="cadastro_autor.php">Cadastrar autor</a>
                <a class="botao secundario" href="gerenciar_autores.php">Ver autores</a>
            </article>

            <article>
                <h3>Livros</h3>
                <p>Cadastrar e visualizar livros.</p>
                <a class="botao" href="cadastro_livro.php">Cadastrar livro</a>
                <a class="botao secundario" href="gerenciar_livros.php">Ver livros</a>
            </article>

            <article>
                <h3>Solicitações</h3>
                <p>Aprovar ou recusar solicitações de empréstimo.</p>
                <a class="botao" href="solicitacoes_emprestimo.php">Ver solicitações</a>
            </article>

            <article>
                <h3>Devoluções</h3>
                <p>Registrar devolução de livros emprestados.</p>
                <a class="botao" href="devolucoes.php">Registrar devoluções</a>
            </article>
        </section>
    </main>

    <footer>
        <p>Alexandria - Área administrativa</p>
    </footer>
</body>
</html>
