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
            <!-- Seu conteúdo mobile já está aqui -->
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
        <!-- Modal de perfil -->
    </div>

    <nav class="nav-catalogo">
        <a href="catalogo.php" class="btn-catalogo">Ir para o catálogo</a>
    </nav>

    <main class="container">
        <div class="marquee-container">
            <div class="marquee">Bem-vindo à Adega2L!</div>
        </div>

        <div class="slideshow-container">
            <div class="mySlides fade">
                <div class="numbertext">1 / 4</div>
                <a href="catalogo.php"><img class="SlideProduto" src="assets/img/Corona.jpg" alt="Corona"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 4</div>
                <a href="catalogo.php"><img class="SlideProduto" src="assets/img/Ousadia.jpg" alt="Ousadia"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 4</div>
                <a href="catalogo.php"><img class="SlideProduto" src="assets/img/Stella.jpg" alt="Stella"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">4 / 4</div>
                <a href="catalogo.php"><img class="SlideProduto" src="assets/img/Catuaba.jpg" alt="Catuaba"></a>
            </div>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>

        <div class="institucional-quem-somos-proposta">
            <div class="quem-somos">
                <h2>Quem Somos?</h2>
                <p>Somos uma loja de conveniência que vende um pouco de tudo, desde alimentos não perecíveis até bebidas de todos os tipos. Nosso catálogo possui: salgadinhos (snacks), bolachas, doces em geral, bebidas alcoólicas, refrigerantes, sucos, destilados, tabacos, carvões, cigarros e utensílios de limpeza.</p>
            </div>

            <div class="proposta-site-vendas">
                <h2>Qual a proposta desse site?</h2>
                <p>Nosso site foi feito para facilitar a vida dos nossos clientes, dando a opção de comprar nossos produtos do conforto da sua casa e recebê-los em sua porta.</p>
                <h2>O que vendemos?</h2>
                <p>Vendemos produtos diversos como bebidas, licores, salgadinhos (snacks), bolachas, doces em geral, refrigerantes, sucos, destilados, tabacos, carvão, cigarros e utensílios de limpeza.</p>
                <h2>Marcas que trabalhamos</h2>
                <p>Corona, Eisebahn, Brahma, Itaipava, Budweiser, Heineken, Sol, Original, Smirnoff, Askov, White Horse, Redlabel, Jackdaniels, Bacardi Big Apple, Skol, Petra, Ballantines, Passaport, Velvo, Dober, Tanqueray, Beefeater, Ciroc, Ballena, Licor 43, Corote e etc.</p>
            </div>
        </div>

        <div class="nossa-historia-container">
            <div class="nossa-historia">
                <h2>Nossa História</h2>
                <p>Fundada em 2020, a Adega2L se estabeleceu como um dos principais nomes no mercado de bebidas e produtos relacionados. Com um compromisso inabalável com a qualidade, nossa empresa se dedica a oferecer uma seleção cuidadosamente curada de bebidas, incluindo vinhos, destilados, cervejas artesanais e uma variedade de snacks que complementam a experiência de nossos clientes.</p>
            </div>
            <div class="nossa-historia-img">
                <img src="assets/img/imagem.png" alt="Imagem História">
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
                    <a href="https://www.google.com.br/maps/place/R.+Jos%C3%A9+Rodrigues+Martins,+507+-+Samarita,+S%C3%A3o+Vicente+-+SP,+11346-310/@-23.9888837,-46.4863148,17z/data=!4m6!3m5!1s0x94ce18d2670d46ff:0x88dcdb11dbfebf40!8m2!3d-23.9888391!4d-46.4862852!16s%2Fg%2F11c5q02zp6?entry=ttu&g_ep=EgoyMDI0MTAyOS4wIKXMDSoASAFQAw%3D%3D"><i id="google-maps-icon" class="fab fa-google"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/149b000a36.js" crossorigin="anonymous"></script>
    <script src="assets/scripts/script.js"></script>


    
</body>

</html>