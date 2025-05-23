document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const header = document.querySelector('header');
    const nav = document.querySelector('nav');
    const registerContainer = document.querySelector('.register-container');
    const registerForm = document.querySelector('.register-form');
    const footer = document.querySelector('footer');
    const darkModeToggle = document.getElementById('dark-mode-toggle'); // Asegúrate de tener el botón en tu HTML

    const registerEmailInput = document.getElementById('register-email');
    const registerPasswordInput = document.getElementById('register-password');
    const registerNombreInput = document.getElementById('register-nombre');
    const registerApellidoInput = document.getElementById('register-apellido');
    const registerFechaNacimientoInput = document.getElementById('register-fecha-nacimiento');
    const registerButton = document.getElementById('register-button');

    let isRegisterEmailValid = false;
    let isRegisterPasswordValid = false;
    let isRegisterNombreValid = false;
    let isRegisterApellidoValid = false;
    let isRegisterFechaNacimientoValid = false;

    function toggleDarkMode() {
        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');
        nav.classList.toggle('dark-mode');
        registerContainer.classList.toggle('dark-mode');
        registerForm.classList.toggle('dark-mode');
        footer.classList.toggle('dark-mode');

        // Guardar la preferencia en localStorage (opcional)
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    }

    function validateRegisterEmail() {
        const emailValue = registerEmailInput.value.trim();
        if (emailValue.includes('@') && emailValue.includes('.')) {
            registerEmailInput.classList.remove('invalid-input');
            registerEmailInput.classList.add('valid-input');
            isRegisterEmailValid = true;
        } else {
            registerEmailInput.classList.remove('valid-input');
            registerEmailInput.classList.add('invalid-input');
            isRegisterEmailValid = false;
        }
        updateRegisterButtonState();
    }

    function validateRegisterPassword() {
        const passwordValue = registerPasswordInput.value.trim();
        if (passwordValue !== '') {
            registerPasswordInput.classList.remove('invalid-input');
            registerPasswordInput.classList.add('valid-input');
            isRegisterPasswordValid = true;
        } else {
            registerPasswordInput.classList.remove('valid-input');
            registerPasswordInput.classList.add('invalid-input');
            isRegisterPasswordValid = false;
        }
        updateRegisterButtonState();
    }

    function validateRegisterNombre() {
        const nombreValue = registerNombreInput.value.trim();
        if (nombreValue !== '') {
            registerNombreInput.classList.remove('invalid-input');
            registerNombreInput.classList.add('valid-input');
            isRegisterNombreValid = true;
        } else {
            registerNombreInput.classList.remove('valid-input');
            registerNombreInput.classList.add('invalid-input');
            isRegisterNombreValid = false;
        }
        updateRegisterButtonState();
    }

    function validateRegisterApellido() {
        const apellidoValue = registerApellidoInput.value.trim();
        if (apellidoValue !== '') {
            registerApellidoInput.classList.remove('invalid-input');
            registerApellidoInput.classList.add('valid-input');
            isRegisterApellidoValid = true;
        } else {
            registerApellidoInput.classList.remove('valid-input');
            registerApellidoInput.classList.add('invalid-input');
            isRegisterApellidoValid = false;
        }
        updateRegisterButtonState();
    }

    function validateRegisterFechaNacimiento() {
        const fechaNacimientoValue = registerFechaNacimientoInput.value.trim();
        if (fechaNacimientoValue !== '') {
            registerFechaNacimientoInput.classList.remove('invalid-input');
            registerFechaNacimientoInput.classList.add('valid-input');
            isRegisterFechaNacimientoValid = true;
        } else {
            registerFechaNacimientoInput.classList.remove('valid-input');
            registerFechaNacimientoInput.classList.add('invalid-input');
            isRegisterFechaNacimientoValid = false;
        }
        updateRegisterButtonState();
    }

    function updateRegisterButtonState() {
        registerButton.disabled = !(isRegisterEmailValid && isRegisterPasswordValid && isRegisterNombreValid && isRegisterApellidoValid && isRegisterFechaNacimientoValid);
    }

    function resetValidationClasses() {
        registerEmailInput.classList.remove('valid-input', 'invalid-input');
        registerPasswordInput.classList.remove('valid-input', 'invalid-input');
        registerNombreInput.classList.remove('valid-input', 'invalid-input');
        registerApellidoInput.classList.remove('valid-input', 'invalid-input');
        registerFechaNacimientoInput.classList.remove('valid-input', 'invalid-input');
    }

    function resetValidationStates() {
        isRegisterEmailValid = false;
        isRegisterPasswordValid = false;
        isRegisterNombreValid = false;
        isRegisterApellidoValid = false;
        isRegisterFechaNacimientoValid = false;
    }

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        validateRegisterEmail();
        validateRegisterPassword();
        validateRegisterNombre();
        validateRegisterApellido();
        validateRegisterFechaNacimiento();

        if (isRegisterEmailValid && isRegisterPasswordValid && isRegisterNombreValid && isRegisterApellidoValid && isRegisterFechaNacimientoValid) {
            const formData = new FormData(registerForm);

            fetch('backend/database.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                if (data === "Registro exitoso") {
                    registerForm.reset();
                    resetValidationClasses();
                    resetValidationStates();
                    updateRegisterButtonState();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrar usuario');
            });
        } else {
            console.log("Por favor, corrige los errores en el formulario.");
            // Opcionalmente, podrías mostrar un mensaje de error general en la interfaz
        }
    });

    registerEmailInput.addEventListener('input', validateRegisterEmail);
    registerPasswordInput.addEventListener('input', validateRegisterPassword);
    registerNombreInput.addEventListener('input', validateRegisterNombre);
    registerApellidoInput.addEventListener('input', validateRegisterApellido);
    registerFechaNacimientoInput.addEventListener('input', validateRegisterFechaNacimiento);

    // Event listener para el botón de modo oscuro
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', toggleDarkMode);

        // Cargar la preferencia guardada al cargar la página
        if (localStorage.getItem('dark-mode') === 'enabled') {
            toggleDarkMode();
        }
    }

    // Validación inicial al cargar la página
    resetValidationClasses();
    resetValidationStates();
    updateRegisterButtonState();
});