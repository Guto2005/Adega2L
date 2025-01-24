<?php require __DIR__ . '/header.php' ?>
<link rel="stylesheet" href="./assets/css/index.css" />
<main class="container">
<div class="slideshow-container">
            <div class="mySlides fade">
                <div class="numbertext">1 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="./assets/img/Ofertas dia do consumidor neon amarelo e preto banner para mercado shops.png" alt="Oferta1"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Banner black friday ofertas preto amarelo.png" alt="Ousadia"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="./assets/img/Ofertas dia do consumidor neon amarelo e preto banner para mercado shops.png" alt="Stella"></a>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">4 / 4</div>
                <a href="index.php"><img class="SlideProduto" src="assets/img/Banner black friday ofertas preto amarelo.png" alt="Catuaba"></a>
            </div>
        </div>

                <!-- The dots/circles -->
                <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
        </div>


<div class="destaques">
    <h2 class="destaque-titulo">MAIS VENDIDOS DA SEMANA</h2>

    <!-- Itera sobre as categorias -->
    <?php foreach ($categorias as $categoria => $produtosCategoria): ?>
        <div class="destaques-<?= strtolower($categoria) ?>">
            <h2 class="destaque-titulo"><?= htmlspecialchars($categoria) ?></h2>
            <ul>
                <!-- Itera sobre os produtos de cada categoria, limitando a 5 -->
                <?php foreach (array_slice($produtosCategoria, 0, 5) as $produto): ?>
                    <li class="card-produto">
                        <h2><?= htmlspecialchars($produto['nomeProduto']) ?></h2>
                        <p>Preço: R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>
                        <p>Estoque: <?= htmlspecialchars($produto['quantidadeEstoqueProduto']) ?> unidades</p>
                        <img src="<?= htmlspecialchars($produto['pro_img']) ?>" alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>">
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>

</main>
<?php require __DIR__ . '/footer.php' ?>
<script src="assets/scripts/script.js"></script>
</body>
<script src="https://kit.fontawesome.com/149b000a36.js" crossorigin="anonymous"></script>

</html>