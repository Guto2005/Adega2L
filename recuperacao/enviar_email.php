<?php
// Incluindo as bibliotecas do PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Usar as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Criar uma instância do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Capturar dados do formulário
        $email_destino = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email_destino) {
            throw new Exception('E-mail inválido.');
        }

        // Gerar um token único para redefinição de senha
        $token = bin2hex(random_bytes(16)); // Gera um token seguro
        $link_redefinicao = "http://seusite.com/redefinir_senha.php?token=$token";

        // Salvar o token no banco de dados (exemplo)
        // Aqui você deve conectar ao banco de dados e salvar o token associado ao e-mail
        // $conn = new mysqli('localhost', 'usuario', 'senha', 'banco');
        // $stmt = $conn->prepare("INSERT INTO tokens (email, token) VALUES (?, ?)");
        // $stmt->bind_param("ss", $email_destino, $token);
        // $stmt->execute();

        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'edward166@gmail.com';  // Seu e-mail
        $mail->Password = 'azej isex lxtd guat'; // Use a senha gerada no Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        // Definir informações do e-mail
        $mail->setFrom('edward166@gmail.com', 'Seu Nome');
        $mail->addAddress($email_destino, 'Usuário');
        $mail->Subject = 'Recuperação de Senha';
        $mail->Body    = "Olá, \n\nClique no link abaixo para redefinir sua senha:\n\nhttp://seusite.com/redefinir_senha.php?email=$email_destino";

        // Enviar o e-mail
        $mail->send();
        echo 'E-mail enviado com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$e->getMessage()}";
    }
} else {
    echo 'Formulário de envio não enviado.';
}
?>