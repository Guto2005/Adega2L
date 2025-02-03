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
    $cpf = mysqli_real_escape_string($conn, $_POST['cpfUsuario']);
    $tipoLogradouro = mysqli_real_escape_string($conn, $_POST['tipoLogradouro']);
    $nomeLogradouro = mysqli_real_escape_string($conn, $_POST['nomeLogradouro']);
    $numeroLogradouro = mysqli_real_escape_string($conn, $_POST['numeroLogradouro']);
    $complementoLogradouro = mysqli_real_escape_string($conn, $_POST['complementoLogradouro']);
    $bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
    $cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
    $cep = mysqli_real_escape_string($conn, $_POST['cep']);
    $ddi = mysqli_real_escape_string($conn, $_POST['DDI']);
    $ddd = mysqli_real_escape_string($conn, $_POST['DDD']);
    $numeroTelefone = mysqli_real_escape_string($conn, $_POST['numeroTelefone']);
    $dataNasc = mysqli_real_escape_string($conn, $_POST['dataNasc']);

    // Inserir dados no banco de dados
    $sql = "INSERT INTO ADG2L_Usuarios 
        (nomeUsuario, emailUsuario, senhaUsuario, cpfUsuario, tipoLogradouro, nomeLogradouro, numeroLogradouro, complementoLogradouro, bairro, cidade, cep, DDI, DDD, numeroTelefone, dataNasc) 
        VALUES 
        ('$nome', '$email', '$senha', '$cpf', '$tipoLogradouro', '$nomeLogradouro', '$numeroLogradouro', '$complementoLogradouro', '$bairro', '$cidade', '$cep', '$ddi', '$ddd', '$numeroTelefone', '$dataNasc')";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/534bfbb4de.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/cadastro.css">
</head>
<body class="cadastro-container">  

<div class="cadastro-decoration">
    <form class="form-cadastro" method="POST" onsubmit="return validarSenha()">
        <h1 class="cadastro-title">Cadastro</h1>
        
        <input type="text" name="nomeUsuario" placeholder="Nome Completo" required>
        <input type="email" name="emailUsuario" placeholder="E-mail" required>
        <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Senha" required>
        <input type="password" id="confirmarSenha" placeholder="Confirme sua Senha" required>
        
        <input type="number" name="cpfUsuario" placeholder="CPF" maxlength="11" required>
        <input type="text" name="tipoLogradouro" placeholder="Tipo de Logradouro (Ex: Rua, Av)">
        <input type="text" name="nomeLogradouro" placeholder="Nome do Logradouro">
        <input type="number" name="numeroLogradouro" placeholder="Número" maxlength="6">
        <input type="text" name="complementoLogradouro" placeholder="Complemento">
        <input type="text" name="bairro" placeholder="Bairro">
        <input type="text" name="cidade" placeholder="Cidade">
        
        <input type="number" name="cep" placeholder="CEP" maxlength="8" required>
        
        <input type="number" id="ddi" name="DDI" placeholder="DDI (Ex: 55)" maxlength="3" required>
        <input type="number" id="ddd" name="DDD" placeholder="DDD (Ex: 11)" maxlength="3" required>
        <input type="number" id="telefone" name="numeroTelefone" placeholder="Número de Telefone" maxlength="9" required>

        <input type="date" name="dataNasc" placeholder="Data de Nascimento" required>
        
        <button class="cadastro-button" type="submit">Cadastrar</button>
    </form>
</div>

<script>
    function validarSenha() {
        var senha = document.getElementById("senhaUsuario").value;
        var confirmarSenha = document.getElementById("confirmarSenha").value;
        
        if (senha !== confirmarSenha) {
            alert("As senhas não coincidem. Por favor, tente novamente.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
