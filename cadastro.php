<?php
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
    $nome = mysqli_real_escape_string($conn, $_POST['nomeUsuario']);
    $email = mysqli_real_escape_string($conn, $_POST['emailUsuario']);
    $senha = password_hash($_POST['senhaUsuario'], PASSWORD_DEFAULT); // Criptografar a senha
    

    // Inserir dados no banco de dados
    $sql = "INSERT INTO ADG2L_Usuarios (nomeUsuario, emailUsuario, senhaUsuario) VALUES ('$nome', '$email', '$senha')";

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
    <script src="https://kit.fontawesome.com/534bfbb4de.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./assets/css/cadastro.css">
</head>
<body class="cadastro-container">  

<div class="cadastro-decoration">
    <form class="form-cadastro" method="POST">
    <h1 class="cadastro-title">Cadastro</h1>
        <input type="text" id="nome" placeholder="Nome" name="usuario" required>
        <input type="tel" name="telefone" placeholder="Celular" required>
        <input type="text" name="cpf" placeholder="Digite um CPF"  required>
              <input type="email" id="email" name="email" placeholder="Email">
              <input id="date" type="date" required>
              <input type="password" id="senha" placeholder="Senha" name="senha" required>
        <input type="password" id="senha" placeholder="Confirmar senha" name="senha" required>
        <button class="cadastro-button" 
        type="submit">Entrar</button>        

<div class="cadastro-links">
<a class="cadastro-links" href="#">Esqueceu sua senha?</a>
<a class="cadastro-links" href="#">Cadastre-se</a>
</div>
    </form>
    
</div>


</body>
</html>
<!--É enviando para a mesma página--