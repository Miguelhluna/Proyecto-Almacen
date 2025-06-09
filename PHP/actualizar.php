<?php
session_start();
include 'Conexion.php';

$documento = $_POST['documento'];
$nuevo_usuario = isset($_POST['nuevo_usuario']) ? trim($_POST['nuevo_usuario']) : '';
$nuevo_correo = isset($_POST['nuevo_correo']) ? trim($_POST['nuevo_correo']) : '';
$nueva_contraseña = isset($_POST['nueva_contraseña']) ? trim($_POST['nueva_contraseña']) : '';
$nueva_foto = '';

// Verificar si se subió una nueva imagen
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {
    $foto_nombre = $_FILES['profile']['name'];
    $foto_temp = $_FILES['profile']['tmp_name'];
    $ruta_destino = 'IMG/uploads' . basename($foto_nombre);
    if (move_uploaded_file($foto_temp, $ruta_destino)) {
        $nueva_foto = $ruta_destino;
    }
}

$campos_actualizar = [];

if (!empty($nuevo_usuario)) {
    $campos_actualizar[] = "nombre_usuario = '$nuevo_usuario'";
    $_SESSION['nombre_usuario'] = $nuevo_usuario;
}
if (!empty($nuevo_correo)) {
    $campos_actualizar[] = "email = '$nuevo_correo'";
    $_SESSION['email'] = $nuevo_correo;
}
if (!empty($nueva_contraseña)) {
    $hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
    $campos_actualizar[] = "contraseña = '$hash'";
}
if (!empty($nueva_foto)) {
    $campos_actualizar[] = "foto = '$nueva_foto'";
    $_SESSION['foto'] = $nueva_foto;
}

if (count($campos_actualizar) > 0) {
    $sql = "UPDATE usuarios SET " . implode(", ", $campos_actualizar) . " WHERE documento = '$documento'";
    $result = mysqli_query($conexion, $sql);
    if ($result) {
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => '¡Hecho!',
            'texto' => 'Perfil actualizado correctamente'
        ];
        header("Location: ../inventario.php");
        exit;
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'No se pudo actualizar el perfil. Inténtalo de nuevo.'
        ];
        header("Location: ../inventario.php");
        exit;
    }
} else {
    header("Location: ../inventario.php");
}
?>

