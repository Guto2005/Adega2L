<?php

// Incluindo as bibliotecas do PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Usar as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Conexão com o banco de dados
include("conexao.php");

if (isset($_POST['token'], $_POST['senha'])) {
    $token = $_POST['token'];
    $senha = $_POST['senha'];

    // Verificar se o token existe no banco de dados
    $query = "SELECT id FROM usuarios WHERE token_recuperacao = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);
    
    if ($stmt->rowCount() > 0) {
        // Atualizar a senha (usando hash para segurança)
        $hashedPassword = password_hash($senha, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE usuarios SET senha = ?, token_recuperacao = NULL WHERE token_recuperacao = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$hashedPassword, $token]);
        
        echo "Sua senha foi redefinida com sucesso!";
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    echo "Informações insuficientes.";
}
?>
