<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id_usuario"]) || $_SESSION["tipo_usuario"] !== "funcionario") {
    header("Location: ../view/login.php?mensagem=acesso_negado");
    exit;
}
?>
