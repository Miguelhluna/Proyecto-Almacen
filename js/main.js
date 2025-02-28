let currentIndex = 0;
const images = document.querySelector('.imagenes');
const totalImages = images.children.length;
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
const indicators = document.querySelectorAll('.indicadores span');

function updateCarousel(index) {
    // Ajusta la transformación y los indicadores
    images.style.transform = 'translateX(' + (-index * 100) + '%)';
    indicators.forEach((indicator, i) => {
        indicator.className = i === index ? 'activo' : '';
    });
}

prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalImages - 1;
    updateCarousel(currentIndex);
});

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex < totalImages - 1) ? currentIndex + 1 : 0;
    updateCarousel(currentIndex);
});

// Inicializa el carrusel mostrando la primera imagen
updateCarousel(currentIndex);
setInterval(() => {
    currentIndex = (currentIndex < totalImages - 1) ? currentIndex + 1 : 0;
    updateCarousel(currentIndex);
}, 3000); // Cambia de imagen cada 3 segundos
let startX;
const handleTouchStart = (event) => {
    startX = event.touches[0].clientX;
};

const handleTouchEnd = (event) => {
    const endX = event.changedTouches[0].clientX;
    if (startX > endX + 50) {
        // Deslizar a la izquierda
        nextButton.click();
    } else if (startX < endX - 50) {
        // Deslizar a la derecha
        prevButton.click();
    }
};

images.addEventListener('touchstart', handleTouchStart);
images.addEventListener('touchend', handleTouchEnd);