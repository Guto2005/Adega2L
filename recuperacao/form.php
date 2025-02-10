<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Testar Formulário</title>
    <link rel="stylesheet" href="./../assets/css/form.css">
</head>
<body>
    <div class="formulario-container">
        <div class="formulario-decoration">
            <form class="formulario-form" action="enviar_email.php" method="POST">
                <h1 class="formulario-title">Recuperação de Senha</h1>
                <label for="email">Seu e-mail:</label>
                <input type="email" name="email" required placeholder="Digite seu e-mail"><br>
                <button type="submit" class="formulario-button">Enviar</button>
                <p>OU</p>
                <div class="links">
            <a class="links" href="cadastro.php">CRIAR NOVA CONTA</a>
        </div>

            </form>
        </div>
    </div>

    <!-- Testando se o método POST funciona -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo '<div class="sucesso-mensagem">Formulário enviado com sucesso!</div>';
        }
    ?>
</body>
</html>
