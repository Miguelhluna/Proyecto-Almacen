//#region Variables 
var currentIndex = 0; // Inicia en la primera imagen del carrusel (índice 0)
//#endregion

//#region Variables :: List
var devices = [
    {
        nombre: 'Ron',
        articulo: 'Wilson',
        tipo_de_novedad: '30',
        novedad: 'Wizard of Oz',
        articulo: '',
        fecha_de_novedad: '2025-03-03 15:40',
    },
    {
        nombre: 'Armando',
        articulo: 'Reyes',
        tipo_de_novedad: '17',
        novedad: 'Star Wars',
        articulo: '',
        fecha_de_novedad: '2025-03-03 13:40',
    },
    {
        nombre: 'Sarah',
        articulo: 'Thompkins',
        tipo_de_novedad: '62',
        novedad: 'Ghostbusters',
        articulo: '',
        fecha_de_novedad: '2025-03-03 15:42',
    },
    {
        nombre: 'Sofia',
        articulo: 'Schugel',
        tipo_de_novedad: '25',
        novedad: 'Moana',
        articulo: '',
        fecha_de_novedad: '2025-03-03 9:40',
    },
    {
        nombre: 'sofia',
        articulo: 'Schugel',
        tipo_de_novedad: '25',
        novedad: 'Moana',
        articulo: '',
        fecha_de_devolucion: '2025-03-03 12:49',
    },
];
//#endregion

//#region Variables :: Object
var images; // Selecciona el contenedor de las imágenes del carrusel
var totalImages; // Obtiene el número total de imágenes dentro del contenedor
var prevButton; // Selecciona el botón "anterior"
var nextButton; // Selecciona el botón "siguiente"
var indicators; // Selecciona todos los indicadores de las imágenes
//#endregion

//#region Index
/// Funcion que se ejucta despues de que se renderice el DOM
$(document).ready(function () {
    images = document.querySelector('.imagenes');
    totalImages = images.children.length;
    prevButton = document.querySelector('.prev');
    nextButton = document.querySelector('.next');
    indicators = document.querySelectorAll('.indicadores span');

    Carrousel_transition();
    Event_listener();

    Devide_render();
})
//#endregion

//#region DOM :: Event :: Listener
function Event_listener() {
    $("#btn-prev").click(function () {
        Carrousel_btn(true)
    })
    $("#btn-next").click(function () {
        Carrousel_btn(false)
    })
}
//#endregion

//#region DOM :: Event :: Carrousel
function Carrousel_transition() {
    updateCarousel(currentIndex); // Muestra la primera imagen del carrusel al cargar
    setInterval(() => {
        currentIndex = (currentIndex < totalImages - 1) ? currentIndex + 1 : 0; // Avanza al siguiente índice o vuelve al inicio si es la última imagen
        updateCarousel(currentIndex); // Actualiza la imagen mostrada
    }, 3000); // Cambia de imagen cada 3 segundos

    let startX; // Variable para la posición inicial del toque
    const handleTouchStart = (event) => {
        startX = event.touches[0].clientX; // Registra la posición del toque inicial
    };

    const handleTouchEnd = (event) => {
        const endX = event.changedTouches[0].clientX; // Registra la posición del toque final
        if (startX > endX + 50) { // Si el toque se movió a la izquierda
            // Deslizar a la izquierda
            nextButton.click(); // Simula un clic en el botón "siguiente"
        } else if (startX < endX - 50) { // Si el toque se movió a la derecha
            // Deslizar a la derecha
            prevButton.click(); // Simula un clic en el botón "anterior"
        }
    };

    // Detecta el inicio y final de un toque para cambiar de imagen en dispositivos táctiles
    images.addEventListener('touchstart', handleTouchStart); // Escucha el inicio de un toque
    images.addEventListener('touchend', handleTouchEnd); // Escucha el final de un toque

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }
}

function Carrousel_btn(next) {
    if (next == true) {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalImages - 1; // Si no estamos en la primera imagen, retrocede. Si estamos en la primera, va a la última
        updateCarousel(currentIndex); // Actualiza la imagen mostrada
    } else {
        currentIndex = (currentIndex < totalImages - 1) ? currentIndex + 1 : 0; // Si no estamos en la última imagen, avanza. Si estamos en la última, va a la primera
        updateCarousel(currentIndex); // Actualiza la imagen mostrada
    }
}

function updateCarousel(index) {
    // Ajusta la transformación y los indicadores
    images.style.transform = 'translateX(' + (-index * 100) + '%)'; // Mueve el carrusel horizontalmente
    indicators.forEach((indicator, i) => {
        indicator.className = i === index ? 'activo' : ''; // Cambia la clase del indicador dependiendo de la imagen actual
    });
}
//#endregion

//#region DOM :: Render
function Devide_render() {
    //forof
    for (const element of devices) {
        $('#devices').append(`
            <div class="row">
              <span class="value">${element.nombre}</span>
              <span class="value">${element.articulo}</span>
              <span class="value">${element.tipo_de_novedad}</span>
              <span class="value">${element.novedad}</span>
              <span class="value">${element.fecha_de_novedad}</span>
             
              
            </div> 
        `)
    }
    $('#devices-amount').text(devices.length);
}
//#endregion
document.getElementById('img').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profile').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Obtener elementos
const modal = document.getElementById("modal");
const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");

// Abrir modal
openModal.onclick = () => {
    modal.style.display = "flex";
};

// Cerrar modal al hacer clic en el botón de cerrar
closeModal.onclick = () => {
    modal.style.display = "none";
};

// Cerrar modal si se hace clic fuera del contenido
window.onclick = (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
    }
};