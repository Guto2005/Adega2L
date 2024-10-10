const banners = document.querySelectorAll('.banner');
const nextBtns = document.querySelectorAll('.next-btn');
const prevBtns = document.querySelectorAll('.prev-btn');

let currentIndex = 0;

// Função para mostrar o banner atual
function showBanner(index) {
    banners.forEach((banner, i) => {
        banner.style.display = i === index ? 'block' : 'none';
    });
}

// Mostra o primeiro banner ao carregar
showBanner(currentIndex);

// Adiciona event listeners aos botões "next"
nextBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % banners.length; // Avança para o próximo banner
        showBanner(currentIndex);
    });
});

document.getElementById('menu-toggle').addEventListener('click', function() {
    const perfilContent = document.getElementById('perfil-content');
    if (perfilContent.style.display === 'none' || perfilContent.style.display === '') {
        perfilContent.style.display = 'block'; // Mostra o conteúdo
    } else {
        perfilContent.style.display = 'none'; // Esconde o conteúdo
    }
});

// Adiciona event listeners aos botões "prev"
prevBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + banners.length) % banners.length; // Volta para o banner anterior
        showBanner(currentIndex);
    });
});

// Adiciona event listeners aos botões de controle
const controlBtns = document.querySelectorAll('.control-btn');
controlBtns.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        currentIndex = index; // Atualiza o índice atual para o botão clicado
        showBanner(currentIndex);
    });
});




