document.getElementById('perfil-btn').addEventListener('click', function(event) {
    event.preventDefault(); // Previne o comportamento padrão do botão
    document.getElementById('perfil-modal').style.display = 'block';
});

document.getElementsByClassName('close-btn')[0].addEventListener('click', function() {
    document.getElementById('perfil-modal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('perfil-modal')) {
        document.getElementById('perfil-modal').style.display = 'none';
    }
});

// Fechar o modal ao pressionar "Esc"
window.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.getElementById('perfil-modal').style.display = 'none';
    }
});
