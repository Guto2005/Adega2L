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

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar se o token existe
    $query = "SELECT id FROM usuarios WHERE token_recuperacao = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);
    
    if ($stmt->rowCount() > 0) {
        // Formulário de redefinição de senha
        echo '<form action="resetar_senha.php" method="POST">
                <label for="senha">Nova senha:</label>
                <input type="password" id="senha" name="senha" required>
                <input type="hidden" name="token" value="' . $token . '">
                <button type="submit">Redefinir Senha</button>
              </form>';
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    echo "Token não fornecido.";
}
?>
