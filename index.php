<?php require __DIR__ . '/config.php' ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <title>Adega2L</title>
</head>

<body>
    <header class="institucional">
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
                    <form class="perfil-campos" method="POST" action="processar_perfil.php">
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
            <form action="search.php" method="GET">
                <input class="search-placeholder" type="text" name="query" placeholder="Olá, O que você procura?" required>
                <button class="botao-enviar" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
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

    <nav class="nav-catalogo">
        <a href="catalogo.php" class="btn-catalogo">Ir para o catálogo</a>
    </nav>

    <main class="container">
        <div class="marquee-container">
            <div class="marquee">Bem-vindo à Adega2L!</div>
        </div>
        <div class="institucional-quem-somos-proposta">
            <div class="quem-somos">
                <h2>Quem Somos?</h2>
                <p>A Adega2L foi fundada em 2020 com o objetivo de revolucionar o mercado de bebidas. Desde o início, temos nos dedicado a oferecer uma experiência única e acessível para nossos clientes. Nossa equipe é apaixonada por descobrir e compartilhar as melhores opções de vinhos, destilados e cervejas artesanais, sempre buscando a qualidade e a excelência.</p>
                <p>Com um portfólio diversificado, buscamos atender tanto os consumidores exigentes quanto aqueles que desejam explorar novos sabores. Acreditamos que cada bebida tem sua história e estamos aqui para ajudar nossos clientes a encontrarem as melhores opções para cada ocasião.</p>
            </div>

            <div class="proposta-site">
                <h2>Qual a proposta desse site?</h2>
                <p>Nosso site foi feito para facilitar a vida dos nossos clientes, dando a opção de comprar nossos produtos do conforto da sua casa e recebe-los em sua porta.</p>
            </div>
        </div>
        <div class="nossa-historia-container">
            <div class="nossa-historia">
                <h2>Nossa História</h2>
                <p>Fundada em 2010, a Adega2L se estabeleceu como um dos principais nomes no mercado de bebidas e produtos relacionados. Com um compromisso inabalável com a qualidade, nossa empresa se dedica a oferecer uma seleção cuidadosamente curada de bebidas, incluindo vinhos, destilados, cervejas artesanais e uma variedade de snacks que complementam a experiência de nossos clientes.</p>
            </div>
            <div class="nossa-historia-img">
                <img src="assets/img/imagem.png" alt="">
            </div>
        </div>
        <div class="nossa-missao">
            <h2>Nossa Missão</h2>
            <p>Desde o início, nossa missão tem sido proporcionar aos nossos consumidores uma experiência excepcional, unindo produtos de alta qualidade com um atendimento ao cliente incomparável. A Adega2L acredita que cada bebida conta uma história, e nos esforçamos para trazer as melhores opções do mercado, atendendo desde os apreciadores mais exigentes até aqueles que estão apenas começando a explorar o mundo das bebidas.</p>
        </div>
    </main>

    <footer>
        <div class="footer-institucional">
            <div class="footer-left">
                <a class="logotipo-footer" href="catalogo.php"><img src="./assets/img/Image.png" alt="logo"></a>
            </div>
            <div class="footer-center">
                <h4>Redes Sociais</h4>
                <div class="redes-sociais">
                    <a href="#"><i id="facebook-icon" class="fab fa-facebook"></i></a>
                    <a href="#"><i id="instagram-icon" class="fab fa-instagram"></i></a>
                    <a href="#"><i id="twitter-icon" class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-right">
                <div class="contato">
                    <h4>Contato</h4>
                    <p>(13) 98765-4321</p>
                </div>
                <div class="endereco">
                    <h4>Endereço</h4>
                    <p>R. José Rodrigues Martins, 507 - Samarita</p>
                    <a href="https://www.google.com.br/maps/place/R.+Jos%C3%A9+Rodrigues+Martins,+507+-+Samarita,+S%C3%A3o+Vicente+-+SP,+11346-310/@-23.9888837,-46.4863148,17z/data=!4m6!3m5!1s0x94ce18d2670d46ff:0x88dcdb11dbfebf40!8m2!3d-23.9888391!4d-46.4862852!16s%2Fg%2F11c5q02zp6?entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"><i id="map-icon" class="fas fa-map"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
<script src="https://kit.fontawesome.com/149b000a36.js" crossorigin="anonymous"></script>

</html>