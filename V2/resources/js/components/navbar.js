 const menu = document.getElementById('menu');
        const hamburger = document.getElementById('hamburger');
        
        hamburger.addEventListener('click', () => {
            if (menu.style.height === '0px' || !menu.style.height) {
                menu.style.height = menu.scrollHeight + 'px';
                hamburger.style.transform = 'rotate(90deg)';
            } else {
                menu.style.height = '0px';
                hamburger.style.transform = 'rotate(0deg)';
            }
        });