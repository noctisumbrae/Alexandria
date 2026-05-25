<?php
session_start();
require_once "conexao.php";

$acao = $_POST["acao"] ?? "";

if ($acao === "solicitar") {
    if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== "leitor") {
        header("Location: ../view/login.php?mensagem=login_necessario");
        exit;
    }

    $idLivro = intval($_POST["id_livro"] ?? 0);
    $idLeitor = intval($_SESSION["id_usuario"]);

    if ($idLivro <= 0) {
        header("Location: ../index.php?mensagem=livro_invalido");
        exit;
    }

    $sqlLivro = "SELECT quantidade FROM livros WHERE id_livro = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlLivro);
    mysqli_stmt_bind_param($stmt, "i", $idLivro);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $livro = mysqli_fetch_assoc($resultado);

    if (!$livro || intval($livro["quantidade"]) <= 0) {
        header("Location: ../view/detalhes_livro.php?id=" . $idLivro . "&mensagem=livro_indisponivel");
        exit;
    }

    $sqlRepetido = "SELECT id_emprestimo FROM emprestimos WHERE id_leitor = ? AND id_livro = ? AND status IN ('pendente', 'aprovado') LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlRepetido);
    mysqli_stmt_bind_param($stmt, "ii", $idLeitor, $idLivro);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: ../view/detalhes_livro.php?id=" . $idLivro . "&mensagem=solicitacao_repetida");
        exit;
    }

    $sql = "INSERT INTO emprestimos (id_leitor, id_livro, data_solicitacao, status) VALUES (?, ?, CURDATE(), 'pendente')";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $idLeitor, $idLivro);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/detalhes_livro.php?id=" . $idLivro . "&mensagem=solicitacao_enviada");
        exit;
    }

    header("Location: ../view/detalhes_livro.php?id=" . $idLivro . "&mensagem=erro_solicitacao");
    exit;
}

if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== "funcionario") {
    header("Location: ../view/login.php?mensagem=acesso_negado");
    exit;
}

if ($acao === "aprovar") {
    $idEmprestimo = intval($_POST["id_emprestimo"] ?? 0);

    mysqli_begin_transaction($conexao);

    $sql = "SELECT e.id_livro, l.quantidade FROM emprestimos e INNER JOIN livros l ON e.id_livro = l.id_livro WHERE e.id_emprestimo = ? AND e.status = 'pendente' LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $emprestimo = mysqli_fetch_assoc($resultado);

    if (!$emprestimo || intval($emprestimo["quantidade"]) <= 0) {
        mysqli_rollback($conexao);
        header("Location: ../view/solicitacoes_emprestimo.php?mensagem=nao_aprovado");
        exit;
    }

    $idLivro = intval($emprestimo["id_livro"]);

    $sqlAtualizaEmprestimo = "UPDATE emprestimos SET status = 'aprovado', data_emprestimo = CURDATE() WHERE id_emprestimo = ?";
    $stmt = mysqli_prepare($conexao, $sqlAtualizaEmprestimo);
    mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
    mysqli_stmt_execute($stmt);

    $sqlAtualizaLivro = "UPDATE livros SET quantidade = quantidade - 1 WHERE id_livro = ?";
    $stmt = mysqli_prepare($conexao, $sqlAtualizaLivro);
    mysqli_stmt_bind_param($stmt, "i", $idLivro);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conexao);
    header("Location: ../view/solicitacoes_emprestimo.php?mensagem=emprestimo_aprovado");
    exit;
}

if ($acao === "recusar") {
    $idEmprestimo = intval($_POST["id_emprestimo"] ?? 0);

    $sql = "UPDATE emprestimos SET status = 'recusado' WHERE id_emprestimo = ? AND status = 'pendente'";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
    mysqli_stmt_execute($stmt);

    header("Location: ../view/solicitacoes_emprestimo.php?mensagem=emprestimo_recusado");
    exit;
}

if ($acao === "devolver") {
    $idEmprestimo = intval($_POST["id_emprestimo"] ?? 0);

    mysqli_begin_transaction($conexao);

    $sql = "SELECT id_livro FROM emprestimos WHERE id_emprestimo = ? AND status = 'aprovado' LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $emprestimo = mysqli_fetch_assoc($resultado);

    if (!$emprestimo) {
        mysqli_rollback($conexao);
        header("Location: ../view/devolucoes.php?mensagem=erro_devolucao");
        exit;
    }

    $idLivro = intval($emprestimo["id_livro"]);

    $sqlEmprestimo = "UPDATE emprestimos SET status = 'devolvido', data_devolucao = CURDATE() WHERE id_emprestimo = ?";
    $stmt = mysqli_prepare($conexao, $sqlEmprestimo);
    mysqli_stmt_bind_param($stmt, "i", $idEmprestimo);
    mysqli_stmt_execute($stmt);

    $sqlLivro = "UPDATE livros SET quantidade = quantidade + 1 WHERE id_livro = ?";
    $stmt = mysqli_prepare($conexao, $sqlLivro);
    mysqli_stmt_bind_param($stmt, "i", $idLivro);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conexao);
    header("Location: ../view/devolucoes.php?mensagem=livro_devolvido");
    exit;
}

header("Location: ../view/dashboard.php");
exit;
?>
