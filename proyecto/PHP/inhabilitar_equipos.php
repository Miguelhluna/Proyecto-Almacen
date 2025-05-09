<?php
include_once 'Conexion.php';
session_start();

if (isset($_POST['equipo'])) {
    $idEquipo = $_POST['equipo'];

    // Consultar el estado actual del equipo
    $queryEstado = "SELECT Estado FROM equipos WHERE id_equipo = '$idEquipo'";
    $resultado = mysqli_query($conexion, $queryEstado);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $estadoActual = $fila['Estado'];

        if ($estadoActual === 'Disponible') {
            // Cambiar a Inhabilitado
            $queryUpdate = "UPDATE equipos SET Estado = 'Inhabilitado' WHERE id_equipo = '$idEquipo'";
            mysqli_query($conexion, $queryUpdate);
            $mensaje = 'Muy bien, el equipo ha sido inhabilitado';
        } else if ($estadoActual === 'Inhabilitado') {
            // Verificar si tiene novedades
            $queryNovedades = "SELECT COUNT(*) as total FROM novedad_equipos WHERE id_equipo = '$idEquipo' AND estado_novedad != 'Resuelta'";
            $resNovedades = mysqli_query($conexion, $queryNovedades);
            $filaNovedades = mysqli_fetch_assoc($resNovedades);

            if ($filaNovedades['total'] == 0) {
                // Si no hay novedades, cambiar a Disponible
                $queryUpdate = "UPDATE equipos SET Estado = 'Disponible' WHERE id_equipo = '$idEquipo'";
                mysqli_query($conexion, $queryUpdate);
                $mensaje = 'Muy bien, el equipo ha sido habilitado nuevamente';
            } else {
                // Si tiene novedades, no se puede habilitar
                echo "<script>
                        alert('Este equipo no se puede habilitar porque tiene novedades registradas.');
                        window.location = '../inventario.php';
                      </script>";
                exit;
            }
        } else {
            $mensaje = 'Estado desconocido. No se realizó ningún cambio.';
        }

        echo "<script>
                alert('$mensaje');
                window.location = '../inventario.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Equipo no encontrado.');
                window.location = '../inventario.php';
              </script>";
        exit;
    }
}
?>

