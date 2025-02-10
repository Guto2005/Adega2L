<?php
// Configurações do banco de dados
$host = 'cc220df3eb53.sn.mynetname.net'; // Se estiver hospedando localmente, mantenha "localhost"
$dbname = 'gto_caveira'; // Nome do seu banco de dados
$usuario = 'gto_caveira'; // Usuário do banco (normalmente "root" no XAMPP)
$senha = 'gto416966'; // Senha do banco (deixe vazia '' no XAMPP, se não configurou)

// Tentativa de conexão
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    // Definir o modo de erro para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
