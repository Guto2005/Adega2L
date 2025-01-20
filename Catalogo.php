<?php require __DIR__ . '/header.php' ?>
<link rel="stylesheet" href="./assets/css/catalogo.css" />
<main class="container">
<div class="carrossel-container">
    <div class="carrossel" id="carrossel">
        <div class="banner" id="banner1">
            <div class="carrossel-navigation-left">
                <button class="prev-btn">&lt;</button>
            </div>
            <img src="assets/img/Banner black friday ofertas preto amarelo.png" alt="banner1">
            <div class="carrossel-navigation-right">
                <button class="next-btn">&gt;</button>
            </div>
        </div>
        
        <div class="banner" id="banner2">
            <div class="carrossel-navigation-left">
                <button class="prev-btn">&lt;</button>
            </div>
            <img src="assets/img/Ofertas dia do consumidor neon amarelo e preto banner para mercado shops.png" alt="banner2">
            <div class="carrossel-navigation-right">
                <button class="next-btn">&gt;</button>
            </div>
        </div>
        
        <div class="banner" id="banner3">
            <div class="carrossel-navigation-left">
                <button class="prev-btn">&lt;</button>
            </div>
            <img src="assets/img/Banner black friday ofertas preto amarelo.png" alt="banner3">
            <div class="carrossel-navigation-right">
                <button class="next-btn">&gt;</button>
            </div>
        </div>
        <!-- Adicione mais banners conforme necessário -->
    </div>
    <div class="carrossel-controls">
        <button class="control-btn" data-index="0"></button>
        <button class="control-btn" data-index="1"></button>
        <button class="control-btn" data-index="2"></button>
        <!-- Adicione mais botões conforme necessário -->
    </div>
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