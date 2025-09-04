window.onload = function() {
    let headerHeight = document.querySelector('header').offsetHeight;
    let footerHeight = document.querySelector('footer').offsetHeight;
    document.querySelector('main').style.margin = `${headerHeight}px auto ${footerHeight}px`;
    let gameContainer = document.querySelector('.game-container');
    if (gameContainer) {
        gameContainer.style.top = headerHeight + 'px';
        gameContainer.style.bottom = footerHeight + 'px';
    }
    let history = document.querySelector('.history');
    if (history) {
        let width = history.offsetWidth + 70;
        history.style.width = width + "px";
    }
};
