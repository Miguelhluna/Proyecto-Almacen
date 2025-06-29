<?php
session_start();

if (!isset($_SESSION['documento'])) {
    header("Location: index.php");
    exit();
}
if (isset($_SESSION['rol'])) {
    $rolUsuario = $_SESSION['rol'];
} else {
    $rolUsuario = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Almacen Sena</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
<<<<<<< HEAD

=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
    <!-- ✅ jQuery (debe ir antes de cualquier plugin que lo use) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <!-- ✅ DataTables desde Cloudflare (más confiable) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <!-- ✅ JS desde Cloudflare (reemplaza el CDN anterior que fallaba) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <!-- Librerías para exportar (Excel y PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<<<<<<< HEAD
    <div class="contenedor_loader">
        <div class="loader"></div>
    </div>

=======
    </div>
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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
    <?php include 'PHP/Navbar.php'; ?>
<<<<<<< HEAD
=======

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
                <input name="nuevo_usuario" type="email" placeholder="Nuevo usuario"
                    value="<?php echo $_SESSION['nombre_usuario']; ?>">

                <input name="nuevo_correo" type="text" placeholder="Correo"
                    value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">

                <input name="nueva_contraseña" type="password" placeholder="Nueva contraseña">

            </div>
            <input id="Listo" type="submit" value="Listo">
        </form>
    </div>


>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
    <!-- Botón para abrir el modal -->
    <button class="register1" id="btnprestamos" onclick="mostrarprestamosequipos();">
        <ion-icon name="add-circle-outline"></ion-icon> Prestamos equipos
    </button>
    <!------------------------------FORMULARIO PRESTAMOS--------------------------------------->
    <div id="equipos">
        <dialog id="formularioprestamosE" class="forminst scrollable-dialog" style="display: none;">
            <span class="closebtn" onclick="ocultarprestamosequipos();">&times;</span>
            <h2>Préstamo Equipos</h2>
            <form action="PHP/prestamo_equipos.php" method="post">
                <label for="">Cantidad a prestar</label>
                <input type="number" name="cantidad" id="cantidad" required min="1" placeholder="Cantidad a prestar"
                    input="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">

                <div id="inputs-dinamicos">
                </div>

                <label for="responsable">Responsable</label>
                <select name="responsable" id="responsable" required>
                    <option value="" disabled selected>Selecciona un responsable</option>
                    <?php
                    include 'PHP/Conexion.php';
                    $query = "SELECT id_usuario, Nombre_completo FROM usuarios WHERE estado_funcionario = 'Activo' AND Rol = 'Instructor'";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $nombre = htmlspecialchars($row['Nombre_completo']);
                        $id_usuario = htmlspecialchars($row['id_usuario']);
                        echo "<option value='$nombre'>$nombre</option>";
                    }
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

    <div class="tabla1 container">
        <table id="tableEquipo" class="display nowrap table-funcionarios" style="width:100%">
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
<<<<<<< HEAD
                    echo "<tr><form action='PHP/devoluciones.php' method='POST'>";
=======
                    echo "<tr> <form action='PHP/devoluciones.php' method='POST'>";
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                    echo "<td><input class='novedad' type='text' name='id_prestamo' value='" . $row['id_prestamo'] . "'readonly></td>";
                    echo "<td>" . $row['responsable'] . "</td>";
                    echo "<td>" . $row['fecha_prestamo'] . "</td>";
                    echo "<td>" . $row['estado_prestamo'] . "</td>";
                    echo "<td>" . $row['cantidad_total'] . "</td>";
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
<<<<<<< HEAD

                    echo "<dialog class='formulario ' id='fila_detalles_" . $row["id_prestamo"] . "'>
                            <span id='closebtn' onclick='cerrarDialog(\"fila_detalles_" . $row["id_prestamo"] . "\")'>&times;</span>
                                    <span  id='contenido_detalles_" . $row["id_prestamo"] . "'>
                                    
=======
                    echo "<dialog class='formulario' id='fila_detalles_" . $row["id_prestamo"] . "'>
                            <span id='closebtn' onclick='cerrarDialog(\"fila_detalles_" . $row["id_prestamo"] . "\")'>&times;</span>
                                    <span id='contenido_detalles_" . $row["id_prestamo"] . "'>
                                    
                                        <!-- Aquí se mostrará la tabla de id_equipo -->
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                                    </span>
                                </dialog>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <!---------------------FORMULARIO DEVOLUCIONES----------------------------->

    <!--------------------- BOTON DE MATERIALES ----------------------------->
    <button id="register" onclick="mostrarprestamomateriales();">
        <ion-icon name="add-circle-outline"></ion-icon> Prestamos materiales
    </button>
    <!--------------------------FORMULARIO MATERIALES------------------------->
    <div id="equipos">
<<<<<<< HEAD
        <dialog id="formulariomateriales" class="forminst scrollable-dialog" style="display: none;">
=======
        <dialog id="formulariomateriales" class="forminst" style="display: none;">
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            <span class="closebtn" onclick="ocultarprestamosmateriales();">&times;</span>
            <h2>Préstamo de Materiales</h2>
            <form action="PHP/prestamo_materiales.php" method="post">
                <?php
                include_once 'PHP/Conexion.php';

                $query = "SELECT id_material, Descripción FROM materiales";
                $resultMateriales = mysqli_query($conexion, $query);

                $query2 = "SELECT * FROM usuarios WHERE rol = 'Instructor' AND estado_funcionario = 'Activo'";
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

        <div class="tabla1 container">


            <table id="tableMaterial" class="display nowrap table-funcionarios" style="width:100%">
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
<<<<<<< HEAD
                        echo "<tr><form action='PHP/devolucionesMateriales.php' method='POST'>";
                        echo "<td><input class='novedad' type='text' name='id_prestamoMaterial' value='" . $row['id_prestamoM'] . "'readonly></td>";
=======
                        echo "<tr>";
                        echo "<td>" . $row['id_prestamoM'] . "</td>";
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                        echo "<td>" . $row['Descripción'] . "</td>";
                        echo "<td>" . $row['estado_prestamo'] . "</td>";
                        echo "<td>" . $row['Responsable'] . "</td>";
                        echo "<td>" . $row['fecha_prestamo'] . "</td>";
                        echo "<td>" . $row['cantidad'] . "</td>";
<<<<<<< HEAD
                        echo "<td><div class='botones'>
                                <button type='submit' class='refresh' title= 'Actualizar'><ion-icon name='refresh-outline'></ion-icon></button>
                                </div></td>";
                        echo "</form></tr>";
=======
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
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>

    <!-- JS -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        echo "<script>
        Swal.fire({
            icon: '{$mensaje['tipo']}',
            title: '{$mensaje['titulo']}',
            text: '{$mensaje['texto']}'
        });
    </script>";
        unset($_SESSION['mensaje']); // para que no se repita
    }
    ?>
    <script>
<<<<<<< HEAD
        $(document).ready(function () {
=======
        $(document).ready(function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            // Aplica select2 a todos los campos necesarios
            ['#responsable', '#responsable2', '#materiales'].forEach(id => {
                $(id).select2({
                    theme: 'bootstrap-5',
                    allowClear: false,
                    scrollAfterSelect: true
                });
            });
        });

        // Inputs dinámicos según la cantidad
<<<<<<< HEAD
        document.getElementById('cantidad').addEventListener('input', function () {
=======
        document.getElementById('cantidad').addEventListener('input', function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            const cantidad = parseInt(this.value);
            const contenedor = document.getElementById('inputs-dinamicos');
            contenedor.innerHTML = '';

            if (!isNaN(cantidad) && cantidad > 0) {
                for (let i = 1; i <= cantidad; i++) {
                    const label = document.createElement('label');
                    label.textContent = 'ID del equipo #' + i + ':';

                    const input = document.createElement('input');
                    input.type = 'number';
                    input.name = 'id_equipo[]';
                    input.required = true;
                    input.placeholder = 'Ej: 101';
                    input.className = 'form-control mb-2';

                    contenedor.appendChild(label);
                    contenedor.appendChild(input);
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
<<<<<<< HEAD
            xhr.onload = function () {
=======
            xhr.onload = function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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

<<<<<<< HEAD
            xhr.onload = function () {
=======
            xhr.onload = function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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
<<<<<<< HEAD
        document.getElementById("search").addEventListener("keyup", function () {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function (fila) {
=======
        document.getElementById("search").addEventListener("keyup", function() {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function(fila) {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                let texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(valor) ? "" : "none";
            });
        });
    </script>
    <script>
<<<<<<< HEAD
        document.getElementById("search2").addEventListener("keyup", function () {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function (fila) {
=======
        document.getElementById("search2").addEventListener("keyup", function() {
            var valor = this.value.toLowerCase();
            var filas = document.querySelectorAll("#table tbody tr");

            filas.forEach(function(fila) {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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
<<<<<<< HEAD
        document.addEventListener('DOMContentLoaded', function () {
=======
        document.addEventListener('DOMContentLoaded', function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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
    <!-- Select2 CSS y JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['mensaje']['tipo'] ?>', // success | error | warning | info
                title: '<?= $_SESSION['mensaje']['titulo'] ?>',
                text: '<?= $_SESSION['mensaje']['texto'] ?>',
                background: '#f9f9f9',
                color: '#333',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Entendido',
                customClass: {
                    popup: 'mi-popup',
                    title: 'mi-titulo',
                    confirmButton: 'mi-boton-confirmar'
                }
            });
        </script>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <script>
<<<<<<< HEAD
        $(document).ready(function () {
=======
        $(document).ready(function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            $('#tableEquipo').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [5, 10, 25, -1],
                    [5, 10, 25, 'Todos']
                ],
                responsive: true,
                buttons: [{
<<<<<<< HEAD
                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                    title: 'Lista de equipos prestados',
                    className: 'btn btn-success'
                },

=======
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                        title: 'Lista de equipos prestados',
                        className: 'btn btn-success'
                    },
                  
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });
    </script>
    <script>
<<<<<<< HEAD
        $(document).ready(function () {
=======
        $(document).ready(function() {
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
            $('#tableMaterial').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [5, 10, 25, -1],
                    [5, 10, 25, 'Todos']
                ],
                responsive: true,
                buttons: [{
<<<<<<< HEAD
                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                    title: 'Lista de materiales prestados',
                    className: 'btn btn-success'
                },
=======
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                        title: 'Lista de materiales prestados',
                        className: 'btn btn-success'
                    },
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f

                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });
    </script>

</body>

</html>