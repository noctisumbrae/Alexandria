<?php
session_start();
require_once "conexao.php";

$acao = $_POST["acao"] ?? $_GET["acao"] ?? "";

function senhaValida($senhaDigitada, $senhaBanco) {
    return password_verify($senhaDigitada, $senhaBanco) || $senhaDigitada === $senhaBanco;
}

if ($acao === "login") {
    $email = trim($_POST["email"] ?? "");
    $senha = trim($_POST["senha"] ?? "");

    if ($email === "" || $senha === "") {
        header("Location: ../view/login.php?mensagem=campos_obrigatorios");
        exit;
    }

    $sqlFuncionario = "SELECT id_funcionario, nome, email, senha FROM funcionarios WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlFuncionario);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $funcionario = mysqli_fetch_assoc($resultado);

    if ($funcionario && senhaValida($senha, $funcionario["senha"])) {
        $_SESSION["id_usuario"] = $funcionario["id_funcionario"];
        $_SESSION["nome_usuario"] = $funcionario["nome"];
        $_SESSION["tipo_usuario"] = "funcionario";
        header("Location: ../view/dashboard.php");
        exit;
    }

    $sqlLeitor = "SELECT id_leitor, nome, email, senha FROM leitores WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlLeitor);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $leitor = mysqli_fetch_assoc($resultado);

    if ($leitor && senhaValida($senha, $leitor["senha"])) {
        $_SESSION["id_usuario"] = $leitor["id_leitor"];
        $_SESSION["nome_usuario"] = $leitor["nome"];
        $_SESSION["tipo_usuario"] = "leitor";
        header("Location: ../index.php?mensagem=login_ok");
        exit;
    }

    header("Location: ../view/login.php?mensagem=login_invalido");
    exit;
}

if ($acao === "logout") {
    session_destroy();
    header("Location: ../index.php?mensagem=logout");
    exit;
}

if ($acao === "recuperar") {
    $tipo = $_POST["tipo"] ?? "";
    $email = trim($_POST["email"] ?? "");
    $novaSenha = trim($_POST["nova_senha"] ?? "");

    if ($email === "" || $novaSenha === "" || ($tipo !== "leitor" && $tipo !== "funcionario")) {
        header("Location: ../view/recuperar_senha.php?mensagem=campos_obrigatorios");
        exit;
    }

    $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

    if ($tipo === "leitor") {
        $sql = "UPDATE leitores SET senha = ? WHERE email = ?";
    } else {
        $sql = "UPDATE funcionarios SET senha = ? WHERE email = ?";
    }

    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $senhaCriptografada, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ../view/login.php?mensagem=senha_alterada");
        exit;
    }

    header("Location: ../view/recuperar_senha.php?mensagem=email_nao_encontrado");
    exit;
}

header("Location: ../index.php");
exit;
?>
