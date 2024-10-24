<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['login_time']) || ($_SESSION['usuario_id'] == "" || $_SESSION['login_time'] == "")) {

    header("Location: ../main/index.php");
    exit("Acesso negado. Favor fazer login.");
}

$tempoLimite = 36000; 
if (time() - $_SESSION['login_time'] > $tempoLimite) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit("Sessão expirada. Favor fazer login novamente.");
}

session_regenerate_id(true);
?>
