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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Almacen Sena</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <!-- ✅ Tu script personalizado (debe ir al final) -->

</head>



<body>
    <div class="contenedor_loader">
        <div class="loader"></div>
    </div>

    <header>
        <div class="sena">
            <img class="sena" src="img/image.png" alt="SENA" title="SENA">

        </div>
        <h1 class="tittle">Gestión de prestamos</h1>
        <p class="p2">CTGI</p>
    </header>

    <!---------------------------------------MENU------------------------------->
    <?php include 'PHP/Navbar.php'; ?>
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
            <button id="Listo" type="submit" value="Listo"> Listo</button>
        </form>
    </div>


    <!-----------------------------FORMULARIO REGISTRO DE EQUIPOS------------------------->
    <button class="btnequipos " id="btnequiposregis" onclick="mostrarequiposregis();">
        <ion-icon name="add-circle-outline"></ion-icon>Registro de equipos
    </button>
    <div id="equipos" style="display: none;">
        <div class="forminst">
            <span class="closebtn" onclick="ocultarequiposregis();">&times;</span>
            <h2>Registrar Equipos</h2>
            <form id="formularioEquipo" action="PHP/equipos.php" method="POST">
                <label for="">Serial</label>
                <input type="text" id="serial" name="serial" required>

                <label for="">Marca</label>
                <input type="text" id="Marca" name="marca" required>

                <label for="">Estado</label>
                <select name="estado" id="estado" required onfocus="this.size=4;" onblur="this.size=0;"
                    onchange="1; this.blur()">
                    <?php
                    include 'PHP/Conexion.php';
                    $querystatus = "SHOW COLUMNS FROM equipos LIKE 'Estado'";
                    $result4 = mysqli_query($conexion, $querystatus);
                    $row4 = mysqli_fetch_assoc($result4);
                    $enum_values = str_replace("'", "", substr($row4['Type'], 5, -1));
                    $options4 = explode(",", $enum_values);
                    foreach ($options4 as $option4) {
                        echo "<option value='$option4'>$option4</option>";
                    }
                    ?>
                </select>

                <button type="submit">Registrar</button>
            </form>
        </div>
    </div>
    <!--------------------- novedad de equipos------------------------ -->

    <div id="mostrarnovedad" class="regis-nov scrollable-dialog" style="display: none; width: 40rem; ">
        <span class="closebtn" onclick="ocultarnovedades();">&times;</span>
        <h2>Registrar Novedad</h2>
        <form action="PHP/novedad_equipos.php" method="POST" enctype="multipart/form-data">
            <label for="">Serial</label>
            <input type="text" class="form-control" name="serial_equipo" id="id_equipo2" readonly>

            <label for="">Marca</label>
            <input type="text" name="marca" id="marca" class="form-control" readonly>
            <label for="">Estado</label>
            <select name="estado_novedad" id="estado_novedad" class="form-control">
                <?php
                include_once 'PHP/Conexion.php';
                $querystatus = "SHOW COLUMNS FROM novedad_equipos LIKE 'estado_novedad'";
                $result4 = mysqli_query($conexion, $querystatus);
                $row4 = mysqli_fetch_assoc($result4);
                $enum_values = str_replace("'", "", substr($row4['Type'], 5, -1));
                $options4 = explode(",", $enum_values);
                foreach ($options4 as $option4) {
                    echo "<option value='$option4'>$option4</option>";
                }
                ?>

            </select>
            <label for="">Tipo de Novedad:</label>
            <select name="tipo_novedad" id="tipo_novedad" class="form-control" required>
                <?php
                $querystatus = "SHOW COLUMNS FROM novedad_equipos LIKE 'tipo_novedad'";
                $result4 = mysqli_query($conexion, $querystatus);
                $row4 = mysqli_fetch_assoc($result4);
                $enum_values = str_replace("'", "", substr($row4['Type'], 5, -1));
                $options4 = explode(",", $enum_values);
                foreach ($options4 as $option4) {
                    echo "<option value='$option4'>$option4</option>";
                }
                ?>
            </select>
            <label for="">Descripción de la Novedad:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4"
                placeholder="Descripción breve..." required></textarea>
            <input type="file" name="prueba" id="foto" accept="image/*">


            <input type="submit" value="Registrar Novedad" id="cerrar-listo">
        </form>
        <button class="vertablabtn" onclick="mostrarTablaNovedades();">
            <ion-icon name="eye-outline"></ion-icon>
            Tabla
        </button>
        <div style="margin-top: 2rem; display: none;" id="detallesNovedades" class="scrollable-dialog">
            <table id="tablaNovedades" class="display wrap table-funcionarios" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Reporte</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha de novedad</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="novedadesTableBody">
                    <?php
                    include 'PHP/Conexion.php';
                    $query = "SELECT * FROM novedad_equipos ORDER BY fecha_novedad DESC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<form action='PHP/novedad_equipos2.php' method='POST'>";
                        echo "<td><input class='novedad' type='text' name='novedad' value='" . $row['id_novedad'] . "' readonly></td>";
                        echo "<td class='descripcion-celda-equipo'>" . $row['id_equipo'] . "</td>";
                        echo "<td>" . $row['tipo_novedad'] . "</td>";
                        echo "<td>" . $row['estado_novedad'] . "</td>";
                        echo "<td class='descripcion-celda' title='" . htmlspecialchars($row['descripcion']) . "'>" . htmlspecialchars($row['descripcion']) . "</td>";
                        echo "<td>" . $row['fecha_novedad'] . "</td>";
                        echo "<td><button class='edit' title='Resolver' onclick='mostrarnovedad(" .
                            $row['id_novedad'] . ")'><ion-icon name='checkmark-circle-outline'></ion-icon></button></td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>


    <!-------------------------------Resolver novedad equipos-------------------------------------------->




    <!-------------------tabla registro de equipos --------------------------->
    <div>
        <div class="tabla1 container">
            <table id="tablaEquipos" class="display nowrap table-funcionarios" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha de registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'PHP/Conexion.php';
                    $query = "SELECT * FROM equipos ORDER BY fecha_registro DESC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<form action='PHP/inhabilitar_equipos.php' method='POST'>";
                        echo "<td><input class='novedad' type='text' name='novedad' value='" . $row['id_equipo'] . "' readonly></td>";
                        echo "<td>" . $row['marca'] . "</td>";
                        echo "<td>" . $row['Estado'] . "</td>";
                        echo "<td>" . $row['fecha_registro'] . "</td>";
                        echo "<td><div class='botones'>
                                    <button type='button' class='edit' title='Novedades' onclick='mostrarnovedades(" . $row['id_equipo'] . ", \"" . $row['marca'] . "\", \"" . $row['Estado'] . "\")'><ion-icon name='alert-circle-outline'></ion-icon></button>
                                    <button type='submit' class='delete' title= 'Eliminar'><ion-icon name='trash-outline'></ion-icon></button>
                                    </div>";
                        echo "</td>";

                        echo "</form>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!----------------------REGISTRO DE MATERIALES--------------------------------->
        <div class="d-grid gap-1">
            <button id="register" type="button" onclick="mostrarmaterial();">
                <ion-icon name="add-circle-outline"></ion-icon> Registrar materiales
            </button>
        </div>
        <div id="material">
            <div id="mostrarmaterial" class="forminst" style="display: none;">
                <span id="cerrarmateriales" onclick="ocultarmaterial();">&times;</span>
                <h2>Registrar material</h2>
                <form action="PHP/materiales.php" method="POST">
                    <div class="form-group">
                        <label for="">Id material:</label>
                        <input type="text" name="id_material" id="id_material" class="form-control">
                    </div>
                    <div>
                        <label for="">Tipo de material</label>
                        <select name="tipo_material" id="estado" onfocus="this.size=2;" onblur="this.size=0;"
                            onchange="this.size=1; this.blur();">
                            <?php
                            include 'PHP/Conexion.php';
                            $querystatus = "SHOW COLUMNS FROM materiales LIKE 'Tipo_Material'";
                            $result4 = mysqli_query($conexion, $querystatus);
                            $row4 = mysqli_fetch_assoc($result4);
                            $enum_values = str_replace("'", "", substr($row4['Type'], 5, -1));
                            $options4 = explode(",", $enum_values);
                            foreach ($options4 as $option4) {
                                echo "<option value='$option4'>$option4</option>";
                            }
                            ?>
                        </select>
                        <div class="form-group">
                            <label for="">Nombre del material</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" rows="4"
                                required></input>
                        </div>
                        <div class="form-group">
                            <label for="">Cantidad</label>
                            <input type="text" name="cantidad" id="cantidad" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Listo" id="cerrar-listo">
                        </div>
                </form>
            </div>
        </div>
        <!--------------------------------------TABLA DE MATERIALES-------------------------------------------->
        <div class="tabla1 container">
            <table id="tablaMateriales" class="display table-funcionarios" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del material</th>
                        <th scope="col">Tipo articulo</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Fecha de registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'PHP/Conexion.php';
                    $query = "SELECT * FROM materiales ORDER BY fecha_registro DESC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_material'] . "</td>";
                        echo "<td>" . $row['Descripción'] . "</td>";
                        echo "<td>" . $row['Tipo_Material'] . "</td>";
                        echo "<td>" . $row['Stock'] . "</td>";
                        echo "<td>" . $row['fecha_registro'] . "</td>";
                        echo "<td><div class='botones'>
                                <button class='refresh' title= 'Actualizar'><ion-icon name='refresh-outline'></ion-icon></button>
                                <button class='delete' title= 'Eliminar'><ion-icon name='trash-outline'></ion-icon></button>
                                </div></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <footer>
            <p>&copy; 2025 Todos los derechos reservados</p>
        </footer>

        <!-- Notificaciones del sweetalert2 al registrar una novedad, un equipo o un material -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php if (isset($_SESSION['mensaje'])): ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['mensaje']['tipo']; ?>', // success | error | warning | info | question
                    title: '<?php echo $_SESSION['mensaje']['titulo']; ?>',
                    text: '<?php echo $_SESSION['mensaje']['texto']; ?>',
                    background: '#f9f9f9',
                    color: '#333',
                    confirmButtonColor: '#28a745',
                    confirmButtonText: 'Aceptar',
                });
            </script>

            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>



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
            // Muestra y llena el Input del formulario de devoluciones automáticamente
            function mostrarnovedad(idNovedad) {
                document.getElementById('devolverNovedad').style.display = 'block';
                document.getElementById('inputIdNovedad').value = idNovedad;
            }

            // Mostrar detalles de una novedad en un diálogo
            function mostrarDetalles(idNovedad) {
                const dialog = document.getElementById('fila_detalles_' + idNovedad);
                const contenido = document.getElementById('contenido_detalles_' + idNovedad);
                if (dialog) {
                    dialog.showModal();
                }
            }
            // Ocultar el diálogo
            function cerrarDialog(dialogId) {
                const dialog = document.getElementById(dialogId);
                if (dialog) {
                    dialog.close();
                }
            }
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
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <!-- Select2 CSS y JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="js/script.js"></script>
        <script>
            $(document).ready(function() {
                $('#tablaEquipos').DataTable({
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [5, 10, 25, -1],
                        [5, 10, 25, 'Todos']
                    ],
                    responsive: true,
                    buttons: [{
                            extend: 'excel',
                            text: 'Exportar a Excel',
                            title: 'Lista de funcionarios',

                        },

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
                        buttons: {
                            excel: 'Exportar a Excel',
                        }
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#tablaMateriales').DataTable({
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [5, 10, 25, -1],
                        [5, 10, 25, 'Todos']
                    ],
                    responsive: true,
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Exportar a Excel',
                            title: 'Lista de funcionarios'
                        },

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
                        buttons: {
                            excel: 'Exportar a Excel',

                        }
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#tablaNovedades').DataTable({
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [5, 10, 25, -1],
                        [5, 10, 25, 'Todos']
                    ],
                    responsive: true,
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        title: 'Lista de funcionarios'
                    }],
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
                        buttons: {
                            excel: 'Exportar a Excel',

                        }
                    }
                });
            });
        </script>
</body>

</html>