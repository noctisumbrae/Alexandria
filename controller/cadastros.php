<?php
session_start();
require_once "conexao.php";

$acao = $_POST["acao"] ?? "";

function emailExiste($conexao, $email) {
    $sqlLeitor = "SELECT id_leitor FROM leitores WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlLeitor);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        return true;
    }

    $sqlFuncionario = "SELECT id_funcionario FROM funcionarios WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sqlFuncionario);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    return mysqli_stmt_num_rows($stmt) > 0;
}

if ($acao === "cadastrar_leitor") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = trim($_POST["senha"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $cpf = trim($_POST["cpf"] ?? "");

    if ($nome === "" || $email === "" || $senha === "") {
        header("Location: ../view/cadastro_leitor.php?mensagem=campos_obrigatorios");
        exit;
    }

    if (emailExiste($conexao, $email)) {
        header("Location: ../view/cadastro_leitor.php?mensagem=email_cadastrado");
        exit;
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO leitores (nome, email, senha, telefone, cpf) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $email, $senhaCriptografada, $telefone, $cpf);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/login.php?mensagem=leitor_cadastrado");
        exit;
    }

    header("Location: ../view/cadastro_leitor.php?mensagem=erro_cadastro");
    exit;
}

if ($acao === "cadastrar_funcionario") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = trim($_POST["senha"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $cargo = trim($_POST["cargo"] ?? "");

    if ($nome === "" || $email === "" || $senha === "") {
        header("Location: ../view/cadastro_funcionario.php?mensagem=campos_obrigatorios");
        exit;
    }

    if (emailExiste($conexao, $email)) {
        header("Location: ../view/cadastro_funcionario.php?mensagem=email_cadastrado");
        exit;
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO funcionarios (nome, email, senha, telefone, cargo) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nome, $email, $senhaCriptografada, $telefone, $cargo);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/login.php?mensagem=funcionario_cadastrado");
        exit;
    }

    header("Location: ../view/cadastro_funcionario.php?mensagem=erro_cadastro");
    exit;
}

if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== "funcionario") {
    header("Location: ../view/login.php?mensagem=acesso_negado");
    exit;
}

if ($acao === "cadastrar_autor") {
    $nome = trim($_POST["nome"] ?? "");
    $nacionalidade = trim($_POST["nacionalidade"] ?? "");
    $biografia = trim($_POST["biografia"] ?? "");

    if ($nome === "") {
        header("Location: ../view/cadastro_autor.php?mensagem=campos_obrigatorios");
        exit;
    }

    $sql = "INSERT INTO autores (nome, nacionalidade, biografia) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nome, $nacionalidade, $biografia);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/gerenciar_autores.php?mensagem=autor_cadastrado");
        exit;
    }

    header("Location: ../view/cadastro_autor.php?mensagem=erro_cadastro");
    exit;
}

if ($acao === "cadastrar_livro") {
    $titulo = trim($_POST["titulo"] ?? "");
    $idAutor = intval($_POST["id_autor"] ?? 0);
    $editora = trim($_POST["editora"] ?? "");
    $categoria = trim($_POST["categoria"] ?? "");
    $ano = intval($_POST["ano_publicacao"] ?? 0);
    $quantidade = intval($_POST["quantidade"] ?? 0);
    $descricao = trim($_POST["descricao"] ?? "");
    $imagem = trim($_POST["imagem"] ?? "");

    if ($titulo === "" || $idAutor <= 0 || $quantidade < 0) {
        header("Location: ../view/cadastro_livro.php?mensagem=campos_obrigatorios");
        exit;
    }

    if ($imagem === "") {
        $imagem = "assets/img/livro.svg";
    }

    $sql = "INSERT INTO livros (titulo, id_autor, editora, categoria, ano_publicacao, quantidade, descricao, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "sissiiss", $titulo, $idAutor, $editora, $categoria, $ano, $quantidade, $descricao, $imagem);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../view/gerenciar_livros.php?mensagem=livro_cadastrado");
        exit;
    }

    header("Location: ../view/cadastro_livro.php?mensagem=erro_cadastro");
    exit;
}

header("Location: ../view/dashboard.php");
exit;
?>
