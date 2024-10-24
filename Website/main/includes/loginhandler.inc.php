<?php
session_start([
    'cookie_lifetime' => 0, // Sessão será encerrada ao fechar o navegador
    'cookie_httponly' => true, // Protege o cookie contra acesso via JavaScript (previne XSS)
    'use_strict_mode' => true, // Previne uso de IDs de sessão inválidos
    'use_only_cookies' => true, // Evita o uso de ID de sessão via URL
    'cookie_secure' => true, // Requer HTTPS para enviar cookies
    'cookie_samesite' => 'Strict' // Previne envio de cookies para outras origens
]);

// Regenerar o ID de sessão a cada nova requisição após o login (prevenção de Fixação de Sessão)
session_regenerate_id(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $senha = $_POST["senha"];

    if (!$email || empty($senha)) {
        exit("Favor preencher todos os campos corretamente.");
    }

    try {
        require_once "dbh.inc.php";

        $query = "SELECT id, email, senha, situacao FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($usuarios as $row){
            $hashedSenha = $row["senha"];
            $situacao = $row["situacao"];
            
            if (!$usuarios) {
                exit("Email ou senha incorretos");
            }
            
            if (password_verify($senha, $hashedSenha) && $situacao == 1) {
                
                session_regenerate_id(true);
                
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['login_time'] = time();
                header("Location: ../../Home/index.php");
            } else {
                exit("Cadastro incorreto ou inativo");
            }
            
        }
    } catch (PDOException $e) {
        error_log("Erro no Login: " . $e->getMessage());
        exit("Ocorreu um erro no sistema. Tente novamente mais tarde.");
    }
} else {
    exit("Método inválido");
}
?>
