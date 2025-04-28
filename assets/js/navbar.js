let lastScrollTop;
const navbarScroll = document.getElementById('navbarScroll');

window.addEventListener('scroll', () => {
    let scrollTop = window.scrollY || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
        navbarScroll.style.top = `-${navbarScroll.offsetHeight}px`;
    } else {
        navbarScroll.style.top = '0';
    }

    lastScrollTop = scrollTop;
});