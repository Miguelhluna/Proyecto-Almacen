<?php
include_once 'Conexion.php';

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    // Eliminar el instructor de la base de datos

    $queryEstado = "SELECT Estado_funcionario FROM usuarios WHERE documento = '$cedula'";
    $resultado = mysqli_query($conexion, $queryEstado);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $estadoActual = $fila['Estado_funcionario'];

        if ($estadoActual === 'Inactivo') {
            $queryActivacion = "UPDATE usuarios SET Estado_funcionario = 'Activo' WHERE documento = '$cedula'";
            mysqli_query($conexion, $queryActivacion);
            echo "<script>
                    alert('Instructor activado correctamente');
                    window.location = '../instructores.php';
                </script>";
        } else {
        $query = "UPDATE usuarios SET Estado_funcionario = 'Inactivo' WHERE documento = '$cedula'";
        $eject = mysqli_query($conexion, $query);
        if ($eject) {
            echo "<script>
                    alert('Instructor eliminado correctamente');
                    window.location = '../instructores.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error al eliminar el instructor');
                    window.location = '../instructores.php';
                  </script>";
        }
    } 
    }
}
?>