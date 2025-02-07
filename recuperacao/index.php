<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Contato</title>
</head>
<body>
    <form action="enviar_email.php" method="POST">
        <label for="email">Seu e-mail:</label>
        <input type="email" name="email" required><br>

        <label for="mensagem">Mensagem:</label>
        <textarea name="mensagem" required></textarea><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
