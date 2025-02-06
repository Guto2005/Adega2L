<?php
$erro = '';
$sucesso = '';

// Informações de conexão com o banco de dados
$host = 'cc220df3eb53.sn.mynetname.net';
$dbname = 'gto_caveira';
$user = 'gto_caveira';
$password = 'gto416966';

// Criar conexão com o banco de dados
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificar se a conexão foi estabelecida
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar e-mail do formulário
    $email = $_POST['emailUsuario'];

    // Verificar se o campo e-mail foi preenchido
    if (empty($email)) {
        $erro = "Por favor, insira seu e-mail.";
    } else {
        // Verificar se o e-mail existe no banco de dados
        $verifica = "SELECT * FROM ADG2L_Usuarios WHERE emailUsuario = '$email'";
        $resultado = mysqli_query($conn, $verifica);
        
        if (mysqli_num_rows($resultado) > 0) {
            // Gerar um token único para a redefinição de senha
            $token = bin2hex(random_bytes(16)); // Gera um token de 32 caracteres
            $expiracao = time() + 3600; // Token expira em 1 hora

            // Apenas mostramos que o token foi gerado (sem armazenar no banco)

            // Mensagem para o usuário
            $sucesso = "Instruções de recuperação de senha foram enviadas para o seu e-mail.";

            // Enviar e-mail
            $assunto = "Recuperação de Senha";
            $mensagem = "Seu token de recuperação é: $token\n";
            $cabecalhos = "From: no-reply@seusite.com";

            if (mail($email, $assunto, $mensagem, $cabecalhos)) {
                // Apenas simula o envio sem link
                $sucesso = "O token foi enviado para o seu e-mail.";
            } else {
                $erro = "Erro ao enviar o e-mail de recuperação.";
            }
        } else {
            $erro = "E-mail não encontrado no banco de dados.";
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Recuperação de Senha</h1>

    <!-- Exibe mensagens de erro ou sucesso -->
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php elseif ($sucesso): ?>
        <div class="alert alert-success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="emailUsuario" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" required>
        </div>

        <button type="submit" class="btn btn-primary">Recuperar Senha</button>
    </form>
</div>

</body>
</html>
