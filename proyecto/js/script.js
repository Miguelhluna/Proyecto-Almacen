document.addEventListener("DOMContentLoaded", function () {
    // Botones de login y registro
    const container = document.querySelector('.container');
    const registerBtn = document.querySelector('.register-btn');
    const loginBtn = document.querySelector('.login-btn');

    if (registerBtn && loginBtn && container) {
        registerBtn.addEventListener('click', () => {
            container.classList.add('active');
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove('active');
        });
    }

    // Mostrar/ocultar el perfil
    const btnListo = document.getElementById("Listo");
    if (btnListo) {
        btnListo.addEventListener("click", function (event) {
            const popdiv = document.getElementById("pop");
            if (popdiv) popdiv.style.display = "none";
            console.log("Div ocultado al hacer clic en Listo");
            event.preventDefault();
        });
    }

    window.toggleProfile = function () {
        const popdiv = document.getElementById("pop");
        if (!popdiv) return;
        console.log("Función llamada");
        if (popdiv.style.display === "none" || popdiv.style.display === "") {
            popdiv.style.display = "block";
            console.log("Div mostrado");
        } else {
            console.log("El div permanece visible");
        }
    };

    // Botones de edición en tablas
    const editButtons = document.querySelectorAll(".edit");
    editButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            const row = event.target.closest("tr");
            if (!row) return;

            const id = row.querySelector("td:nth-child(1)").textContent;
            const descripcion = row.querySelector("td:nth-child(2)").textContent;

            // Rellenar el formulario
            const tipoNovedad = document.getElementById("tipo_novedad");
            const descripcionInput = document.getElementById("descripcion");
            const formularioContainer = document.getElementById("formularioContainer");

            if (tipoNovedad) tipoNovedad.value = ""; // O el valor deseado
            if (descripcionInput) descripcionInput.value = descripcion;
            if (formularioContainer) formularioContainer.style.display = "block";
        });
    });

    // Funciones para mostrar y ocultar divs
    window.mostrar = function () {
        document.getElementById("mostrarmaterial").style.display = "block";
    };
    window.ocultar = function () {
        document.getElementById("mostrarmaterial").style.display = "none";
    };

    window.aver = function (id_equipo2, marca, _serial_equipo) {
        document.getElementById("mostrarnovedad").style.display = "block";
        document.getElementById("id_equipo2").value = id_equipo2;
        document.getElementById("marca").value = marca;
        document.getElementById("serial_equipo").value = _serial_equipo;
    };
    window.noveo = function () {
        document.getElementById("mostrarnovedad").style.display = "none";
    };

    window.mostrar07 = function () {
        document.getElementById("equipos").style.display = "block";
    };
    window.ocultar07 = function () {
        document.getElementById("equipos").style.display = "none";
    };

    window.mostrar2 = function () {
        document.getElementById("formularioprestamosE").style.display = "block";
    };
    window.ocultar2 = function () {
        document.getElementById("formularioprestamosE").style.display = "none";
    };

    window.mostrar3 = function () {
        document.getElementById("formulariomateriales").style.display = "block";
    };
    window.ocultar3 = function () {
        document.getElementById("formulariomateriales").style.display = "none";
    };

    window.mostrar5 = function () {
        document.getElementById("forminst").style.display = "block";
    };
    window.ocultar5 = function () {
        document.getElementById("forminst").style.display = "none";
    };

    window.devolver = function () {
        document.getElementById("formularioDevolucion").style.display = "block";
    };
    window.cerrar = function () {
        document.getElementById("formularioDevolucion").style.display = "none";
    };
   


});
