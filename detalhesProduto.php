<?php
require __DIR__ . '/config.php';

if (isset($_GET['idProduto'])) {
    $idProduto = (int)$_GET['idProduto'];
    
    // Consulta para obter os dados do produto
    $query = "SELECT nomeProduto, imagemProduto, descricaoBebidas, precoProduto, tipoUnidade, tamanhoUnidade FROM ADG2L_Produtos WHERE idProduto = :idProduto";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':idProduto' => $idProduto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Retorna os dados como JSON
    if ($produto) {
        echo json_encode($produto);
    } else {
        echo json_encode(['error' => 'Produto não encontrado']);
    }
}
?>
