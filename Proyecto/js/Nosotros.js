document.addEventListener('DOMContentLoaded', function() {
    const nombreInput = document.getElementById('nombre');
    const emailInput = document.getElementById('email');
    const mensajeInput = document.getElementById('mensaje');
    const nombreValidationIcon = document.getElementById('nombre-validation');
    const emailValidationIcon = document.getElementById('email-validation');
    const mensajeValidationIcon = document.getElementById('mensaje-validation');
    const enviarButton = document.getElementById('enviar-button');
    const successMessage = document.getElementById('success-message');
    const contactForm = document.getElementById('contactForm');

    let isNombreValid = false;
    let isEmailValid = false;
    let isMensajeValid = false;

    function validateNombre() {
        const nombreValue = nombreInput.value.trim();
        if (nombreValue !== '') {
            nombreValidationIcon.className = 'validation-icon valid';
            isNombreValid = true;
        } else {
            nombreValidationIcon.className = 'validation-icon invalid';
            isNombreValid = false;
        }
        updateEnviarButtonState();
    }

    function validateEmail() {
        const emailValue = emailInput.value.trim();
        if (emailValue.includes('@') && emailValue.includes('.')) { // Más genérico para dominios
            emailValidationIcon.className = 'validation-icon valid';
            isEmailValid = true;
        } else {
            emailValidationIcon.className = 'validation-icon invalid';
            isEmailValid = false;
        }
        updateEnviarButtonState();
    }

    function validateMensaje() {
        const mensajeValue = mensajeInput.value.trim();
        if (mensajeValue !== '') {
            mensajeValidationIcon.className = 'validation-icon valid';
            isMensajeValid = true;
        } else {
            mensajeValidationIcon.className = 'validation-icon invalid';
            isMensajeValid = false;
        }
        updateEnviarButtonState();
    }

    function updateEnviarButtonState() {
        enviarButton.disabled = !(isNombreValid && isEmailValid && isMensajeValid);
    }

    contactForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita la recarga de la página al enviar

        validateNombre();
        validateEmail();
        validateMensaje();

        if (isNombreValid && isEmailValid && isMensajeValid) {
            successMessage.style.display = 'flex';
            // Aquí iría la lógica para enviar los datos del formulario a un servidor
            // Simulación de envío exitoso:
            setTimeout(() => {
                successMessage.style.display = 'none';
                contactForm.reset();
                // Reiniciar iconos de validación
                nombreValidationIcon.className = 'validation-icon';
                emailValidationIcon.className = 'validation-icon';
                mensajeValidationIcon.className = 'validation-icon';
                isNombreValid = false;
                isEmailValid = false;
                isMensajeValid = false;
                updateEnviarButtonState(); // Deshabilitar el botón después del envío
            }, 3000);
        } else {
            // Opcional: Mostrar un mensaje de error general si no todos los campos son válidos
            console.log("Por favor, completa todos los campos correctamente.");
        }
    });

    nombreInput.addEventListener('input', validateNombre);
    emailInput.addEventListener('input', validateEmail);
    mensajeInput.addEventListener('input', validateMensaje);

    // Validación inicial al cargar la página (por si hay valores pre-cargados)
    validateNombre();
    validateEmail();
    validateMensaje();
});