<?php
include_once 'Conexion.php';
session_start();

if (!isset($_POST['novedad'])) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'No se recibió el ID del equipo'
    ];
    header("Location: ../inventario.php");
    exit();
}

$idEquipo = $_POST['novedad'];

// Consultar el estado actual del equipo
$queryEstado = "SELECT Estado FROM equipos WHERE id_equipo = '$idEquipo'";
$resultado = mysqli_query($conexion, $queryEstado);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'Equipo no encontrado'
    ];
    header("Location: ../inventario.php");
    exit();
}

$fila = mysqli_fetch_assoc($resultado);
$estadoActual = $fila['Estado'];

switch ($estadoActual) {
    case 'Disponible':
        $queryUpdate = "UPDATE equipos SET Estado = 'Inhabilitado' WHERE id_equipo = '$idEquipo'";
        mysqli_query($conexion, $queryUpdate);
        $mensaje = [
            'tipo' => 'success',
            'titulo' => '¡Hecho!',
            'texto' => 'Equipo inhabilitado correctamente'
        ];
        break;

    case 'Inhabilitado':
        $queryNovedades = "SELECT COUNT(*) as total FROM novedad_equipos WHERE id_equipo = '$idEquipo' AND estado_novedad != 'Resuelta'";
        $resNovedades = mysqli_query($conexion, $queryNovedades);
        $filaNovedades = mysqli_fetch_assoc($resNovedades);

        if ($filaNovedades['total'] == 0) {
            $queryUpdate = "UPDATE equipos SET Estado = 'Disponible' WHERE id_equipo = '$idEquipo'";
            mysqli_query($conexion, $queryUpdate);
            $mensaje = [
                'tipo' => 'success',
                'titulo' => '¡Hecho!',
                'texto' => 'Equipo habilitado correctamente'
            ];
        } else {
            $mensaje = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'No se puede habilitar el equipo porque tiene novedades pendientes'
            ];
        }
        break;

    default:
        $mensaje = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Estado del equipo no válido'
        ];
        break;
}

$_SESSION['mensaje'] = $mensaje;
header("Location: ../inventario.php");
exit();
?>

