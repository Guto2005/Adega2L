<?php
// Configurações do banco de dados
$host = 'cc220df3eb53.sn.mynetname.net'; // Seu host
$dbname = 'gto_caveira'; // Nome do banco
$usuario = 'gto_caveira'; // Usuário do banco
$senha = 'gto416966'; // 

// Tentativa de conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    // Definir o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida!"; // Você pode ativar isso para testes
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
