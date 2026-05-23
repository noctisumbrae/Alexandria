<?php
session_start();
$mensagem = $_GET["mensagem"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Leitor - Alexandria</title>
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

    <main class="pagina-formulario">
        <section>
            <h2>Cadastro de leitor</h2>
            <p>Crie seu cadastro para solicitar empréstimos no catálogo.</p>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <form action="../controller/cadastros.php" method="post">
                <input type="hidden" name="acao" value="cadastrar_leitor">

                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>

                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone">

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf">

                <button type="submit">Cadastrar leitor</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Alexandria - Biblioteca pública</p>
    </footer>
</body>
</html>
