<?php
session_start();
require_once "../controller/seguranca.php";
require_once "../controller/conexao.php";

$resultado = mysqli_query($conexao, "SELECT id_leitor, nome, email, telefone, cpf, data_cadastro FROM leitores ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitores - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="gerenciar_funcionarios.php">Funcionários</a>
            <a href="gerenciar_autores.php">Autores</a>
            <a href="gerenciar_livros.php">Livros</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Leitores cadastrados</h2>
            <p>Visualização dos leitores registrados no sistema.</p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($leitor = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo intval($leitor["id_leitor"]); ?></td>
                                <td><?php echo htmlspecialchars($leitor["nome"]); ?></td>
                                <td><?php echo htmlspecialchars($leitor["email"]); ?></td>
                                <td><?php echo htmlspecialchars($leitor["telefone"]); ?></td>
                                <td><?php echo htmlspecialchars($leitor["cpf"]); ?></td>
                                <td><?php echo htmlspecialchars($leitor["data_cadastro"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhum leitor cadastrado.</td>
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
