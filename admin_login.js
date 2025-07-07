document.addEventListener('DOMContentLoaded', function() {
    const showBtn = document.getElementById('showPassBtn');
    const passwordInput = document.getElementById('password');
    let shown = false;

    showBtn.addEventListener('click', function() {
        shown = !shown;
        passwordInput.type = shown ? 'text' : 'password';
        showBtn.textContent = shown ? 'Hide Password' : 'Show Password';
        showBtn.classList.toggle('active');
    });

    // Button click animation
    const loginBtn = document.querySelector('.login-btn');
    loginBtn.addEventListener('mousedown', function() {
        loginBtn.style.transform = 'scale(0.96)';
    });
    loginBtn.addEventListener('mouseup', function() {
        loginBtn.style.transform = 'scale(1)';
    });
});