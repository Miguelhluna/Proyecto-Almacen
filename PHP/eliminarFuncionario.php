<?php
if (isset($_POST['documento'])) {
    include_once 'Conexion.php';

    $documentoFuncionario = $_POST['documento'];

    // Eliminar el funcionario de la base de datos
    $sql = "UPDATE usuarios SET Estado_funcionario='Inactivo' WHERE documento='$documentoFuncionario'";

    if (mysqli_query($conexion, $sql)) {
        // Redirigir a la página de administración después de eliminar
        header("Location: ../Administrador.php");
        exit();
    } else {
        echo "Error al eliminar el funcionario: " . mysqli_error($conexion);
    }
} 

?>