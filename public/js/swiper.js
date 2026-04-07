document.addEventListener('DOMContentLoaded', () => {
    const swiper = new Swiper('.swiper', {
        // Configuración de Swiper
        loop: true,
        effect: 'cube',

        speed: 800,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
            draggable: true,
        },
    });
});
