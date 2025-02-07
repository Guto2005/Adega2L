<?php require __DIR__ . '/header.php'; ?>

<main class="container">
    <link rel="stylesheet" href="./assets/css/bebidas.css" />

    <div class="produtos">
        <h2 class="destaque-titulo">MAIS VENDIDOS DA SEMANA</h2>
        <div class="destaques-bebidas">
            <ul>
                <?php
                $queryCategoria = "SELECT idCategoria FROM ADG2L_Categorias WHERE nomeCategoria = 'Bebidas'";
                $resultCategoria = $pdo->query($queryCategoria);
                $categoria = $resultCategoria->fetch(PDO::FETCH_ASSOC);

                if ($categoria) {
                    $idCategoria = $categoria['idCategoria'];

                    // Ajuste para incluir mais detalhes no modal
                    $query = "SELECT idProduto, nomeProduto, precoProduto, imagemProduto, descricaoBebidas, tipoUnidade, tamanhoUnidade FROM ADG2L_Produtos WHERE idCategoria = :idCategoria LIMIT 5";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([':idCategoria' => $idCategoria]);
                    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($produtos) > 0) {
                        foreach ($produtos as $produto): ?>
                            <li class="card-produto" data-category="bebidas">
                                <h2 onclick="mostrarModal(<?= $produto['idProduto'] ?>, '<?= htmlspecialchars($produto['nomeProduto']) ?>', '<?= './panel/fotos/' . htmlspecialchars($produto['imagemProduto']) ?>', '<?= htmlspecialchars($produto['descricaoBebidas']) ?>', <?= number_format($produto['precoProduto'], 2, ',', '.') ?>, '<?= htmlspecialchars($produto['tipoUnidade']) ?>', <?= $produto['tamanhoUnidade'] ?>)">
                                    <?= htmlspecialchars($produto['nomeProduto']) ?>
                                </h2>
                                <button class="btn-imagem" onclick="mostrarModal(<?= $produto['idProduto'] ?>, '<?= htmlspecialchars($produto['nomeProduto']) ?>', '<?= './panel/fotos/' . htmlspecialchars($produto['imagemProduto']) ?>', '<?= htmlspecialchars($produto['descricaoBebidas']) ?>', <?= number_format($produto['precoProduto'], 2, ',', '.') ?>, '<?= htmlspecialchars($produto['tipoUnidade']) ?>', <?= $produto['tamanhoUnidade'] ?>)">
                                    <?php if (!empty($produto['imagemProduto'])): ?>
                                        <img src="<?= "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) ?>" alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>" class="img-produto">
                                    <?php else: ?>
                                        <img src="./assets/img/placeholder.png" alt="Imagem indisponível" class="img-produto">
                                    <?php endif; ?>
                                </button>
                                <p class="preco">R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>
                                <button class="btn-add-carrinho" onclick="adicionarAoCarrinho(<?= $produto['idProduto'] ?>)">+</button>
                            </li>
                        <?php endforeach;
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }
                } else {
                    echo "<p>Categoria 'Bebidas' não encontrada.</p>";
                }
                ?>
            </ul>

            <h2 class="catalogo-titulo">CATÁLOGO</h2>
            <div class="catalogo">
                <ul>
                    <?php
                    $produtosPorPagina = 15;
                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina - 1) * $produtosPorPagina;

                    $queryCatalogo = "SELECT idProduto, nomeProduto, precoProduto, imagemProduto FROM ADG2L_Produtos WHERE idCategoria = :idCategoria LIMIT :limite OFFSET :offset";
                    $stmtCatalogo = $pdo->prepare($queryCatalogo);
                    $stmtCatalogo->bindParam(':idCategoria', $idCategoria, PDO::PARAM_INT);
                    $stmtCatalogo->bindParam(':limite', $produtosPorPagina, PDO::PARAM_INT);
                    $stmtCatalogo->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmtCatalogo->execute();
                    $produtosCatalogo = $stmtCatalogo->fetchAll(PDO::FETCH_ASSOC);

                    if (count($produtosCatalogo) > 0) {
                        foreach ($produtosCatalogo as $produto): ?>
                            <li class="card-produto" data-category="bebidas">
                                <h2 onclick="mostrarModal(<?= $produto['idProduto'] ?>, '<?= htmlspecialchars($produto['nomeProduto']) ?>', '<?= './panel/fotos/' . htmlspecialchars($produto['imagemProduto']) ?>')"><?= htmlspecialchars($produto['nomeProduto']) ?></h2>
                                <?php if (file_exists("./panel/fotos/" . htmlspecialchars($produto['imagemProduto']))): ?>
                                    <img src="<?= "./panel/fotos/" . htmlspecialchars($produto['imagemProduto']) ?>" alt="Imagem de <?= htmlspecialchars($produto['nomeProduto']) ?>" class="img-produto" onclick="mostrarModal(<?= $produto['idProduto'] ?>)">
                                <?php else: ?>
                                    <img src="./assets/img/placeholder.png" alt="Imagem indisponível" class="img-produto" onclick="mostrarModal(<?= $produto['idProduto'] ?>)">
                                <?php endif; ?>
                                <p class="preco">R$ <?= number_format($produto['precoProduto'], 2, ',', '.') ?></p>
                                <button class="btn-add-carrinho" onclick="adicionarAoCarrinho(<?= $produto['idProduto'] ?>)">+</button>
                            </li>
                    <?php endforeach;
                    } else {
                        echo "<p>Nenhum produto encontrado.</p>";
                    }

                    $queryCount = "SELECT COUNT(*) FROM ADG2L_Produtos WHERE idCategoria = :idCategoria";
                    $stmtCount = $pdo->prepare($queryCount);
                    $stmtCount->execute([':idCategoria' => $idCategoria]);
                    $totalProdutos = $stmtCount->fetchColumn();
                    $totalPaginas = ceil($totalProdutos / $produtosPorPagina);
                    ?>
                </ul>

                <!-- Paginação -->
                <?php if ($totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if ($pagina > 1): ?>
                            <a href="?pagina=<?= $pagina - 1 ?>" class="prev">Anterior</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="?pagina=<?= $i ?>" class="<?= ($i == $pagina) ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>
                        <?php if ($pagina < $totalPaginas): ?>
                            <a href="?pagina=<?= $pagina + 1 ?>" class="next">Próximo</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
