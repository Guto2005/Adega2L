<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Informações de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblioteca";

    // Criar conexão com o banco de dados
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar se a conexão foi estabelecida
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }
// Recuperar dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    

    // Inserir dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '$tipo')";

    if (mysqli_query($conn, $sql)) {
        echo "Novo registro criado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Fechar conexão com o banco de dados
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body class="login-container">  

<div class="login-decoration">
    <form class="form-login" method="POST">
    <h1 class="login-title">Adega 2L</h1>
        <input type="text" id="usuario" placeholder="Usuário" name="usuario" required>
        <input type="password" id="senha" placeholder="Senha" name="senha" required>
        <button class="login-button" type="submit">Entrar</button>
    </form>
    <p>Esqueceu sua senha?</p>
    <p>Cadastre-se</p>
</div>


</body>
</html>
<!--É enviando para a mesma página--