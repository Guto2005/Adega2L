<footer>
    <div class="footer-institucional">
        <link rel="stylesheet" href="./assets/css/footer.css" />
        <div class="footer-left">
            <h4 class="redes-sociais-titulo">Redes Sociais</h4>
            <div class="redes-sociais">
                <a href="#"><i id="facebook-icon" class="fab fa-facebook"></i></a>
                <a href="#"><i id="instagram-icon" class="fab fa-instagram"></i></a>
                <a href="#"><i id="twitter-icon" class="fab fa-twitter"></i></a>
            </div>
            <div class="institucional-btn">
                <a class="institucional-link" href="institucional.php"><h4 class="institucional-titulo">Institucional</h4></a>
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
