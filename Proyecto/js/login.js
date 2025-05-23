document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailValidationIcon = document.getElementById('email-validation');
    const passwordValidationIcon = document.getElementById('password-validation');
    const loginButton = document.getElementById('login-button');
    const loginForm = document.querySelector('.login-form');

    let isEmailValid = false;
    let isPasswordValid = false;

    function validateEmail() {
        const emailValue = emailInput.value.trim();
        if (emailValue.includes('@') && emailValue.includes('.com')) {
            emailValidationIcon.className = 'validation-icon valid';
            isEmailValid = true;
        } else {
            emailValidationIcon.className = 'validation-icon invalid';
            isEmailValid = false;
        }
        //  ¡IMPORTANTE! No habilitar el botón aquí
        // updateLoginButtonState();  //  Eliminar esta línea
    }

    function validatePassword() {
        const passwordValue = passwordInput.value.trim();
        if (passwordValue !== '') {
            passwordValidationIcon.className = 'validation-icon valid';
            isPasswordValid = true;
        } else {
            passwordValidationIcon.className = 'validation-icon invalid';
            isPasswordValid = false;
        }
        //  ¡IMPORTANTE! No habilitar el botón aquí
        // updateLoginButtonState();  //  Eliminar esta línea
    }

    function updateLoginButtonState() {
        //  ¡IMPORTANTE!  Esta función solo controla la habilitación inicial
        loginButton.disabled = !(isEmailValid && isPasswordValid);
    }

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();

        //  Solo enviar si la validación del lado del cliente pasa (formato)
        if (isEmailValid && isPasswordValid) {
            const correo = emailInput.value;
            const contrasena = passwordInput.value;

            const formData = new URLSearchParams();
            formData.append('correo', correo);
            formData.append('contrasena', contrasena);

            fetch('backend/login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Inicio de sesión exitoso") {
                    window.location.href = 'index.html'; // Redirigir en caso de éxito
                } else {
                    alert(data); // Mostrar mensaje de error del servidor
                    loginButton.disabled = true;  //  Deshabilitar el botón de nuevo
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al iniciar sesión');
                loginButton.disabled = true;  //  Deshabilitar el botón en caso de error de fetch
            });
        } else {
            alert("Por favor, ingresa un correo y contraseña válidos.");
        }
    });

    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);

    // Validación inicial al cargar la página (formato)
    validateEmail();
    validatePassword();
    updateLoginButtonState();  //  Controlar la habilitación inicial
});