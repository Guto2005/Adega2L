<?php
// Conexão com o banco de dados
$host = 'cc220df3eb53.sn.mynetname.net';
$dbname = 'gto_caveira';
$user = 'gto_caveira';
$password = 'gto416966';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Consulta os produtos agrupados por categoria
$sql = "SELECT 
            p.idProduto, 
            p.nomeProduto, 
            p.precoProduto, 
            p.quantidadeEstoqueProduto, 
            p.tipoUnidade, 
            p.descricaoBebidas, 
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
        <div class="mobile">
            <a class="link-carrinho-mobile" href="./cart.php">
                <span class="carrinho-quantidade" id="cart-count">0</span>
                <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
                <h3 class="carrinho-titulo">Minhas Compras</h3>
            </a>
            <div class="menu-mobile">
                <button class="icone-mobile" aria-label="Menu" id="menu-toggle">
                    <i id="menu-icon" class="fas fa-bars"></i>
                </button>
                <div class="icones-menu" id="perfil-content" style="display: none;">
                    <form>
                        <div class="home">
                            <a class="home-ancora" href="catalogo.php"><i id="home-icon" class="fas fa-home"></i></a>
                            <h3 class="home-titulo-mobile">Home</h3>
                        </div>
                        <button id="perfil-btn" class="perfil-btn-mobile">
                            <h3 class="perfil-titulo-mobile">Perfil</h3>
                            <i id="user-icon" class="fa-solid fa-user"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="search-nav-mobile">
                <div class="search-bar-mobile">
                    <input class="search-placeholder" type="text" placeholder="Olá, O que você procura?" />
                    <button class="botao-enviar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <nav class="nav-products-mobile">
                    <ul class="nav-list-mobile">
                        <li><a href="bebidas.php">Bebidas</a></li>
                        <li><a href="destilados.php">Destilados</a></li>
                        <li><a href="snacks.php">Snacks</a></li>
                        <li><a href="cigarros.php">Cigarros</a></li>
                    </ul>
                </nav>
            </div>


        </div>

        <a class="logotipo" href="catalogo.php"><img src="./assets/img/Image.png" alt="logo"></a>

        <div class="search-bar">
            <input class="search-placeholder" type="text" placeholder="Olá, O que você procura?" />
            <button class="botao-enviar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <div class="perfil-link">
            <a href="perfil.php" class="perfil-btn">
                <h3 class="perfil-titulo">Perfil</h3>
                <i id="user-icon" class="fa-solid fa-user"></i>
            </a>
        </div>

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