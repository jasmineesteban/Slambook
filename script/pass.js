function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const showPasswordIcon = passwordField.nextElementSibling;

    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    showPasswordIcon.classList.toggle('fa-eye');
    showPasswordIcon.classList.toggle('fa-eye-slash');
}