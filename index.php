<?php require __DIR__ . '/header.php' ?>
<link rel="stylesheet" href="./assets/css/index.css" />

<main class="container">
    <!-- Slideshow de Banners -->
    <div class="slideshow-container">
        <!-- Banner 1 -->
        <div class="mySlides fade">
            <div class="numbertext">1 / 4</div>
            <a href="index.php"><img class="SlideProduto" src="./assets/img/Ofertas dia do consumidor neon amarelo e preto banner para mercado shops.png" alt="Oferta1"></a>
        </div>

        <!-- Banner 2 -->
        <div class="mySlides fade">
            <div class="numbertext">2 / 4</div>
            <a href="index.php"><img class="SlideProduto" src="assets/img/Banner black friday ofertas preto amarelo.png" alt="Ousadia"></a>
        </div>

        <!-- Banner 3 -->
        <div class="mySlides fade">
            <div class="numbertext">3 / 4</div>
            <a href="index.php"><img class="SlideProduto" src="./assets/img/Ofertas dia do consumidor neon amarelo e preto banner para mercado shops.png" alt="Stella"></a>
        </div>

        <!-- Banner 4 -->
        <div class="mySlides fade">
            <div class="numbertext">4 / 4</div>
            <a href="index.php"><img class="SlideProduto" src="assets/img/Banner black friday ofertas preto amarelo.png" alt="Catuaba"></a>
        </div>
    </div>

    <!-- Pontos de navegação dos banners -->
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>

    <div class="destaques">
        <h2 class="destaque-titulo">MAIS VENDIDOS DA SEMANA</h2>

        <!-- Iteração sobre as categorias e produtos -->
        <?php foreach ($categorias as $categoria => $produtosCategoria): ?>
            <div class="destaques-<?= strtolower($categoria) ?>">
                <h2 class="destaque-titulo"><?= htmlspecialchars($categoria) ?></h2>
                <ul>
                    <?php foreach (array_slice($produtosCategoria, 0, 5) as $produto): ?>
                        <li class="card-produto" id="produto-<?= $produto['idProduto'] ?>"> <!-- ID único para cada produto -->
                            <h2><?= htmlspecialchars($produto['nomeProduto']) ?></h2>

                            <!-- Exibe a imagem do produto -->
                            <?php if (!empty($produto['imagemProduto'])): ?>
                                <button class="btn-imagem" onclick="mostrarModal(
                                    <?= $produto['idProduto'] ?>, 
                                    '<?= htmlspecialchars($produto['nomeProduto']) ?>', 
                                    '<?= "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) ?>', 
                                    '<?= htmlspecialchars($produto['descricaoBebidas']) ?>',
                                    <?= $produto['precoProduto'] ?>
                                )">
                                    <img src="<?= "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) ?>" 
                                         alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>" 
                                         class="img-produto">
                                </button>
                            <?php else: ?>
                                <button class="btn-imagem" onclick="mostrarModal(
                                    <?= $produto['idProduto'] ?>, 
                                    '<?= htmlspecialchars($produto['nomeProduto']) ?>', 
                                    './assets/img/placeholder.png', 
                                    'Imagem indisponível', 
                                    <?= $produto['precoProduto'] ?>
                                )">
                                    <img src="./assets/img/placeholder.png" alt="Imagem indisponível" class="img-produto">
                                </button>
                            <?php endif; ?>

                            <p class="preco">R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>

                            <!-- Botão de adicionar ao carrinho -->
                            <button class="btn-add-carrinho" onclick="adicionarAoCarrinho(<?= $produto['idProduto'] ?>)">
                                +
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require __DIR__ . '/footer.php' ?>

