document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    const noticiasContainer = document.querySelector('.noticias-container');
    const heroNoticias = document.querySelector('.hero-noticias');
    const noticiasDestacadas = document.querySelector('.noticias-destacadas');
    const noticiaCards = document.querySelectorAll('.noticia-card');
    const noticiaItems = document.querySelectorAll('.noticia-item');

    //  Opción 1: Seleccionar por etiqueta (funciona si solo hay un footer)
    const footer = document.querySelector('footer');

    //  Opción 2 (RECOMENDADA): Seleccionar por ID (más seguro)
    //  const footer = document.getElementById('main-footer');  //  Asegúrate de añadir el ID al footer en el HTML

    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        nav.classList.toggle('dark-mode');
        noticiasContainer.classList.toggle('dark-mode');
        heroNoticias.classList.toggle('dark-mode');
        noticiasDestacadas.classList.toggle('dark-mode');
        noticiaCards.forEach(card => {
            card.classList.toggle('dark-mode');
        });
        noticiaItems.forEach(item => {
            item.classList.toggle('dark-mode');
        });
        footer.classList.toggle('dark-mode');
    });
});