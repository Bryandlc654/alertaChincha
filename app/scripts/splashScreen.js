var splashScreen = document.querySelector('.splash');
setTimeout(() => {
    splashScreen.style.opacity = 0;
    setTimeout(() => {
        splashScreen.classList.add('hidden');
    }, 610);
}, 3000);