<?php
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Recuperar dados do formulário
    $email = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
    $senha = $_POST['senhaUsuario'];
    
    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT senhaUsuario FROM ADG2L_Usuarios WHERE emailUsuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar a senha
        if (password_verify($senha, $row['senhaUsuario'])) {
            $_SESSION['emailUsuario'] = $email;
            // Redirecionamento para uma página segura (exemplo: dashboard.php)
            header("Location: index.php");
            exit();
        } else {
            $error_message = '<div class="error-message">Os dados não conferem, tente novamente.</div>';
        }
    } else {
        $error_message = '<div class="error-message">Os dados não conferem, tente novamente.</div>';
    }

    // Fechar conexão
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/534bfbb4de.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/login.css">
</head>
<body class="login-container">  

<div class="login-decoration">
    <form class="form-login" method="POST">
    <h1 class="login-title">Adega2L</h1>
        <input type="email" name="emailUsuario" placeholder="E-mail" required> 
        <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Senha" required>
        <button class="login-button" type="submit">Entrar</button>

        <?php if (!empty($error_message)): ?>
            <?php echo $error_message; ?>
        <?php endif; ?>

        <div class="login-links">
            <a class="login-links" href="#">Esqueceu sua senha?</a>
            <a class="login-links" href="cadastro.php">Cadastre-se</a>
        </div>
    </form>
</div>

</body>
</html>
