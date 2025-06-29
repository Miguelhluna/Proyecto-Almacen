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

    <!-- ✅ jQuery (debe ir antes de cualquier plugin que lo use) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</head>



<body>
    <!-- <div class="contenedor_loader">
        <div class="loader"></div>
    </div> -->

    <header>
        <div class="sena">
            <img class="sena" src="img/image.png" alt="SENA" title="SENA">

        </div>
        <h1 class="tittle">Gestión de prestamos</h1>
        <p class="p2">CTGI</p>
    </header>

    <!---------------------------------------MENU------------------------------->
    <?php
    $tutorialMenu = true; // Aquí activas el paso del menú
    include 'PHP/Navbar.php';   // Incluyes el menú que usará esta variable
    ?>
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
        <!--------------------- novedad de equipos------------------------ -->

        <div id="mostrarnovedad" class="regis-nov " style="display: none; width: 40rem; ">

            <form action="PHP/novedad_equipos.php" method="POST" enctype="multipart/form-data">
                <span class="closebtn" onclick="ocultarnovedades();">&times;</span>
                <h2>Registrar Novedad</h2>
                <div class="form-group">
                    <label for="">Serial</label>
                    <input type="text" class="form-control" name="serial_equipo" id="id_equipo2" readonly required>
                </div>
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
                <label for="foto" class="fotonovedad">Archivo:</label>
                <input style="display: none;" type="file" name="prueba" id="foto" accept="image/*">


                <input type="submit" value="Registrar Novedad" id="cerrar-listo">
            </form>
            <button class="vertablabtn" onclick="mostrarTablaNovedades();">
                <ion-icon name="eye-outline"></ion-icon>
                Tabla
            </button>
            <div style="margin-top: 1rem; display: none;" id="detallesNovedades" class="scrollable-dialog">
                <table id="tablaNovedades" class="display wrap table-funcionarios" style="width:60%">
                    <thead>
                        <tr>
                            <th scope="col">Reporte</th>
                            <th scope="col">Equipo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de novedad</th>
                            <th scope="col">Archivos</th>
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
                            echo '<td><img src="PHP/' . htmlspecialchars($row['prueba']) . '" alt="Foto de novedad"  class="foto-redonda imagen-modal"></td>';
                            echo "<td><button class='edit' title='Resolver' onclick='mostrarnovedad(" . $row['id_novedad'] . ")'><ion-icon name='checkmark-circle-outline'></ion-icon></button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div id="modalImagen" class="modal-imagen">
                    <span class="cerrar" id="cerrarModal">&times;</span>
                    <img class="modal-contenido" id="imagenAmpliada">
                </div>
            </div>
        </div>
        <!----------------------REGISTRO DE MATERIALES--------------------------------->
        <div>
            <button id="register" type="button" onclick="mostrarmaterial();">
                <ion-icon name="add-circle-outline"></ion-icon> Registrar materiales
            </button>
        </div>
        <div id="material">
            <div id="mostrarmaterial" class="forminst" style="display: none;">

                <form action="PHP/materiales.php" method="POST">
                    <span id="cerrarmateriales" onclick="ocultarmaterial();">&times;</span>
                    <h2>Registrar material</h2>
                    <div class="form-group">
                        <label for="">Código</label>
                        <input type="text" name="id_material" id="id_material" class="form-control">
                    </div>
                    <div>
                        <label for="">Tipo de material</label>
                        <select name="tipo_material" id="estado" onfocus="this.size=2;" onblur="this.size=0;"
                            onchange="this.size=1; this.blur();">
                            <?php
                            $options4 = ['Consumible', 'No consumible'];
                            $default_value = "Consumible"; // Valor por defecto
                            foreach ($options4 as $option4) {
                                $selected = ($option4 === $default_value) ? "selected" : "";
                                echo "<option value='$option4' $selected>$option4</option>";
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
                            <input type="text" name="cantidad" id="cantidad" class="form-control" value="1" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Listo" id="cerrar-listo">
                        </div>
                </form>
            </div>

        </div>
        <!--------------------------------------TABLA DE MATERIALES-------------------------------------------->
        <div class="tabla1 container">
            <table id="tablaMateriales" class="display nowrap table-funcionarios" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre del material</th>
                        <th scope="col">Tipo articulo</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Fecha de registro</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'PHP/Conexion.php';
                    $query = "SELECT * FROM materiales ORDER BY fecha_registro DESC";
                    $result = mysqli_query($conexion, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id_material'];
                        $descripcion = addslashes($row['Descripción']); // Escapar comillas
                        $tipo = addslashes($row['Tipo_Material']);
                        $stock = addslashes($row['Stock']);

                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>{$row['Descripción']}</td>";
                        echo "<td>{$row['Tipo_Material']}</td>";
                        echo "<td>{$row['Stock']}</td>";
                        echo "<td>{$row['fecha_registro']}</td>";
                        echo "<td>
                            <div class='botones'>
                                <button class='edit' title='Actualizar' onclick=\"actualizarmaterial('$id', '$descripcion', '$tipo', '$stock')\">
                                    <ion-icon name='create-outline'></ion-icon>
                                </button>
                            </div>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <div id="devolverMaterial" class="modal-backdrop">
            <div class="modal actualizarmaterial">
                <span class="close-btn" onclick="cerrardevolverlMaterial();">&times;</span>

                <h2>Actualizar material</h2>
                <form action="PHP/actualizarMaterial.php" method="POST">
                    <input type="hidden" id="id_materialActualizado" name="id_materialActualizado"
                        placeholder="ID del material" readonly>
                    <input type="text" id="descripcion_materialActualizado" name="descripcion_materialActualizado"
                        placeholder="Descripción del material">
                    <input type="text" id="cantidad_materialActualizado" name="cantidad_materialActualizado"
                        placeholder="Cantidad del material">

                    <select name="tipo_materialActualizado" id="tipo_materialActualizado">
                        <?php
                        $options4 = ['Consumible', 'No Consumible'];
                        foreach ($options4 as $option4) {
                            echo "<option value='$option4'>$option4</option>";
                        }
                        ?>
                    </select>
                    <div>
                        <button type="submit" class="btn-editar">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        <footer>
            <p>&copy; 2025 Todos los derechos reservados</p>
        </footer>
        <script src="js/script.js"></script>

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
            window.mostrarTablaNovedades = function () {
                document.getElementById("detallesNovedades").style.display = "block";
            };
        </script>

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
            document.addEventListener('DOMContentLoaded', function () {
                const toggle = document.querySelector('.dropmenu-toggle');
                const menuList = document.querySelector('.menu ul');

                toggle.addEventListener('click', () => {
                    menuList.classList.toggle('show');
                });
            });
        </script>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <!-- Select2 CSS y JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
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
            $(document).ready(function () {
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
            $(document).ready(function () {
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
        <script>
            function mostrarImagenModal(src) {
                const modal = document.getElementById('modalImagen');
                const imagenAmpliada = document.getElementById('imagenAmpliada');
                imagenAmpliada.src = src;
                modal.style.display = 'block';
            }

            function cerrarModalImagen() {
                document.getElementById('modalImagen').style.display = 'none';
            }
        </script>
</body>

</html>