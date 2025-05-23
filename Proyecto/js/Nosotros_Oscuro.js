document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    //  Elementos de la página principal (index.html)
    const hero = document.querySelector('.hero');
    const tendencias = document.querySelector('.tendencias');
    const cards = document.querySelectorAll('.card');
    //  Elementos de la página de login
    const mainLogin = document.getElementById('main-login');
    const loginForm = document.querySelector('.login-form');
    const inputGroups = document.querySelectorAll('.input-group');
    const loginButton = document.querySelector('.login-button');
    const forgotPassword = document.querySelector('.forgot-password');
    //  Elementos de la página "Nosotros"
    const mainNosotros = document.getElementById('main-nosotros');
    const heroNosotros = document.querySelector('.hero-nosotros');
    const misionVision = document.querySelector('.mision-vision');
    const equipo = document.querySelector('.equipo');
    const equipoMiembros = document.querySelectorAll('.equipo-miembro');
    const contacto = document.querySelector('.contacto');
    const footer = document.querySelector('.footer');

    darkModeToggle.addEventListener('click', function() {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        nav.classList.toggle('dark-mode');
        //  Página principal
        if (hero) hero.classList.toggle('dark-mode');
        if (tendencias) tendencias.classList.toggle('dark-mode');
        cards.forEach(card => {
            card.classList.toggle('dark-mode');
        });
        //  Página de login
        if (mainLogin) mainLogin.classList.toggle('dark-mode');
        if (loginForm) loginForm.classList.toggle('dark-mode');
        inputGroups.forEach(group => {
            group.classList.toggle('dark-mode');
        });
        if (loginButton) loginButton.classList.toggle('dark-mode');
        if (forgotPassword) forgotPassword.classList.toggle('dark-mode');
        //  Página "Nosotros"
        if (mainNosotros) mainNosotros.classList.toggle('dark-mode');
        if (heroNosotros) heroNosotros.classList.toggle('dark-mode');
        if (misionVision) misionVision.classList.toggle('dark-mode');
        if (equipo) equipo.classList.toggle('dark-mode');
        equipoMiembros.forEach(miembro => {
            miembro.classList.toggle('dark-mode');
        });
        if (contacto) contacto.classList.toggle('dark-mode');
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
        //  Página principal
        if (hero) hero.classList.add('dark-mode');
        if (tendencias) tendencias.classList.add('dark-mode');
        cards.forEach(card => {
            card.classList.add('dark-mode');
        });
        //  Página de login
        if (mainLogin) mainLogin.classList.add('dark-mode');
        if (loginForm) loginForm.classList.add('dark-mode');
        inputGroups.forEach(group => {
            group.classList.add('dark-mode');
        });
        if (loginButton) loginButton.classList.add('dark-mode');
        if (forgotPassword) forgotPassword.classList.add('dark-mode');
        //  Página "Nosotros"
        if (mainNosotros) mainNosotros.classList.add('dark-mode');
        if (heroNosotros) heroNosotros.classList.add('dark-mode');
        if (misionVision) misionVision.classList.add('dark-mode');
        if (equipo) equipo.classList.add('dark-mode');
        equipoMiembros.forEach(miembro => {
            miembro.classList.add('dark-mode');
        });
        if (contacto) contacto.classList.add('dark-mode');
        footer.classList.add('dark-mode');
    }
});