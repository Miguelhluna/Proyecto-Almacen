<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['documento'])) {
    // Redirigir al login si no está autenticado
    header("Location: login.php");
    exit();
}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="CSS/styles.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
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
            <h2 class="tittle">Prestamos</h2>
            <p class="p2">CTGI</p>
        </header>
    </div>
    <!-----------------------MENU------------------------------------->
    <nav class="menu">
        <button class="dropmenu-toggle">&#9776;</button>
        <ul>
            <li><a href="inventario.php">Inicio</a></li>
            <li><a href="prestamos.php">Préstamo</a></li>
            <li><a href="instructores.php"><button id="inst" onclick="mostrar5();">Registrar instructores </button></a>
            </li>
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


    <!-- Botón para abrir el modal -->
    <button class="register1" id="btnprestamos" onclick="mostrar2();">
        <ion-icon name="add-circle-outline"></ion-icon> Prestamos equipos
    </button>
    <!------------------------------FORMULARIO PRESTAMOS--------------------------------------->
    <div id="equipos">
        <dialog id="formularioprestamosE" class="forminst scrollable-dialog" style="display: none;">
            <span class="closebtn" onclick="ocultar2();">&times;</span>
            <h2>Préstamo Equipos</h2>
            <form action="PHP/prestamo_equipos.php" method="post">
                <label for="">Cantidad a prestar</label>
                <input type="number" name="cantidad" id="cantidad" required min="1" placeholder="Cantidad a prestar"
                    input="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">

                <div id="inputs-dinamicos">
                    <label for="">ID equipo</label>
                    <input type="text" name="id_equipo[]" id="">
                </div>

                <label for="">Responsable</label>
                <select name="responsable" id="responsable">
                    <?php
                    include 'PHP/Conexion.php';
                    $query = "SELECT Nombre_completo FROM instructores WHERE estado_funcionario = 'Activo'";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['Nombre_completo']) . "'>" . htmlspecialchars($row['Nombre_completo']) . "</option>";
                    }
                    ;
                    ?>
                </select>

                <label for="">Estado del préstamo</label>
                <select name="estado_prestamo" id="estado_prestamo" onfocus="this.size=3;" onblur="this.size=0;"
                    onchange="1; this.blur();">
                    <?php
                    $options4 = ['Prestado', 'Devuelto', 'Pendiente'];
                    $default_value = "Prestado";
                    foreach ($options4 as $option4) {
                        $selected = ($option4 === $default_value) ? "selected" : "";
                        echo "<option value='$option4' $selected>$option4</option>";
                    }
                    ?>
                </select>

                <button type="submit" class="final">Registrar</button>
            </form>
        </dialog>
    </div>
    <!------------------------------------------------TABLA PRESTAMOS EQUIPOS------------------------------------>

    <div class="tabla1 d-grid gap-1 container">
        <div class="table table-striped table-hover">
            <div class="tabla-scroll">
                <input type="text" id="buscador" placeholder="Buscar en la tabla..." class="form-control mb-3"
                    style="width: 20rem;">
                <table id="table" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id Prestamo</th>
                            <th scope="col">Responsable</th>
                            <th scope="col">Fecha de prestamo</th>
                            <th scope="col">Estado del prestamo</th>
                            <th scope="col">Cantidad prestada</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'PHP/Conexion.php';
                        $query = "SELECT d.id_prestamo, p.cantidad AS cantidad_total,  p.responsable,  p.fecha_prestamo, d.estado_prestamo  
                        FROM detalle_prestamo_equipos d 
                        JOIN prestamos_equipos p ON d.id_prestamo = p.id_prestamo  
                        GROUP BY d.id_prestamo 
                        ORDER BY fecha_prestamo DESC;";

                        $result = mysqli_query($conexion, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr> <form action='PHP/devoluciones.php' method='POST'>";
                            echo "<td><input class='novedad' type='text' name='id_prestamo' value='" . $row['id_prestamo'] . "'readonly></td>";
                            echo "<td><input class='Equipo' type='text' value='" . $row['responsable'] . "'readonly></td>";
                            echo "<td><input class='fecha'type='text' value='" . $row['fecha_prestamo'] . "'readonly></td>";
                            echo "<td><input class='estado' type='text' value='" . $row['estado_prestamo'] . "'readonly></td>";
                            echo "<td><input class ='novedad' type='text' value='" . $row['cantidad_total'] . "'readonly></td>";
                            echo "<td>
                                        <div class='botones'>
                                            <button type='submit' class='refresh' title='Devolver' onclick='mostrarFormulario(" . $row["id_prestamo"] . "); return false;' name='verDevolucion'>
                                                <ion-icon name='refresh-outline'></ion-icon>
                                            </button>
                                            <button class='edit' title='Ver detalles' onclick='mostrarDetalles(" . $row["id_prestamo"] . "); return false;' name='details'>
                                                <ion-icon name='information-circle-outline'></ion-icon>
                                            </button>
                                        </div>
                                        
                                    </td>";
                            echo "</form></tr>";
                            echo "<dialog class='formulario' id='fila_detalles_" . $row["id_prestamo"] . "'>
                            <span id='closebtn' onclick='cerrarDialog(\"fila_detalles_" . $row["id_prestamo"] . "\")'>&times;</span>
                                    <span id='contenido_detalles_" . $row["id_prestamo"] . "'>
                                    
                                        <!-- Aquí se mostrará la tabla de id_equipo -->
                                    </span>
                                </dialog>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!---------------------FORMULARIO DEVOLUCIONES----------------------------->

    <!--------------------- BOTON DE MATERIALES ----------------------------->
    <button id="register" onclick="mostrar3();">
        <ion-icon name="add-circle-outline"></ion-icon> Prestamos materiales
    </button>
    <!--------------------------FORMULARIO MATERIALES------------------------->
    <div id="equipos">
        <dialog id="formulariomateriales" class="forminst" style="display: none;">
            <span class="closebtn" onclick="ocultar3();">&times;</span>
            <h2>Préstamo de Materiales</h2>
            <form action="PHP/prestamo_materiales.php" method="post">
                <?php
                include_once 'PHP/Conexion.php';

                $query = "SELECT id_material, Descripción FROM materiales";
                $resultMateriales = mysqli_query($conexion, $query);

                $query2 = "SELECT id_instructor, Nombre_completo FROM instructores";
                $resultInstructores = mysqli_query($conexion, $query2);

                if (!$resultMateriales || !$resultInstructores) {
                    die("Error al cargar datos: " . mysqli_error($conexion));
                }
                ?>

                <label>ID material</label>
                <select name="id_material" id="materiales">
                    <?php while ($row = mysqli_fetch_assoc($resultMateriales)) {
                        echo "<option value='" . htmlspecialchars($row['id_material']) . "'>" . htmlspecialchars($row['Descripción']) . "</option>";
                    } ?>
                </select> <br><br>

                <label>Responsable</label>
                <select name="responsable2" id="responsable2">
                    <?php while ($row = mysqli_fetch_assoc($resultInstructores)) {
                        echo "<option value='" . htmlspecialchars($row['Nombre_completo']) . "'>" . htmlspecialchars($row['Nombre_completo']) . "</option>";
                    } ?>
                </select> <br><br>

                <label>Cantidad a prestar</label>
                <input type="number" name="cantidad" id="cantidad2" placeholder="Cantidad a prestar" min="1"
                    required><br><br>

                <button type="submit" class="ocultar">Registrar</button>
            </form>
        </dialog>

        <!----------------------------------------------TABLA MATERIALES-------------------------------------->

        <div class="tabla1 d-grid gap-1 container">
            <div class="table table-striped table-hover">
                <div class="border_table tabla-scroll">
                    <input type="text" id="buscador2" placeholder="Buscar en la tabla..." class="form-control mb-3"
                        style="width: 20rem;">
                    <table id="table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Id Prestamo</th>
                                <th scope="col">Material</th>
                                <th scope="col">Estado del prestamo</th>
                                <th scope="col">Responsable</th>
                                <th scope="col">Fecha de prestamo</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'PHP/Conexion.php';
                            $query = "SELECT * FROM prestamo_materiales INNER JOIN materiales ON prestamo_materiales.id_material = materiales.id_material ORDER BY fecha_prestamo DESC";
                            $result = mysqli_query($conexion, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_prestamoM'] . "</td>";
                                echo "<td>" . $row['Descripción'] . "</td>";
                                echo "<td>" . $row['estado_prestamo'] . "</td>";
                                echo "<td>" . $row['Responsable'] . "</td>";
                                echo "<td>" . $row['fecha_prestamo'] . "</td>";
                                echo "<td>" . $row['cantidad'] . "</td>";
                                echo "<td>
                                        <div class='botones'>
                                            <button class='refresh' title='Devolver return false;' name='verDevolucion'>
                                                <ion-icon name='refresh-outline'></ion-icon>
                                            </button>
                                            <button class='edit' title='Ver detalles' onclick='mostrarDetalles(" . $row["id_prestamoM"] . "); return false;' name='details'>
                                                <ion-icon name='information-circle-outline'></ion-icon>
                                            </button>
                                        </div>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>

    <!-- JS -->

    <script>
        $(document).ready(function () {
            $('#descripcion').select2({
                theme: 'bootstrap-5',
                placeholder: 'Selecciona una opción',
                allowClear: false,
                dropdownCssClass: "scrollable-dropdown"
            });
        });
        $(document).ready(function () {
            $('#responsable').select2({
                theme: 'bootstrap-5',
                placeholder: 'Selecciona una opción',
                allowClear: false,
                dropdownCssClass: "scrollable-dropdown"
            });
        });
        $(document).ready(function () {
            $('#responsable2').select2({
                theme: 'bootstrap-5',
                placeholder: 'Selecciona una opción',
                allowClear: false,
                dropdownCssClass: "scrollable-dropdown"
            });
        });
        $(document).ready(function () {
            $('#materiales').select2({
                theme: 'bootstrap-5',
                placeholder: 'Selecciona una opción',
                allowClear: false,
                dropdownCssClass: "scrollable-dropdown"
            });
        });
        document.getElementById('cantidad').addEventListener('input', function () {
            let cantidad = parseInt(this.value);
            let contenedor = document.getElementById('inputs-dinamicos');
            contenedor.innerHTML = '';

            if (!isNaN(cantidad) && cantidad > 0) {
                for (let i = 1; i <= cantidad; i++) {
                    let label = document.createElement('label');
                    label.textContent = 'ID del equipo #' + i + ':';

                    let input = document.createElement('input');
                    input.type = 'number';
                    input.name = 'id_equipo[]';
                    input.required = true;
                    input.placeholder = 'Ej: 101';

                    contenedor.appendChild(label);
                    contenedor.appendChild(document.createElement('br'));
                    contenedor.appendChild(input);
                    contenedor.appendChild(document.createElement('br'));
                }
            }
        });
    </script>
    <script>
        //Muestra y llena el Input del formulario de devoluciones de manera automática.
        function mostrarFormulario(idPrestamo) {
            // Mostrar el formulario
            document.getElementById('formularioDevolucion').style.display = 'block';
            document.getElementById('inputIdPrestamo').value = idPrestamo;
            // Llamar a PHP con AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "PHP/devoluciones.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (this.status == 200) {
                    document.getElementById("camposEquipos").innerHTML = this.responseText;
                }
            };
            xhr.send("id_prestamo=" + idPrestamo);
        };
    </script>
    <script>
        function mostrarDetalles(idPrestamo) {
            const dialog = document.getElementById('fila_detalles_' + idPrestamo);
            const contenido = document.getElementById('contenido_detalles_' + idPrestamo);

            // Mostrar el diálogo
            dialog.showModal();

            // Llamar al archivo PHP con AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "PHP/detalle_equipos.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    contenido.innerHTML = xhr.responseText;
                } else {
                    contenido.innerHTML = "Error al cargar los datos.";
                }
            };

            xhr.send("id_prestamo=" + idPrestamo);
        }

        function cerrarDialog(dialogId) {
            const dialog = document.getElementById(dialogId);
            dialog.close();
        }
    </script>
    <!-- Script para el buscador de las tablas -->
    <script>
        document.getElementById("buscador").addEventListener("keyup", function () {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function (fila) {
                let texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(valor) ? "" : "none";
            });
        });
    </script>
    <script>
        document.getElementById("buscador2").addEventListener("keyup", function () {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function (fila) {
                let texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(valor) ? "" : "none";
            });
        });
    </script>
    <script>
        // Pedir permiso de notificación cuando se carga la página
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
        document.addEventListener('DOMContentLoaded', function () {
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
    <script src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>