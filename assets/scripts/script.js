// Slideshow de Banners
let slideIndex = 0;
showSlides();

// Função para exibir os slides
function showSlides() {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Reseta o índice de todos os slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Reseta a classe ativa dos pontos
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Avança para o próximo slide
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }

    // Exibe o slide atual
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";

    // Faz o loop a cada 3 segundos
    setTimeout(showSlides, 3000);
}

// Função para navegar diretamente ao slide específico
function currentSlide(n) {
    showSlidesManually(n);
}

// Função que exibe o slide manualmente
function showSlidesManually(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    // Reseta o índice de todos os slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    // Reseta a classe ativa dos pontos
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    // Exibe o slide escolhido
    slides[n - 1].style.display = "block";
    dots[n - 1].className += " active";
}

// Função para tratar a pesquisa

function handleSearch(event) {
    event.preventDefault();  // Impede o envio tradicional do formulário
    const searchQuery = document.getElementById('search-input').value.trim().toLowerCase();
    if (searchQuery) {
        const url = generateSearchURL(searchQuery);
        window.location.href = url; // Redireciona para a página com a pesquisa
    }
}

// Função para gerar a URL da pesquisa
function generateSearchURL(query) {
    let categoria = 'bebidas'; // Defina uma lógica para mapear para a categoria correta

    // Lógica de mapeamento das palavras-chave para as categorias
    if (query.includes("refrigerante") || query.includes("coca")) {
        categoria = 'bebidas';
    } else if (query.includes("cigarro") || query.includes("charuto")) {
        categoria = 'cigarros';
    } else if (query.includes("snack") || query.includes("biscoito") || query.includes("batata")) {
        categoria = 'snacks';
    } else if (query.includes("vodka") || query.includes("whisky") || query.includes("rum") || query.includes("catuaba")) {
        categoria = 'destilados';
    }

    // Retorna a URL para a página da categoria com o termo de pesquisa
    return `http://localhost/adega2L/${categoria}.php?q=${encodeURIComponent(query)}`;
}

// Adiciona o evento de submit da pesquisa
document.getElementById('search-form').addEventListener('submit', handleSearch);

  // Função para abrir o modal
function mostrarModal(idProduto, nomeProduto, imagemProduto) {
    var modal = document.getElementById('modal');
    var modalImg = document.getElementById('modal-img');
    var modalDesc = document.getElementById('modal-desc');

    // Atualiza as informações do modal
    modalImg.src = imagemProduto;
    modalDesc.textContent = nomeProduto;

    // Mostra o modal
    modal.style.display = "block";

    // Desabilita o foco na tela de trás
    document.body.style.overflow = 'hidden';
}

// Função para fechar o modal
function fecharModal() {
    var modal = document.getElementById('modal');
    modal.style.display = "none";
    
    // Restaura o foco na tela de trás
    document.body.style.overflow = 'auto';
}

// Função para fechar o modal quando clicar fora dele
window.onclick = function(event) {
    var modal = document.getElementById('modal');
    if (event.target == modal) {
        fecharModal();
    }
}



