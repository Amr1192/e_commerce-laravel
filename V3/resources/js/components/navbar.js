const menu = document.getElementById('menu');
const hamburger = document.getElementById('hamburger');

if (hamburger && menu) {
    hamburger.addEventListener('click', () => {
        const isOpen = Boolean(menu.style.maxHeight && menu.style.maxHeight !== '0px');
        if (isOpen) {
            menu.style.maxHeight = '0px';
            hamburger.setAttribute('aria-expanded', 'false');
            hamburger.style.transform = 'rotate(0deg)';
        } else {
            menu.style.maxHeight = `${menu.scrollHeight}px`;
            hamburger.setAttribute('aria-expanded', 'true');
            hamburger.style.transform = 'rotate(90deg)';
        }
    });
}
