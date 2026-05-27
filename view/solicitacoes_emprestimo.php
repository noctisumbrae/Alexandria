<?php
session_start();
require_once "../controller/seguranca.php";
require_once "../controller/conexao.php";

$mensagem = $_GET["mensagem"] ?? "";
$sql = "SELECT e.id_emprestimo, e.data_solicitacao, e.status, l.titulo, l.quantidade, r.nome AS leitor FROM emprestimos e INNER JOIN livros l ON e.id_livro = l.id_livro INNER JOIN leitores r ON e.id_leitor = r.id_leitor WHERE e.status = 'pendente' ORDER BY e.data_solicitacao ASC";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações - Alexandria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <a class="logo-site" href="../index.php">
            <img src="../assets/img/logo_alexandria.webp" alt="Logo Alexandria">
        </a>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="devolucoes.php">Devoluções</a>
            <a href="gerenciar_livros.php">Livros</a>
            <a href="../controller/auth.php?acao=logout">Sair</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Solicitações de empréstimo</h2>
            <p>Aprove ou recuse os pedidos feitos pelos leitores.</p>

            <?php if ($mensagem !== ""): ?>
                <p class="aviso">Mensagem: <?php echo htmlspecialchars(str_replace("_", " ", $mensagem)); ?></p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Leitor</th>
                        <th>Livro</th>
                        <th>Data</th>
                        <th>Disponíveis</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($emprestimo = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo intval($emprestimo["id_emprestimo"]); ?></td>
                                <td><?php echo htmlspecialchars($emprestimo["leitor"]); ?></td>
                                <td><?php echo htmlspecialchars($emprestimo["titulo"]); ?></td>
                                <td><?php echo htmlspecialchars($emprestimo["data_solicitacao"]); ?></td>
                                <td><?php echo intval($emprestimo["quantidade"]); ?></td>
                                <td>
                                    <form class="form-linha" action="../controller/emprestimos.php" method="post">
                                        <input type="hidden" name="acao" value="aprovar">
                                        <input type="hidden" name="id_emprestimo" value="<?php echo intval($emprestimo["id_emprestimo"]); ?>">
                                        <button type="submit">Aprovar</button>
                                    </form>
                                    <form class="form-linha" action="../controller/emprestimos.php" method="post">
                                        <input type="hidden" name="acao" value="recusar">
                                        <input type="hidden" name="id_emprestimo" value="<?php echo intval($emprestimo["id_emprestimo"]); ?>">
                                        <button type="submit">Recusar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Nenhuma solicitação pendente.</td>
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
