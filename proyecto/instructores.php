</html><?php
        // filepath: c:\xampp\htdocs\Proyecto-Almacen-sofia\inventario.php
        session_start();

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['documento'])) {
            // Redirigir al login si no está autenticado
            header("Location: login.php");
            exit();
        }
        ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacen Sena</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="CSS/styles.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="js/script.js"></script>
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
            <h2 class="tittle">instructores</h2>
            <p class="p2">CTGI</p>
        </header>
    </div>
    <!---------------------------------------MENU------------------------------->
    <nav class="menu">
        <button class="dropmenu-toggle">&#9776;</button>
        <ul>
            <li><a href="inventario.php">Inicio</a></li>
            <li><a href="prestamos.php">Préstamo</a></li>
            <li><button id="inst" onclick="mostrar5();">Registrar instructores </button></li>
            <li><button onclick="toggleProfile()" popovertarget="pop">Perfil</button></li>
            <li><a href="Cerrar_sesion.php">Cerrar sesión</a></li>
            <div class="bienvenida">
                <?php
                $foto = isset($_SESSION['foto']) && !empty($_SESSION['foto']) ? 'PHP/' . $_SESSION['foto'] : 'IMG/profile.png';
                ?>
                <img src="<?php echo $foto; ?>" alt="Foto de perfil" class="foto-redonda">

                <?php if (isset($_SESSION['nombre_usuario'])): ?>
                    Bienvenido, <strong>
                        <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?>
                    </strong>
                <?php endif; ?>
            </div>
        </ul>
    </nav>


    <!-----------------------------------POPOVER-------------------->
    <div id="pop">
        <h2>Editar perfil</h2>
        <form action="PHP/actualizar.php" method="POST" enctype="multipart/form-data">
            <div class="profilebtn">

                <input type="file" name="profile" id="img" accept="image/*">
            </div>
            <label for="img" id="cambiar"><i class="far fa-edit"></i>Cambiar foto</label>
            <div class="casillas">
                <input type="text" name="documento" id="documento" value="<?php echo $_SESSION['documento']; ?>"
                    readonly>
                <input name="nuevo_usuario" type="text" placeholder="Nuevo usuario"
                    value="<?php echo $_SESSION['nombre_usuario']; ?>">
                
                <input name="nuevo_correo" type="email" placeholder="Correo"
                    value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                
                <input name="nueva_contraseña" type="password" placeholder="Nueva contraseña">
            </div>
            <input id="Listo" type="submit" value="Listo">
        </form>
    </div>
    <!-----------------------REGISTRAR INSTRUCTORES---------------------------------->
    <div id="forminst" style="display: none;">


        <div class="forminst">
            <form action="PHP/instructores.php" method="POST">
                <span onclick="ocultar5();" class="closebtn">&times;</span>
                <h2 style="margin-top: 10px;">Registrar instructores</h2>
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
    <!------------------------------TABLA INSTRUCTORES------------------------------->
    <div class="container-fluid">
        <div class="tabla1 d-grid gap-1 container" id="tabla2">
            <div class="table table-striped table-hover">
                <div class="tabla-scroll">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nombre completo</th>
                                <th scope="col">Documento</th>
                                <th scope="col">Correo electronico</th>
                                <th scope="col">Tefefono</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha de registro</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                include 'PHP/Conexion.php';
                                $sql = "SELECT * FROM instructores WHERE Estado_funcionario = 'Activo' ORDER BY fecha_registro DESC";
                                $resultado = mysqli_query($conexion, $sql);
                                if ($resultado) {
                                    while ($row = mysqli_fetch_assoc($resultado)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['Nombre_completo']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['numero_documento']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Estado_funcionario']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['fecha_registro']) . "</td>";
                                        echo "<td> 
                                                    <div class='botones'>
                                                    <button class='delete' onclick=\"abrirDialog('fila_detalles_" . $row['id_instructor'] . "')\"><ion-icon name='ban-outline'></ion-icon></button>
                                                    </div>
                                                </td>";
                                        echo "</tr>";
                                        echo "<dialog class='formulario' id='fila_detalles_" . $row["id_instructor"] . "'>
                                                <span class='closebtn' onclick='cerrarDialog(\"fila_detalles_" . $row["id_instructor"] . "\")'>&times;</span>
                                                <h2>Detalles del instructor</h2>
                                                <form action='PHP/eliminarInstructores.php' method='POST'>
                                                <input type='text' name='nombre' value='" . $row['Nombre_completo'] . "'readonly>
                                                <br>
                                                <br>
                                                <input type='text' name='cedula' value='" . $row['numero_documento'] . "'readonly>
                                                <br>
                                                <br>
                                                <button type='Submit' style='color: white;'>Eliminar</button>
                                                </form>
                                            </dialog>";
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>
    <!------------------------------------------------------------------------------------------>

    <script>
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }

        // Función para mostrar la notificación
        function mostrarNotificacion(titulo, cuerpo) {
            if (Notification.permission === "granted") {
                new Notification(titulo, {
                    body: cuerpo,
                    icon: 'icono.png' // Opcional: poner el ícono de tu sistema
                });
            }
        }

        // Llamada periódica para chequear préstamos
        setInterval(() => {
            fetch('PHP/Verificar_prestamo.php')
                .then(response => response.json())
                .then(data => {
                    if (data.retrasados.length > 0) {
                        mostrarNotificacion('¡Préstamo retrasado!', 'El prestamo con ID ' + data.retrasados[0].id_prestamo + ' está retrasado.');
                    }
                });
        }, 60000); // cada 1 minuto
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('.dropmenu-toggle');
            const menuList = document.querySelector('.menu ul');

            toggle.addEventListener('click', () => {
                menuList.classList.toggle('show');
            });
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
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>