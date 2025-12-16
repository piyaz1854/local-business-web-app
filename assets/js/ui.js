// ui.js – слайдер и UI-логика

document.addEventListener('DOMContentLoaded', function() {
    // Слайдер кабинок
    const roomImages = [
        'https://via.placeholder.com/800x400/6a11cb/fff?text=Small+Room+(up+to+6)',
        'https://via.placeholder.com/800x400/2575fc/fff?text=Medium+Room+(up+to+10)',
        'https://via.placeholder.com/800x400/00b894/fff?text=Large+Room+(up+to+12)',
        'https://via.placeholder.com/800x400/fdcb6e/fff?text=VIP+Room'
    ];

    let currentSlide = 0;
    const slider = document.getElementById('room-slider');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    function showSlide(index) {
        if (index >= roomImages.length) currentSlide = 0;
        if (index < 0) currentSlide = roomImages.length - 1;
        slider.innerHTML = `<img src="${roomImages[currentSlide]}" alt="Room ${currentSlide + 1}">`;
    }

    prevBtn.addEventListener('click', () => {
        currentSlide--;
        showSlide(currentSlide);
    });

    nextBtn.addEventListener('click', () => {
        currentSlide++;
        showSlide(currentSlide);
    });

    // Автопрокрутка каждые 3 секунды
    setInterval(() => {
        currentSlide++;
        showSlide(currentSlide);
    }, 3000);

    // Инициализация
    showSlide(0);
});