<?php require __DIR__ .'/config.php'?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css"/>
    <title>Adega2L</title>
</head>
<body>
<header>
    <a class="logotipo" href="/index.php"><img src="./assets/img/Image.png" alt="logo"></a> 
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
                    <input type="celular" id="celular" name="celular" required>
                </div>
                <div class="campo-perfil">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <div class="campo-perfil">
                    <label for="cpf">CPF:</label>
                    <input type="cpf" id="cpf" name="cpf" required>
                </div>
                <div class="campo-perfil">
                    <label for="cep">CEP:</label>
                    <input type="cep" id="cep" name="cep" required>
                </div>
                <div class="campo-perfil">
                    <label for="endereco">Endereço:</label>
                    <input type="endereco" id="endereco" name="endereco" required>
                </div>
                <div class="campo-perfil">
                    <label for="numero">Numero:</label>
                    <input type="numero" id="numero" name="numero" required>
                </div>
                <div class="campo-perfil">
                    <label for="logradouro">Logradouro:</label>
                    <input type="logradouro" id="logradouro" name="logradouro" required>
                </div>
                <div class="campo-perfil">
                    <label for="tipo">Tipo(apartamento,casa...):</label>
                    <input type="tipo" id="tipo" name="tipo" required>
                </div>
                <div class="campo-perfil">
                    <label for="complemento">Complemento:</label>
                    <input type="complemento" id="complemento" name="complemento" required>
                </div>
                <button type="submit">Salvar</button>
                <span class="close-btn">Sair</span>
            </form>
        </div>
    </div>
<nav class="nav-products">
            <ul class="nav-list">
                <li><a href="src/pages/partials/bebidas.php">Bebidas</a></li>
                <li><a href="src/pages/partials/destilados.php">Destilados</a></li>
                <li><a href="src/pages/partials/snacks.php">Snacks</a></li>
                <li><a href="src/pages/partials/cigarros.php">Cigarros</a></li>
            </ul>
        </nav>
