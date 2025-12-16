// events.js – обработчики событий

document.addEventListener('DOMContentLoaded', function() {
    // Обработка формы бронирования кабинки
    const roomForm = document.getElementById('room-booking-form');
    if (roomForm) {
        roomForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('room-client-name').value,
                phone: document.getElementById('room-phone').value,
                date: document.getElementById('room-date').value,
                time: document.getElementById('room-time').value,
                type: document.getElementById('room-type').value,
                theme: document.getElementById('theme').value
            };

            // Здесь будет AJAX запрос (в data.js)
            console.log('Room booking data:', formData);
            alert(`Room booked for ${formData.name}! We'll call you at ${formData.phone}.`);

            roomForm.reset();
            document.getElementById('room-message').textContent = 'Booking submitted!';
        });
    }

    // Пример дополнительного обработчика
    const navLinks = document.querySelectorAll('nav a');
    navLinks.forEach(link => {
        link.addEventListener('mouseover', function() {
            this.style.backgroundColor = 'rgba(255,255,255,0.3)';
        });
        link.addEventListener('mouseout', function() {
            this.style.backgroundColor = '';
        });
    });
});
// Добавьте в конец events.js:

// Обработчик keydown для поля телефона (форматирование)
const phoneInputs = document.querySelectorAll('input[type="tel"]');
phoneInputs.forEach(input => {
    input.addEventListener('keydown', function(e) {
        // Разрешаем только цифры, Backspace, Tab, стрелки
        if (!/[0-9]|Backspace|Tab|ArrowLeft|ArrowRight/.test(e.key)) {
            e.preventDefault();
        }
    });

    input.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 10) value = value.substring(0, 10);
        if (value.length > 6) {
            value = `+${value.substring(0,1)} (${value.substring(1,4)}) ${value.substring(4,7)}-${value.substring(7)}`;
        } else if (value.length > 3) {
            value = `+${value.substring(0,1)} (${value.substring(1,4)}) ${value.substring(4)}`;
        } else if (value.length > 0) {
            value = `+${value}`;
        }
        this.value = value;
    });
});