<?php
// Conexão com o banco de dados
$host = 'cc220df3eb53.sn.mynetname.net';
$dbname = 'gto_caveira';
$user = 'gto_caveira';
$password = 'gto416966';

require "./config.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Manipulação do formulário de upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagemProduto'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['imagemProduto']['name']);

    // Verifica se é uma imagem válida
    $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES['imagemProduto']['tmp_name'], $uploadFile)) {
            // Salva os dados no banco de dados
            $sql = "INSERT INTO ADG2L_Produtos (nomeProduto, precoProduto, quantidadeEstoqueProduto, imagemProduto) 
                    VALUES (:nomeProduto, :precoProduto, :quantidadeEstoqueProduto, :imagemProduto)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nomeProduto' => $_POST['nomeProduto'],
                ':precoProduto' => $_POST['precoProduto'],
                ':quantidadeEstoqueProduto' => $_POST['quantidadeEstoqueProduto'],
                ':imagemProduto' => $uploadFile
            ]);
             
            echo "Produto cadastrado com sucesso!";
        } else {
            echo "Erro ao salvar o arquivo.";
        }
    } else {
        echo "Formato de arquivo não permitido.";
    }
}

// Consulta os produtos agrupados por categoria
$sql = "SELECT 
            p.idProduto, 
            p.nomeProduto, 
            p.precoProduto, 
            p.quantidadeEstoqueProduto, 
            p.tipoUnidade, 
            p.descricaoBebidas, 
            p.imagemProduto, -- Campo correto
            c.nomeCategoria AS categoria
        FROM ADG2L_Produtos p
        INNER JOIN ADG2L_Categorias c ON p.idCategoria = c.idCategoria
        ORDER BY c.nomeCategoria, p.nomeProduto";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupa os produtos por categoria
$categorias = [];
foreach ($produtos as $produto) {
    $categorias[$produto['categoria']][] = $produto;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/header.css" />
    <title>Adega2L</title>
</head>

<body>
    <header>
        <a class="logotipo" href="catalogo.php"><img src="./assets/img/Image.png" alt="logo"></a>
    <div class="junçao-mobile">
    <form id="search-form" class="search-bar" action="" method="GET">
    <input class="search-placeholder" type="text" name="q" id="search-input" placeholder="Olá, o que você procura?" oninput="handleSearch()" required />
    <button class="botao-enviar" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>


        
        <div class="perfil-link-mobile">
            <a href="perfil.php" class="perfil-btn">
            <i id="user-icon" class="fa-solid fa-user"></i>
                <h3 class="perfil-titulo">Perfil</h3>
            </a>
        </div>
        <a class="link-carrinho-mobile" href="./cart.php">
            <span class="carrinho-quantidade" id="cart-count">0</span>
            <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
            <h3 class="carrinho-titulo">Minhas Compras</h3>
        </a>
    <div class="adm-link-mobile">
        <a class="adm-btn" href="./panel/index.php">
        <i class="fa-regular fa-address-card" id="adm-icon"></i>
            <h3 class="adm-titulo">Administrativo</h3>
        </a>
    </div>    
        </div>
        <form id="search-form" class="search-bar" action="" method="GET">
    <input class="search-placeholder" type="text" name="q" id="search-input" placeholder="Olá, o que você procura?" oninput="handleSearch()" required />
    <button class="botao-enviar" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>


        
        <a class="link-carrinho" href="./cart.php">
            <span class="carrinho-quantidade" id="cart-count">0</span>
            <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
            <h3 class="carrinho-titulo">Minhas Compras</h3>
        </a>
        <div class="adm-link">
            <a class="adm-btn" href="./panel/index.php">
                <i class="fa-regular fa-address-card" id="adm-icon"></i>
                <h3 class="adm-titulo">Administrativo</h3>
            </a>
        </div>    
        <div class="perfil-link">
            <a href="perfil.php" class="perfil-btn">
            <i id="user-icon" class="fa-solid fa-id-badge"></i>
                <h3 class="perfil-titulo">Perfil</h3>
            </a>
        </div>

    </header>

    <div id="perfil-modal" class="modal">
        <div class="modal-content">
            <h2 class="modal-titulo">Perfil</h2>
            <p>AQUI VOCE PODE ALTERAR SUAS INFORMAÇÕES EM CASO DE ERRO.</p>
            <form class="perfil-campos">
                <div class="campo-perfil">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="campo-perfil">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="campo-perfil">
                    <label for="celular">Celular:</label>
                    <input type="tel" id="celular" name="celular" required>
                </div>
                <div class="campo-perfil">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="campo-perfil">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" required>
                </div>
                <div class="campo-perfil">
                    <label for="cep">CEP:</label>
                    <input type="text" id="cep" name="cep" required>
                </div>
                <div class="campo-perfil">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" required>
                </div>
                <div class="campo-perfil">
                    <label for="numero">Número:</label>
                    <input type="number" id="numero" name="numero" required>
                </div>
                <div class="campo-perfil">
                    <label for="logradouro">Logradouro:</label>
                    <input type="text" id="logradouro" name="logradouro" required>
                </div>
                <div class="campo-perfil">
                    <label for="tipo">Tipo (apartamento, casa...):</label>
                    <input type="text" id="tipo" name="tipo" required>
                </div>
                <div class="campo-perfil">
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento" required>
                </div>
                <button type="submit">Salvar</button>
                <span class="close-btn">Sair</span>
            </form>
        </div>
    </div>

    <nav class="nav-products">
        <ul class="nav-list">
            <li><a href="bebidas.php">Bebidas</a></li>
            <li><a href="destilados.php">Destilados</a></li>
            <li><a href="snacks.php">Snacks</a></li>
            <li><a href="cigarros.php">Cigarros</a></li>
        </ul>
    </nav>


