document.addEventListener("DOMContentLoaded", function() {
    // Barra de pesquisa (redirecionamento)
    const searchInput = document.getElementById("search-input");

    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        if (searchTerm.length >= 3) { // Garante que a pesquisa só é acionada após 3 caracteres
            let category = "";

            // Mapeia o termo para a categoria correspondente
            if (searchTerm.includes("coca") || searchTerm.includes("refrigerante")) {
                category = "bebidas.php";
            } else if (searchTerm.includes("vodka") || searchTerm.includes("whisky")) {
                category = "destilados.php";
            } else if (searchTerm.includes("batata") || searchTerm.includes("snack")) {
                category = "snacks.php";
            } else if (searchTerm.includes("cigarro")) {
                category = "cigarros.php";
            }

            // Se uma categoria foi identificada, redireciona
            if (category) {
                window.location.href = category;
            }
        }
    });

    // Slider (controle de slides)
    let slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    window.plusSlides = function(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    window.currentSlide = function(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }

    // Automatic Slideshow
    let slideIndexAuto = 0;
    showSlidesAuto();

    function showSlidesAuto() {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slideIndexAuto++;
        if (slideIndexAuto > slides.length) { slideIndexAuto = 1 }
        slides[slideIndexAuto - 1].style.display = "block";
        setTimeout(showSlidesAuto, 8000); // Troca de imagem a cada 8 segundos
    }

    // Função de validação do formulário de pesquisa
    window.validarPesquisa = function() {
        let input = document.getElementById('search-input').value.trim();
        if (input === '') {
            alert("Por favor, digite um termo para pesquisar.");
            return false; // Impede o envio do formulário
        }
        return true;
    }
});
