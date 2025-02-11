<?php
// Exibir erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluindo as bibliotecas do PHPMailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

// Usar as classes do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexão com o banco de dados
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar se o e-mail está cadastrado no banco
    $query = "SELECT idUsuario, nomeUsuario FROM ADG2L_Usuarios WHERE emailUsuario = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        // Gerar um token único
        $user = $stmt->fetch();
        $token = bin2hex(random_bytes(50));

        // Salvar o token no banco de dados
        $updateQuery = "UPDATE ADG2L_Usuarios SET token_recuperacao = ? WHERE emailUsuario = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$token, $email]);

        // Gerar link real para recuperação
        $linkRecuperacao = "http://localhost/Adega2L/recuperacao/recuperar_senha_form.php?token=" . $token;

        // Enviar o e-mail com PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'isabella.asltavares@gmail.com'; // Seu e-mail
            $mail->Password = 'amgf taqx qcha kyzl'; // Senha de app do Gmail
            $mail->SMTPSecure = 'tls'; // ou 'ssl'
            $mail->Port = 587; // ou 465 se usar 'ssl'

            // Definir a codificação como UTF-8
            $mail->CharSet = 'UTF-8'; 
            $mail->isHTML(true); // Configuração para e-mails em HTML
            $mail->setFrom('noreply@seusite.com', 'Recuperação de Senha');
            $mail->addAddress($email);

            $mail->Subject = "Recuperação de Senha";
            $mail->Body = "Olá " . htmlspecialchars($user['nomeUsuario']) . ",<br><br>"
                        . "Clique no link abaixo para redefinir sua senha:<br>"
                        . "<a href='" . $linkRecuperacao . "'>" . $linkRecuperacao . "</a><br><br>"
                        . "Se você não solicitou isso, ignore este e-mail.";

            // Enviar o e-mail
            $mail->send();
            echo "E-mail enviado com sucesso!";
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: " . $mail->ErrorInfo;
        }
    } else {
        echo "E-mail não cadastrado.";
    }
}
?>
