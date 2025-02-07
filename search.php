<?php
require __DIR__ . '/config.php'; // Inclua seu arquivo de configuração

// Verifica se a consulta foi enviada
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    
    // Conexão com o banco de dados (substitua com suas credenciais)
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Consulta ao banco de dados (substitua 'produtos' e 'nome' conforme seu esquema)
    $sql = "SELECT * FROM produtos WHERE nome LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Exibe os resultados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='resultado'>";
            echo "<h3>" . $row['nome'] . "</h3>";
            echo "<p>" . $row['descricao'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>Nenhum resultado encontrado para '$query'.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
