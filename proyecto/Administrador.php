<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Sena</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="CSS/styles.css?v=<?php echo time(); ?>">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div class="contenedor_loader">
        <div class="loader">
        </div>
    </div>

    <div>
        <header>
            <div class="sena">
                <img class="sena" src="img/image.png" alt="SENA" title="SENA">

            </div>
            <h2 class="tittle">Administrador</h2>
            <p class="p2">CTGI</p>
        </header>
    </div>
    <div class="container1">
        <div class="card">
            <div class="content">
                <ion-icon name="search-circle-outline" class="icons1"></ion-icon>
                <h3>Consultar</h3>
                <p>El sistema debe permitir consultar al administrador</p>
                <a href="inventario.php">Consultar</a>
            </div>
        </div>

        <div class="card">
            <div class="content">
                <ion-icon name="create-outline" class="icons1"></ion-icon>
                <h3>Modificar</h3>
                <p>El sistema debe permitir modificar al administrador</p>
                <a href="#">Modificar</a>
            </div>
        </div>

        <div class="card">
            <div class="content">
                <ion-icon name="sync-outline" class="icons1"></ion-icon>
                <h3>Cambiar estado
                </h3>
                <p>El sistema debe permitir cambiar el estado al administrador</p>
                <button class="all" onclick="openModal()">Cambiar estado</button>
            </div>
        </div>
        <div class="card">
            <div class="content">
                <ion-icon name="id-card-outline" class="icons1"></ion-icon>
                <h3>Registrar</h3>
                <p>El sistema debe permitir registrar al administrador</p>
                <button class="all" onclick="registrarAll();">Registrar</button>
            </div>
        </div>
    </div>

    <!-- Modal + Backdrop -->
    <div id="modalBackdrop" class="modal-backdrop">
        <div class="modal">
            <h2>Cambiar estado</h2>

            <input type="text" placeholder="Id funcionario" required>
            <select>
                <option value="">Activo</option>
                <option value="">Inhabilitado</option>
            </select>
            <button>Cambiar</button>
            <span class="close-btn" onclick="closeModal();">&times;</span>
        </div>
    </div>
    <div id="registrarAll" class="modal-backdrop">


        <div class="modal">
            <form action="PHP/instructores.php" method="POST">
                <span onclick="cerrarAll();" class="closebtn">&times;</span>
                <h2 style="margin-top: 10px;">Registrar</h2>
                <div>
                    <label for=""> Rol
                    </label>

                    <select name="rol" id="rol" required>
                        <option value="">Seleccione</option>
                        <option value="instructor">Instructor</option>
                        <option value="administrador">Almacenista</option>
                    </select>
                </div>
                <div>
                    <label for="">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div>
                    <label for="">Documento</label>
                    <input type="text" name="documento" id="documento" required>
                </div>
                <div>
                    <label for="">Correo electronico</label>
                    <input type="email" name="correo" id="correo" required>
                </div>
                <div>
                    <label for="">Telefono</label>
                    <input type="tel" name="telefono" id="telefono" required>
                </div>
                <button>Registrar</button>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.6.1/vanilla-tilt.min.js"></script>
    <script>
        VanillaTilt.init(document.querySelectorAll(".card"), {
            max: 25,
            speed: 400,
            glare: true,
            "max-glare": 1
        });
    </script>
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const contenedor_loader = document.querySelector('.contenedor_loader');
                contenedor_loader.style.opacity = '0';
                contenedor_loader.style.visibility = 'hidden';
            }, 1000); // 2000 milisegundos = 2 segundos
        });
        window.registrarAll = function () {
            document.getElementById("registrarAll").style.display = "block";
        };
        window.cerrarAll = function () {
            document.getElementById("registrarAll").style.display = "none";
        }; function openModal() {
            document.getElementById('modalBackdrop').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modalBackdrop').style.display = 'none';
        }
    </script>

    <script src="js/script.js"></script>

</body>

</html>