document.getElementById('perfil-btn').onclick = function() {
    document.getElementById('perfil-modal').style.display = 'block';
}

document.getElementsByClassName('close-btn')[0].onclick = function() {
    document.getElementById('perfil-modal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == document.getElementById('profile-modal')) {
        document.getElementById('perfil-modal').style.display = 'none';
    }
}