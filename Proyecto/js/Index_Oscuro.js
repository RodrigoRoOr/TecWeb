document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    const hero = document.querySelector('.hero');
    const tendencias = document.querySelector('.tendencias');
    const cards = document.querySelectorAll('.card');
    const footer = document.querySelector('.footer');  //  CORRECCIÓN: Selector de clase

    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        nav.classList.toggle('dark-mode');
        hero.classList.toggle('dark-mode');
        tendencias.classList.toggle('dark-mode');
        cards.forEach(card => {
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
        hero.classList.add('dark-mode');
        tendencias.classList.add('dark-mode');
        cards.forEach(card => {
            card.classList.add('dark-mode');
        });
        footer.classList.add('dark-mode');
    }
});