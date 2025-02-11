<?php
// Configurações do banco de dados
$host = 'cc220df3eb53.sn.mynetname.net'; // Seu host
$dbname = 'gto_caveira'; // Nome do banco
$usuario = 'gto_caveira'; // Usuário do banco
$senha = 'gto416966'; // Senha

// Tentativa de conexão com o banco de dados
try {
    // Corrigindo as variáveis $usuario e $senha
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $senha);
    // Definir a codificação para UTF-8
    $pdo->exec("set names utf8");
} catch (PDOException $e) {
    // Se falhar, exibe a mensagem de erro
    die("Erro ao conectar: " . $e->getMessage());
}
?>
