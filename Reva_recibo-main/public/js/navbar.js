// navbar.js

document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.getElementById('mobile-menu');
    const navMenu = document.querySelector('.nav-menu');

    mobileMenuToggle.addEventListener('click', function () {
        navMenu.classList.toggle('show');
    });
});
