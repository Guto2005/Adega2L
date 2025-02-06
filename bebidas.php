<?php require __DIR__ . '/header.php'; ?>

<main class="container">
    <link rel="stylesheet" href="./assets/css/bebidas.css" />

    <div class="produtos">
        <h2 class="destaque-titulo">MAIS VENDIDOS DA SEMANA</h2>
        <div class="destaques-bebidas">
            <ul>
                <?php
                // Obter o idCategoria para 'Bebidas'
                $queryCategoria = "SELECT idCategoria FROM ADG2L_Categorias WHERE nomeCategoria = 'Bebidas'";
                $resultCategoria = $pdo->query($queryCategoria);
                $categoria = $resultCategoria->fetch(PDO::FETCH_ASSOC);

                // Verifique se a categoria foi encontrada
                if ($categoria) {
                    $idCategoria = $categoria['idCategoria'];

                    // Buscar produtos da categoria 'Bebidas' usando o idCategoria (limite de 5 produtos)
                    $query = "SELECT idProduto, nomeProduto, precoProduto, imagemProduto, descricaoBebidas, tipoUnidade, tamanhoUnidade FROM ADG2L_Produtos WHERE idCategoria = :idCategoria LIMIT 5";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([':idCategoria' => $idCategoria]);
                    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($produtos) > 0) {
                        foreach ($produtos as $produto): ?>
                            <!-- Exemplo de li dentro do loop -->
                            <li class="card-produto" data-category="bebidas">
                                <h2 onclick="mostrarModal(<?= $produto['idProduto'] ?>)"><?= htmlspecialchars($produto['nomeProduto']) ?></h2>
                                <!-- Botão invisível em volta da imagem -->
                                <button class="btn-imagem" onclick="mostrarModal(<?= $produto['idProduto'] ?>)">
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

            <!-- Modal de detalhes do produto -->
            <div id="modalProduto" class="modal">
                <div class="modal-content">
                    <span class="fechar" onclick="fecharModal()">&times;</span>
                    <h2 id="modalNomeProduto"></h2>
                    <img id="modalImagemProduto" src="" alt="Imagem do produto" class="modal-imagem">
                    <p id="modalDescricaoProduto"></p>
                    <p id="modalPrecoProduto"></p>
                    <p id="modalUnidadeProduto"></p>
                </div>
            </div>

            <h2 class="catalogo-titulo">CATÁLOGO</h2>
            <div class="catalogo">
                <ul>
                    <?php
                    // Lógica de paginação
                    $produtosPorPagina = 15;
                    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina - 1) * $produtosPorPagina;

                    // Buscar produtos da categoria 'Bebidas' com limite para paginar
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
                                <h2 onclick="mostrarModal(<?= $produto['idProduto'] ?>)"><?= htmlspecialchars($produto['nomeProduto']) ?></h2>
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

                    // Contar total de produtos para paginar
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