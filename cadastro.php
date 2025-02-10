<?php
$erro = "";  // Variável para armazenar erros
$sucesso = "";  // Variável para armazenar mensagem de sucesso

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
    $senha = $_POST['senhaUsuario'];
    $confirmarSenha = $_POST['confirmarSenha'];
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

    // Validação do tamanho mínimo da senha
    if (strlen($senha) < 8) {
        $erro = "A senha deve ter no mínimo 8 caracteres.";
    } elseif ($senha !== $confirmarSenha) {
        $erro = "As senhas não coincidem.";
    }

    if (empty($erro)) {
        // Hash da senha para segurança
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verificar se o e-mail ou CPF já existem no banco de dados
        $verifica = "SELECT * FROM ADG2L_Usuarios WHERE emailUsuario = '$email' OR cpfUsuario = '$cpf'";
        $resultado = mysqli_query($conn, $verifica);

        if (mysqli_num_rows($resultado) > 0) {
            $erro = "Erro: O e-mail ou CPF já estão cadastrados.";
        } else {
            // Inserir dados no banco de dados
            $sql = "INSERT INTO ADG2L_Usuarios 
                (nomeUsuario, emailUsuario, senhaUsuario, cpfUsuario, tipoLogradouro, nomeLogradouro, numeroLogradouro, complementoLogradouro, bairro, cidade, cep, DDI, DDD, numeroTelefone, dataNasc) 
                VALUES 
                ('$nome', '$email', '$senhaHash', '$cpf', '$tipoLogradouro', '$nomeLogradouro', '$numeroLogradouro', '$complementoLogradouro', '$bairro', '$cidade', '$cep', '$ddi', '$ddd', '$numeroTelefone', '$dataNasc')";

            if (mysqli_query($conn, $sql)) {
                // Mensagem de sucesso
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar usuário: " . mysqli_error($conn);
            }
        }
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
    <form class="form-cadastro" method="POST">
        <h1 class="cadastro-title">Cadastro</h1>

        <input type="text" name="nomeUsuario" value="<?php echo isset($_POST['nomeUsuario']) ? $_POST['nomeUsuario'] : ''; ?>" placeholder="Nome Completo" required>
        <input type="email" name="emailUsuario" value="<?php echo isset($_POST['emailUsuario']) ? $_POST['emailUsuario'] : ''; ?>" placeholder="E-mail" required>
        <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="Senha (mínimo 8 caracteres)" required>
        <input type="password" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme sua Senha" required>
        
        <input type="text" name="cpfUsuario" value="<?php echo isset($_POST['cpfUsuario']) ? $_POST['cpfUsuario'] : ''; ?>" placeholder="CPF" maxlength="11" required>
        <input type="text" name="tipoLogradouro" value="<?php echo isset($_POST['tipoLogradouro']) ? $_POST['tipoLogradouro'] : ''; ?>" placeholder="Tipo de Logradouro (Ex: Rua, Av)">
        <input type="text" name="nomeLogradouro" value="<?php echo isset($_POST['nomeLogradouro']) ? $_POST['nomeLogradouro'] : ''; ?>" placeholder="Nome do Logradouro">
        <input type="text" name="numeroLogradouro" value="<?php echo isset($_POST['numeroLogradouro']) ? $_POST['numeroLogradouro'] : ''; ?>" placeholder="Número" maxlength="6">
        <input type="text" name="complementoLogradouro" value="<?php echo isset($_POST['complementoLogradouro']) ? $_POST['complementoLogradouro'] : ''; ?>" placeholder="Complemento">
        <input type="text" name="bairro" value="<?php echo isset($_POST['bairro']) ? $_POST['bairro'] : ''; ?>" placeholder="Bairro">
        <input type="text" name="cidade" value="<?php echo isset($_POST['cidade']) ? $_POST['cidade'] : ''; ?>" placeholder="Cidade">
        
        <input type="text" name="cep" value="<?php echo isset($_POST['cep']) ? $_POST['cep'] : ''; ?>" placeholder="CEP" maxlength="8" required>
        
        <input type="text" id="ddi" name="DDI" value="<?php echo isset($_POST['DDI']) ? $_POST['DDI'] : ''; ?>" placeholder="DDI (Ex: 55)" maxlength="3" required>
        <input type="text" id="ddd" name="DDD" value="<?php echo isset($_POST['DDD']) ? $_POST['DDD'] : ''; ?>" placeholder="DDD (Ex: 11)" maxlength="3" required>
        <input type="text" id="telefone" name="numeroTelefone" value="<?php echo isset($_POST['numeroTelefone']) ? $_POST['numeroTelefone'] : ''; ?>" placeholder="Número de Telefone" maxlength="9" required>

        <input type="date" name="dataNasc" value="<?php echo isset($_POST['dataNasc']) ? $_POST['dataNasc'] : ''; ?>" placeholder="Data de Nascimento" required>

        <!-- Exibição da mensagem de erro -->
        <?php if ($erro): ?>
            <div class="erro-mensagem">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <!-- Exibição da mensagem de sucesso -->
        <?php if ($sucesso): ?>
            <div class="sucesso-mensagem">
                <?php echo $sucesso; ?>
            </div>
        <?php endif; ?>

        <button class="cadastro-button" type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
