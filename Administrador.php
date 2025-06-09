<?php
session_start();
if (isset($_SESSION['password_generada'])) {
    $password = $_SESSION['password_generada'];
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Almacenista registrado!',
            text: 'La contraseña generada es: $password'
        });
    </script>";
    unset($_SESSION['password_generada']); // para no mostrarla más de una vez
}
?>
<?php
// Verificar si el usuario ha iniciado sesión
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Sena</title>
    <link rel="icon" href="img/logoicon.png">
    <link rel="stylesheet" href="CSS/styles.css?v=<?php echo time(); ?>">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JS de DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- JS de DataTables Buttons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
                <ion-icon name="id-card-outline" class="icons1"></ion-icon>
                <h3>Registrar</h3>
                <p>El sistema debe permitir registrar al administrador</p>
                <button class="all" onclick="registrarAll();">Registrar</button>
            </div>
        </div>
    </div>

    <!-- Modal + Backdrop Actualizar-->
    <div id="modalBackdrop" class="modal-backdrop">
        <div class="modal">
            <h2>Actualizar</h2>
            <form action="PHP/actualizarFuncionarios.php" method="POST">
                <select name="estado_funcionario" id="estado_funcionario" required>
                    <?php
                    include 'PHP/conexion.php';
                    $sql = ["Activo", "Inactivo"];
                    foreach ($sql as $estado) {
                        echo "<option name'estado_funcionario' value='$estado'>$estado</option>";
                    }
                    ?>
                </select>
                <input type="text" name="Updatenombre" id="Updatenombre" placeholder="Nombre funcionario" required>
                <input type="text" name="Updatedocumento" id="Updatedocumento" placeholder="Documento" required
                    readonly>
                <input type="email" name="Updateemail" id="Updateemail" placeholder="Correo electronico" required>
                <input type="tel" name="Updatetelefono" id="Updatetelefono" placeholder="Telefono" required>
                <button>Cambiar</button>
            </form>
            <span class="close-btn" onclick="closeModal();">&times;</span>
        </div>
    </div>
    <div id="registrarAll" class="modal-backdrop">


        <div class="modal">
            <form action="PHP/registro_usuario.php" method="POST">
                <span onclick="cerrarAll();" class="closebtn">&times;</span>
                <h2 style="margin-top: 10px;">Registrar</h2>
                <div>
                    <label for="rol"> Rol
                    </label>

                    <select name="rol" id="rol" required>
                        <option value="">Seleccione</option>
                        <?php
                        include 'PHP/conexion.php';
                        $sqlRol = ["Administrador", "Instructor", "Almacenista"];
                        foreach ($sqlRol as $rol) {
                            echo "<option value='$rol'>$rol</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="">Nombre completo</label>
                    <input type="text" name="name" id="nombre" required>
                </div>
                <div>
                    <label for="">Documento</label>
                    <input type="text" name="document" id="documento" required>
                </div>
                <div>
                    <label for="">Correo electronico</label>
                    <input type="email" name="email" id="correo" required>
                </div>
                <div>
                    <label for="">Telefono</label>
                    <input type="tel" name="phone" id="telefono" required>
                </div>
                <button>Registrar</button>
            </form>
        </div>
    </div>

    <!-- Tabla funcionarios -->
    <div class="tabla1 container">
        <table id="miTabla" class="display wrap table-funcionarios" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Rol</th>
                    <th>Fecha de registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'PHP/conexion.php';

                $query = "SELECT * FROM usuarios";

                $result = mysqli_query($conexion, $query);

                while ($row = mysqli_fetch_assoc(result: $result)) {
                    echo "<tr><form action='PHP/eliminarFuncionario.php' method='POST'>";
                    echo "<td>" . htmlspecialchars($row['Nombre_completo']) . "</td>";
                    echo "<td><input class= 'Equipo' type='text' name='documento' value='" . $row['documento'] . "' readonly></td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Estado_funcionario']) . "</td>"; // si no hay campo de estado común, lo puedes dejar fijo
                    echo "<td>" . htmlspecialchars($row['Rol']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha_Registro']) . "</td>";
                    echo "<td>
                    <div class='botones'>
                            <button type='submit' class='delete'><ion-icon name='trash-outline'></ion-icon></button> </form>
                            <button class='edit'onclick='openModal1(\"" . htmlspecialchars($row["Nombre_completo"]) . "\", 
                             \"" . htmlspecialchars($row["documento"]) . "\", 
                             \"" . htmlspecialchars($row["email"]) . "\", 
                             \"" . htmlspecialchars($row["telefono"]) . "\")'>
                            <ion-icon name='create-outline'></ion-icon></button>
                            </div>
                            </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
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
        };
        function openModal1(Updatenombre, Updatedocumento, Updateemail, Updatetelefono) {
            document.getElementById('modalBackdrop').style.display = 'block';
            document.getElementById("Updatenombre").value = Updatenombre;
            document.getElementById("Updatedocumento").value = Updatedocumento;
            document.getElementById("Updateemail").value = Updateemail;
            document.getElementById("Updatetelefono").value = Updatetelefono;

        };

        function closeModal() {
            document.getElementById('modalBackdrop').style.display = 'none';
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        $(document).ready(function () {
            $('#miTabla').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthMenu: [
                    [5, 10, 25, -1],
                    [5, 10, 25, "Todos"]
                ],
                responsive: true,
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                        title: 'Lista de funcionarios',
                        className: 'btn btn-success',

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
                }
            });
        });
    </script>

</body>

</html>