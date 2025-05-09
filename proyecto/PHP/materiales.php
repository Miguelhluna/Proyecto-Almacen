<?php
include 'Conexion.php';

$idMaterial = $_POST['id_material'];
$tipoMaterial = $_POST['tipo_material'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
date_default_timezone_set('America/Bogota');
$fechaRegistro = date('Y-m-d H:i:s');

// Verificar si ya existe el material con ese ID
$queryCheck = "SELECT * FROM materiales WHERE id_Material = '$idMaterial'";
$resultCheck = mysqli_query($conexion, $queryCheck);
//si ya existe el material, no se inserta, se suma el stock
if (mysqli_num_rows($resultCheck) > 0) {
    // Actualizar el stock del material existente
    $queryUpdate = "UPDATE materiales SET Stock = Stock + '$cantidad' WHERE id_Material = '$idMaterial'";
    $ejecutarUpdate = mysqli_query($conexion, $queryUpdate);
    
    if ($ejecutarUpdate) {
        echo 
        "<script>
            alert('✔️ Se actualizó el stock del material ID $id con $cantidad unidades más.');
            window.location = '../inventario.php';
        </script>";
    } else {
        $query = "INSERT INTO materiales (id_Material, Tipo_Material, Descripción, Stock, fecha_registro) VALUES ('$idMaterial', '$tipoMaterial', '$descripcion', '$cantidad', '$fechaRegistro')";
        $ejecutar = mysqli_query($conexion, $query);
        if ($ejecutar) {
            echo 
            "<script>
                alert('Material registrado correctamente');
                window.location = '../inventario.php';
            </script>";
        } else {
            echo "    <script>
                alert('Material registrado incorrectamente');
                window.location = '../inventario.php';
            </script>;" . mysqli_error($conexion);
    }
    mysqli_close($conexion);
    exit;
}}
?>