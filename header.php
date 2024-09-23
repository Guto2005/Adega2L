<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css"/>
    <title>Adega2L</title>
</head>
<body>
<header>
    <a class="logotipo" href="index.php"><img src="assets/img/Image.png" alt="logo"></a> 
    <div class="search-bar">
    <input class="search-placeholder" type="text" placeholder="Olá, O que você procura?" />
    <button class="botao-enviar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
</div>
<div class="perfil-link">
<form>
    <button id="perfil-btn" class="perfil-btn" >
        <h3 class="perfil-titulo">Perfil</h3>
        <i id="user-icon" class="fa-solid fa-user"></i>
    </button>
</form>
</div>  
    <a class="link-carrinho" href="./cart.php"><i class="fa-solid fa-cart-shopping" id="cart-icon"><h3 class="carrinho-titulo">Minhas Compras</h3></i></a>
</header>
<div id="perfil-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">Sair</span>
            <h2>Perfil</h2>
            <div class="option-list">
                <li><a href="#informacoes">Informações</a></li>
                <li><a href="#configuracoes">Configurações</a></li>
                <li></li>
                <li></li>
            </div>
                
                
           
            <form>
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit">Salvar</button>
            </form>
        </div>
    </div>
<nav class="nav-products">
            <ul class="nav-list">
                <li><a href="bebidas.php">Bebidas</a></li>
                <li><a href="alcoolicas.php">BebidasAlcoólicas</a></li>
                <li><a href="snacks.php">Snacks</a></li>
                <li><a href="cigarros.php">Cigarros</a></li>
            </ul>
        </nav>
