const $ = (selector) => document.querySelector(selector);

const bgNavbar = $('.bg-navbar');

window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        bgNavbar.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
        bgNavbar.style.boxShadow = '0px 0px 2px 4px (0,0,0, 0.75)';
        bgNavbar.style.backdropFilter = 'blur(7px)';
    } else {
        bgNavbar.style.backgroundColor = 'rgba(255, 255, 255, 1)';
        bgNavbar.style.boxShadow = 'none';
        bgNavbar.style.backdropFilter = 'blur(0px)';
    }
})
