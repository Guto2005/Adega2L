<?php require __DIR__ . '/header.php'; ?>

<main class="container">
    <link rel="stylesheet" href="./assets/css/cigarros.css" />

    <div class="produtos">
        <h2 class="destaque-titulo">MAIS VENDIDOS DA SEMANA</h2>
        <div class="destaques-cigarros">
            <ul>
                <?php
                $queryCategoria = "SELECT idCategoria FROM ADG2L_Categorias WHERE nomeCategoria = 'Cigarros'";
                $resultCategoria = $pdo->query($queryCategoria);
                $categoria = $resultCategoria->fetch(PDO::FETCH_ASSOC);

                if ($categoria) {
                    $idCategoria = $categoria['idCategoria'];

                    $query = "SELECT idProduto, nomeProduto, precoProduto, imagemProduto, descricaoBebidas FROM ADG2L_Produtos WHERE idCategoria = :idCategoria LIMIT 5";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([':idCategoria' => $idCategoria]);
                    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($produtos) > 0) {
                        foreach ($produtos as $produto): ?>
                            <li class="card-produto" data-category="cigarros">
                                <h2><?= htmlspecialchars($produto['nomeProduto']) ?></h2>

                                <!-- Exibe a imagem do produto -->
                                <button class="btn-imagem" onclick="mostrarModal(
                                    <?= $produto['idProduto'] ?>, 
                                    '<?= htmlspecialchars($produto['nomeProduto']) ?>', 
                                    '<?= !empty($produto['imagemProduto']) ? "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) : './assets/img/placeholder.png' ?>', 
                                    '<?= htmlspecialchars($produto['descricaoBebidas']) ?>',
                                    <?= number_format($produto['precoProduto'], 2, ',', '.') ?>
                                )">
                                    <img src="<?= !empty($produto['imagemProduto']) ? "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) : './assets/img/placeholder.png' ?>" 
                                         alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>" 
                                         class="img-produto">
                                </button>

                                <p class="preco">R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>
                                <button class="btn-add-carrinho" onclick="adicionarAoCarrinho(<?= $produto['idProduto'] ?>)">+</button>
                            </li>
                        <?php endforeach;
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }
                } else {
                    echo "<p>Categoria 'Cigarros' não encontrada.</p>";
                }
                ?>
            </ul>

            <h2 class="catalogo-titulo">CATÁLOGO</h2>
            <div class="catalogo">
                <ul class="destaque-ul">
                    <?php
                    $produtosPorPagina = 15;
                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina - 1) * $produtosPorPagina;

                    $queryCatalogo = "SELECT idProduto, nomeProduto, precoProduto, imagemProduto, descricaoBebidas FROM ADG2L_Produtos WHERE idCategoria = :idCategoria LIMIT :limite OFFSET :offset";
                    $stmtCatalogo = $pdo->prepare($queryCatalogo);
                    $stmtCatalogo->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
                    $stmtCatalogo->bindParam(':limite', $produtosPorPagina, PDO::PARAM_INT);
                    $stmtCatalogo->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmtCatalogo->execute();
                    $produtosCatalogo = $stmtCatalogo->fetchAll(PDO::FETCH_ASSOC);

                    if (count($produtosCatalogo) > 0) {
                        foreach ($produtosCatalogo as $produto): ?>
                            <li class="card-produto" data-category="cigarros">
                                <h2><?= htmlspecialchars($produto['nomeProduto']) ?></h2>
                                
                                <!-- Exibe a imagem do produto -->
                                <button class="btn-imagem" onclick="mostrarModal(
                                    <?= $produto['idProduto'] ?>, 
                                    '<?= htmlspecialchars($produto['nomeProduto']) ?>', 
                                    '<?= !empty($produto['imagemProduto']) ? "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) : './assets/img/placeholder.png' ?>', 
                                    '<?= htmlspecialchars($produto['descricaoBebidas']) ?>',
                                    <?= number_format($produto['precoProduto'], 2, ',', '.') ?>
                                )">
                                    <img src="<?= !empty($produto['imagemProduto']) ? "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) : './assets/img/placeholder.png' ?>" 
                                         alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>" 
                                         class="img-produto">
                                </button>

                                <p class="preco">R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>
                                <button class="btn-add-carrinho" onclick="adicionarAoCarrinho(<?= $produto['idProduto'] ?>)">+</button>
                            </li>
                    <?php endforeach;
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
