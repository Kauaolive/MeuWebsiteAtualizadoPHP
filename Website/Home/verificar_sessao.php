<?php
session_start([
    'cookie_lifetime' => 0, // Sessão será encerrada ao fechar o navegador
    'cookie_httponly' => true, // Protege o cookie contra acesso via JavaScript (previne XSS)
    'use_strict_mode' => true, // Previne uso de IDs de sessão inválidos
    'use_only_cookies' => true, // Evita o uso de ID de sessão via URL
    'cookie_secure' => true, // Requer HTTPS para enviar cookies
    'cookie_samesite' => 'Strict' // Previne envio de cookies para outras origens
]);

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['login_time']) || ($_SESSION['usuario_id'] == "" || $_SESSION['login_time'] == "")) {
    session_unset();
    session_destroy();
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
