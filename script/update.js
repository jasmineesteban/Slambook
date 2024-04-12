function togglePassword(inputId) {
    var passwordInput = document.querySelector('input[name="' + inputId + '"]');
    var icon = document.querySelector('[onclick="togglePassword(' + "'" + inputId + "'" + ')"]');
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}
