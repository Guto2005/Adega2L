// Slideshow de Banners
let slideIndex = 0;
let slideTimer; // Variável para armazenar o temporizador do slideshow
showSlides();

// Função para exibir os slides
function showSlides() {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (slides.length === 0 || dots.length === 0) return;

    // Esconde todos os slides
    for (let slide of slides) {
        slide.style.display = "none";
    }

    // Reseta a classe ativa dos pontos
    for (let dot of dots) {
        dot.classList.remove("active");
    }

    // Avança para o próximo slide
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }

    // Exibe o slide atual
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].classList.add("active");

    // Reinicia o timer para evitar sobreposições
    clearTimeout(slideTimer);
    slideTimer = setTimeout(showSlides, 3000);
}

// Função para navegar diretamente ao slide específico
function currentSlide(n) {
    slideIndex = n;
    showSlidesManually(n);
}

// Função que exibe o slide manualmente e pausa a rotação automática
function showSlidesManually(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (slides.length === 0 || dots.length === 0) return;

    // Esconde todos os slides
    for (let slide of slides) {
        slide.style.display = "none";
    }

    // Reseta a classe ativa dos pontos
    for (let dot of dots) {
        dot.classList.remove("active");
    }

    // Exibe o slide escolhido
    slides[n - 1].style.display = "block";
    dots[n - 1].classList.add("active");

    // Para o loop automático ao selecionar manualmente
    clearTimeout(slideTimer);
}

// Função para tratar a pesquisa
function handleSearch(event) {
    event.preventDefault();  // Impede o envio tradicional do formulário
    const searchInput = document.getElementById('search-input');
    if (!searchInput) return;

    const searchQuery = searchInput.value.trim().toLowerCase();
    if (searchQuery) {
        const url = generateSearchURL(searchQuery);
        window.location.href = url; // Redireciona para a página correta
    }
}

// Função para gerar a URL da pesquisa
function generateSearchURL(query) {
    let categoria = 'bebidas';
    query = query.toLowerCase();

    const categorias = {
        bebidas: ["refrigerante", "coca", "pepsi", "fanta", "guaraná", "monster", "redbull", "suco", "água", "powerade", "ice", "leev"],
        cigarros: ["cigarro", "charuto", "rothmans", "dunhill", "winston", "black", "mentolado", "blunt", "essências", "seda", "piteira"],
        snacks: ["snack", "biscoito", "batata", "doritos", "ruffles", "chocolate", "kitkat", "bis", "bala", "chiclete", "pirulito", "mentos", "brigadeiro", "bolacha", "pé de moleque", "paçoca"],
        destilados: ["vodka", "whisky", "rum", "catuaba", "smirnoff", "jurupinga", "tequiloka", "licor"]
    };

    // Função para verificar similaridade parcial na pesquisa
    function verificaSimilaridade(query, termos) {
        return termos.some(termo => query.includes(termo) || termo.includes(query));
    }

    for (const [key, termos] of Object.entries(categorias)) {
        if (verificaSimilaridade(query, termos)) {
            categoria = key;
            break;
        }
    }

    return `./${categoria}.php?q=${encodeURIComponent(query)}`;
}

// Aguarda a página carregar para evitar erro ao tentar acessar elementos inexistentes
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    if (searchForm) {
        searchForm.addEventListener("submit", handleSearch);
    }
});

// Função para abrir o modal
function mostrarModal(idProduto, nomeProduto, imagemProduto, descricaoProduto, precoProduto) {
    // Encontrando o modal e elementos internos
    var modal = document.getElementById('modal-produto');
    var modalImg = document.getElementById('modal-img');
    var modalNome = document.getElementById('modal-nome-produto');
    var modalDesc = document.getElementById('modal-desc');
    var modalPreco = document.getElementById('modal-preco-produto');

    if (!modal || !modalImg || !modalNome || !modalDesc || !modalPreco) return;

    // Atualizando os conteúdos do modal com os dados do produto
    modalImg.src = imagemProduto;
    modalNome.textContent = nomeProduto;
    modalDesc.textContent = descricaoProduto;
    modalPreco.textContent = 'R$ ' + precoProduto.toFixed(2).replace('.', ',');

    // Exibindo o modal
    modal.style.display = "block";
}

function fecharModal() {
    var modal = document.getElementById('modal-produto');
    if (!modal) return;
    modal.style.display = "none";
}

function verificarLogin() {
    // Verifica se o usuário está logado
    const usuarioLogado = localStorage.getItem('usuarioLogado'); 
  
    // Se o usuário estiver logado, esconde todos os links de autenticação
    if (usuarioLogado) {
      document.getElementById('auth-links-desktop').style.display = 'none';
      document.getElementById('auth-links-mobile').style.display = 'none';
    } else {
      // Caso contrário, mostra os links adequados
      if (window.innerWidth <= 768) {
        // Para dispositivos móveis, exibe os links móveis
        document.getElementById('auth-links-mobile').style.display = 'flex';
        document.getElementById('auth-links-desktop').style.display = 'none';
      } else {
        // Para dispositivos maiores (desktop), exibe os links desktop
        document.getElementById('auth-links-desktop').style.display = 'flex';
        document.getElementById('auth-links-mobile').style.display = 'none';
      }
    }
  }
  
  // Funções simulando login e logout
  function logar() {
    localStorage.setItem('usuarioLogado', 'true');
    verificarLogin(); // Atualiza a interface
  }
  
  function deslogar() {
    localStorage.removeItem('usuarioLogado');
    verificarLogin(); // Atualiza a interface
  }
  
  // Chama a função de verificação no carregamento
  window.onload = verificarLogin;
  
  // Re-verifica sempre que a janela for redimensionada
  window.onresize = verificarLogin;
  

