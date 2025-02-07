<?php

// Incluindo as bibliotecas do PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Usar as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Conexão com o banco de dados
include("conexao.php"); // ou inclua sua conexão conforme necessário

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar se o e-mail está cadastrado no banco
    $query = "SELECT id, nome FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        // Gerar um token único
        $user = $stmt->fetch();
        $token = bin2hex(random_bytes(50)); // Gera um token único de 100 caracteres
        
        // Salvar o token no banco de dados (você pode ter uma tabela específica para tokens)
        $updateQuery = "UPDATE usuarios SET token_recuperacao = ? WHERE email = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$token, $email]);
        
        // Enviar o e-mail com o link de recuperação
        $linkRecuperacao = "http://seusite.com/recuperar_senha_form.php?token=" . $token;
        
        // Configurar o e-mail
        $to = $email;
        $subject = "Recuperação de Senha";
        $message = "Olá " . $user['nome'] . ",\n\nClique no link abaixo para redefinir sua senha:\n" . $linkRecuperacao;
        $headers = "From: noreply@seusite.com";
        
        if (mail($to, $subject, $message, $headers)) {
            echo "Um e-mail foi enviado com instruções para recuperação da senha.";
        } else {
            echo "Houve um erro ao enviar o e-mail. Tente novamente.";
        }
    } else {
        echo "E-mail não cadastrado.";
    }
}
?>
