<?php
session_start();
require_once "../controller/seguranca.php";
require_once "../controller/conexao.php";

$mensagem = $_GET["mensagem"] ?? "";
$resultado = mysqli_query($conexao, "SELECT id_autor, nome, nacionalidade, biografia FROM autores ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="cadastro_autor.php">Cadastrar Autor</a>
            <a href="gerenciar_livros.php">Livros</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Autores cadastrados</h2>
            <p>Visualização dos autores registrados no sistema.</p>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Nacionalidade</th>
                        <th>Biografia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($autor = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo intval($autor["id_autor"]); ?></td>
                                <td><?php echo htmlspecialchars($autor["nome"]); ?></td>
                                <td><?php echo htmlspecialchars($autor["nacionalidade"]); ?></td>
                                <td><?php echo htmlspecialchars($autor["biografia"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nenhum autor cadastrado.</td>
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
