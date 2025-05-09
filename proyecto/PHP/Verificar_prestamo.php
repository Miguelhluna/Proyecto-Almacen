<?php
include_once 'Conexion.php';
$query = "SELECT * FROM prestamos_equipos JOIN detalle_prestamo_equipos WHERE estado_prestamo = 'Prestado' AND TIMESTAMPDIFF(MINUTE, fecha_prestamo, NOW()) > 6;"; 
$result = mysqli_query($conexion, $query);

$retrasados = [];
while ($row = mysqli_fetch_assoc($result)) {
    $retrasados[] = $row;
}

echo json_encode(['retrasados' => $retrasados]);
?>