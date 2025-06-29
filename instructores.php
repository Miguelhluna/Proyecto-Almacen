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
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <!-- Librerías para exportar (Excel y PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


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

    <!-----------------------REGISTRAR INSTRUCTORES---------------------------------->
    <button id="inst" onclick="registrarinst();">Registrar instructores</button>
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
                                <button class='edit' onclick='editarinst();'><ion-icon name='create-outline'></ion-icon></button>
                                </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="editarinst" class="modal-backdrop">
        <div class="modal" id="editarinst">
            <span class="close-btn" onclick="cerrareditarinst();">&times;</span>

            <h2>Editar</h2>
            <div>
                <input type="text" placeholder="Id funcionario" readonly>
            </div>
            <select>
                <option value="">Activo</option>
                <option value="">Inhabilitado</option>
            </select>
            <input type="text" name="correo" placeholder="Ingrese el nuevo nombre" required>

            <input type="email" name="correo" placeholder="Ingrese el nuevo correo">
            <div>
                <button type="submit" class="btn-editar">Editar</button>
            </div>
        </div>
    </div>


    <footer>
        <p>&copy; 2025 Todos los derechos reservados</p>
    </footer>
    <!--------------------------------------Scripts---------------------------------------------------->
    <script src="js/script.js"></script>

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
        window.cerrareditarinst = function() {
            document.getElementById("editarinst").style.display = "none";
        };
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




    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        unset($_SESSION['mensaje']);
    }
    ?>

</body>

</html>