<?php
<<<<<<< HEAD
session_start();
=======
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
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
<<<<<<< HEAD
            $resultadoActivacion = mysqli_query($conexion, $queryActivacion);
            // Si la actualización fue exitosa, mostrar mensaje de éxito
            if ($resultadoActivacion) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'titulo' => '¡Hecho!',
                    'texto' => 'Instructor activado correctamente'
                ];
                // redireccionar a la página de instructores
                header("Location: ../instructores.php");
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error',
                    'texto' => 'No se pudo activar el instructor. Inténtalo de nuevo.'
                ];
                header("Location: ../instructores.php");
                exit;
            }
        } else {
            $query = "UPDATE usuarios SET Estado_funcionario = 'Inactivo' WHERE documento = '$cedula'";
            $eject = mysqli_query($conexion, $query);
            if ($eject) {
                $_SESSION['mensaje'] = [
                    'tipo' => 'success',
                    'titulo' => '¡Hecho!',
                    'texto' => 'Instructor eliminado correctamente'
                ];
                header("Location: ../instructores.php");
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error',
                    'texto' => 'No se pudo eliminar el instructor. Inténtalo de nuevo.'
                ];
                header("Location: ../instructores.php");
                exit;
            }
        }
=======
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
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
    }
}
?>