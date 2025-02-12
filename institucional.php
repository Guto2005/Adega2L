<?php require __DIR__ . '/config.php' ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/institucional.css" />
    <title>Adega2L</title>
</head>

<body>
    <div class="imagem-institu">
        <img src="./assets/img/Image.png" alt="">
    </div>

    <div class="marquee-container">
        <div class="marquee">Bem-vindo à Adega2L!</div>
    </div>

    <main class="container">

        <nav class="nav-catalogo">
            <a href="index.php" class="btn-catalogo">Ir para o catálogo</a>
        </nav>

        <div class="slideshow-container">
            <div class="mySlides fade">
                <div class="numbertext">1 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Corona.jpg" alt="Corona"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Ousadia.jpg" alt="Ousadia"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Stella.jpg" alt="Stella"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">4 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Catuaba.jpg" alt="Catuaba"></a>
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
                <h4 class="redes-sociais-titulo">Redes Sociais</h4>
                <div class="redes-sociais">
                    <a href="#"><i id="facebook-icon" class="fab fa-facebook"></i></a>
                    <a href="#"><i id="instagram-icon" class="fab fa-instagram"></i></a>
                    <a href="#"><i id="twitter-icon" class="fab fa-twitter"></i></a>
                </div>
                <div class="institucional-btn">
                    <a class="institucional-link" href="institucional.php">
                        <h4 class="institucional-titulo">Institucional</h4>
                    </a>
                </div>
            </div>
            <div class="footer-right">
                <div class="contato-endereco">
                    <h4>Contato</h4>
                    <p class="numero-telefone">(13) 98765-4321</p>
                    <h4>Endereço</h4>
                    <p class="endereco-loja">R. José Rodrigues Martins, 507 - Samarita</p>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3645.1951850189216!2d-46.4863148!3d-23.9888837!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce18d2670d46ff%3A0x88dcdb11dbfebf40!2sR.%20Jos%C3%A9%20Rodrigues%20Martins%2C%20507%20-%20Samarita%2C%20S%C3%A3o%20Vicente%20-%20SP%2C%2011346-310!5e0!3m2!1spt-BR!2sbr!4v1737567319073!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </footer>

    <!-- Modal para exibir o produto -->
    <div id="modal-produto" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999;">
        <div class="modal-container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; max-width: 500px; width: 100%;">
            <span class="close" onclick="fecharModal()" style="position: absolute; top: 10px; right: 10px; font-size: 24px; cursor: pointer;">&times;</span>

            <!-- Conteúdo do Modal -->
            <div id="modal-content">
                <img id="modal-img" src="" alt="Imagem do produto" style="max-width: 100%; max-height: 300px; display: block; margin-bottom: 20px;">
                <h4 id="modal-nome-produto" style="font-size: 24px; margin-bottom: 10px;"></h4>
                <p id="modal-desc" style="font-size: 16px; margin-bottom: 10px;"></p>
                <p id="modal-preco-produto" style="font-size: 18px; font-weight: bold;"></p>
            </div>

            <!-- Botão para Fechar o Modal -->
            <button onclick="fecharModal()" style="display: block; width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;">Fechar</button>
        </div>
    </div>


    <script src="assets/scripts/script.js"></script>
    <script src="https://kit.fontawesome.com/149b000a36.js" crossorigin="anonymous"></script>
</body>

</html>
