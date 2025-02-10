<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Testar Formulário</title>
</head>
<body>
    <form action="enviar_email.php" method="POST">
        <label for="email">Seu e-mail:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Enviar</button>
    </form>

    <!-- Testando se o método POST funciona -->
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo 'Formulário enviado com sucesso!<br>';
        }
    ?>
</body>
</html>
