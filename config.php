<?php

// Diretório base do projeto
define('BASE_DIR', __DIR__);

// Credenciais do banco de dados
define('DB_HOST', 'cc220df3eb53.sn.mynetname.net');   // Endereço do servidor MySQL
define('DB_NAME', 'gto_caveira');                      // Nome do banco de dados
define('DB_USER', 'gto_caveira');                      // Usuário para a conexão
define('DB_PASSWORD', 'gto416966');                    // Senha do usuário

// Caminho para o diretório de uploads (pode ser usado para uploads de arquivos)
define('UPLOAD_DIR', BASE_DIR . '/uploads');

// Configurações de ambiente
define('ENVIRONMENT', 'development'); // ou 'production' dependendo do ambiente

// Função para criar a conexão com o banco de dados
function getDbConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Log do erro em ambiente de produção
        if (ENVIRONMENT === 'production') {
            error_log($e->getMessage());
        }
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }
}

// Função para obter a URL do site, útil para links e redirecionamentos
function getBaseUrl() {
    return 'http://' . $_SERVER['HTTP_HOST'] . '/';
}

?>
