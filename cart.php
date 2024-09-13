<body>
    <?php include 'header.php' ?>

    <body>
        <main class="container">
            <div class="carrinho produtos">
                <h1>Seu Carrinho</h1>

                <!-- Formulário para adicionar produtos ao carrinho -->
                <h2>Produtos Disponíveis</h2>
                <!-- Exibição dos itens do carrinho -->
                <h2>Itens no Carrinho</h2>
                <!-- Botão para finalizar a compra -->
                <h2>Finalizar Compra</h2>
                <form action="checkout.php" method="post">
                    <input type="submit" value="Finalizar Compra">
                </form>
            </div>

        </main>
        <?php include 'footer.php' ?>
    </body>

    </html>