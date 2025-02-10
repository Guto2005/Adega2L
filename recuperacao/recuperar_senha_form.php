<?php
// Ativar a exibição de erros para ajudar na depuração
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluindo a conexão com o banco de dados
include("conexao.php");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar se o token existe no banco de dados
    $query = "SELECT idUsuario FROM ADG2L_Usuarios WHERE token_recuperacao = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);

    // Exibir o número de resultados retornados pela consulta
    echo "<pre>";
    var_dump($stmt->rowCount()); // Verifica quantos registros foram encontrados
    var_dump($token); // Verifica se o token foi recebido corretamente
    echo "</pre>";
    
    if ($stmt->rowCount() > 0) {
        // Token válido, exibir o formulário de redefinição de senha
        echo '<form action="resetar_senha.php" method="POST">
                <label for="senha">Nova senha:</label>
                <input type="password" id="senha" name="senha" required>
                <input type="hidden" name="token" value="' . $token . '">
                <button type="submit">Redefinir Senha</button>
              </form>';
    } else {
        echo "Token inválido ou expirado.";
    }
} else {
    echo "Token não fornecido.";
}
?>
