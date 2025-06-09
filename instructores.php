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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <!-- Librerías para exportar (Excel y PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    <?php include_once 'PHP/Navbar.php'; ?>

    <button id="inst" onclick="registrarinst();">Registrar instructores</button>
    <!-------------------------------POPOVER-------------------->
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
                <span onclick="ocultarregistrarinst();" class="closebtn">&times;</span>
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
    <div class="tabla2 container">
        <table id="tablaInstructores" class="table-funcionarios" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Nombre completo</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Correo electronico</th>
                    <th scope="col">Tefefono</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Fecha de registro</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'PHP/Conexion.php';
                $sql = "SELECT * FROM usuarios WHERE Rol = 'Instructor' ORDER BY fecha_Registro DESC";
                $resultado = mysqli_query($conexion, $sql);
                if ($resultado) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr><form action='PHP/eliminarInstructores.php' method='POST'>";
                        echo "<td>" . $row['Nombre_completo'] . "</td>";
                        echo "<td><input class='estado' type='text' name='cedula' value='" . $row['documento'] . "' readonly></td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>" . $row['Estado_funcionario'] . "</td>";
                        echo "<td>" . $row['Rol'] . "</td>";
                        echo "<td>" . $row['fecha_Registro'] . "</td>";
                        echo "<td class='botones'> 
                                <button class='delete'><ion-icon name='ban-outline'></ion-icon></button></form>
                                <button class='edit' onclick=editarinst><ion-icon name='create-outline'></ion-icon></button>
                                </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="editarinst" class="modal-backdrop">
        <div class="modal">
            <h2>Editar</h2>

            <input type="text" placeholder="Id funcionario" required>
            <select>
                <option value="">Activo</option>
                <option value="">Inhabilitado</option>
            </select>
            <input type="text" name="correo" placeholder="Ingrese el nuevo nombre">

            <input type="email" name="correo" placeholder="Ingrese el nuevo correo">
            <button>Cambiar</button>
            <span class="close-btn" onclick="closeModal();">&times;</span>
        </div>
    </div>


    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>
    <!--------------------------------------Scripts---------------------------------------------------->

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
        window.editarinst = function() {
            document.getElementById("editarinst").style.display = "block";
        };
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
    <!-- Select2 CSS y JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablaInstructores').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [5, 10, 25, -1],
                    [5, 10, 25, 'Todos']
                ],
                responsive: true,
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    title: 'Lista de Instructores'
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