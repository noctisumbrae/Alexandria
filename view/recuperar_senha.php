<?php
session_start();
$mensagem = $_GET["mensagem"] ?? "";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Alexandria</title>
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
            <h2>Recuperar senha</h2>
            <p>Informe o tipo de usuário, e-mail e uma nova senha.</p>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <form action="../controller/auth.php" method="post">
                <input type="hidden" name="acao" value="recuperar">

                <label for="tipo">Tipo de usuário</label>
                <select id="tipo" name="tipo" required>
                    <option value="leitor">Leitor</option>
                    <option value="funcionario">Funcionário</option>
                </select>

                <label for="email">E-mail cadastrado</label>
                <input type="email" id="email" name="email" required>

                <label for="nova_senha">Nova senha</label>
                <input type="password" id="nova_senha" name="nova_senha" required>

                <button type="submit">Alterar senha</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Alexandria - Biblioteca pública</p>
    </footer>
</body>
</html>
