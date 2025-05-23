document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    const juegosContainer = document.querySelector('.juegos-container');
    const juegosHeader = document.querySelector('.juegos-header');
    const juegoCards = document.querySelectorAll('.juego-card');
    const footer = document.querySelector('.footer');  //  CORRECCIÓN: Selector de clase

    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        nav.classList.toggle('dark-mode');
        juegosContainer.classList.toggle('dark-mode');
        juegosHeader.classList.toggle('dark-mode');
        juegoCards.forEach(card => {
            card.classList.toggle('dark-mode');
        });
        footer.classList.toggle('dark-mode');

        //  Opcional: Guardar la preferencia en localStorage
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    //  Opcional: Cargar la preferencia guardada al cargar la página
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        header.classList.add('dark-mode');
        nav.classList.add('dark-mode');
        juegosContainer.classList.add('dark-mode');
        juegosHeader.classList.add('dark-mode');
        juegoCards.forEach(card => {
            card.classList.add('dark-mode');
        });
        footer.classList.add('dark-mode');
    }
});