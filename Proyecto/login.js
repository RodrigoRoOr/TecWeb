document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailValidationIcon = document.getElementById('email-validation');
    const passwordValidationIcon = document.getElementById('password-validation');
    const loginButton = document.getElementById('login-button');
    const successMessage = document.getElementById('success-message');

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
        updateLoginButtonState();
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
        updateLoginButtonState();
    }

    function updateLoginButtonState() {
        loginButton.disabled = !(isEmailValid && isPasswordValid);
    }

    loginButton.addEventListener('click', function() {
        if (isEmailValid && isPasswordValid) {
            successMessage.style.display = 'flex';
            // In a real application, you would send the data to a server for authentication here.
            setTimeout(() => {
                successMessage.style.display = 'none';
                // Optionally redirect to another page after successful login
                // window.location.href = 'dashboard.html';
            }, 3000);
        }
    });

    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);

    // Initial validation on page load (in case of pre-filled values)
    validateEmail();
    validatePassword();
});