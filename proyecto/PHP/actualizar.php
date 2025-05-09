<?php
session_start(); // Asegúrate de tener esto al principio

include 'conexion.php';

$documento = $_POST['documento'];
$updates = [];

// Actualizar nombre de usuario
if (!empty($_POST['nuevo_usuario'])) {
    $newUser = mysqli_real_escape_string($conexion, $_POST['nuevo_usuario']);
    $updates[] = "nombre_usuario='$newUser'";
}

// Actualizar correo
if (!empty($_POST['nuevo_correo'])) {
    $newEmail = mysqli_real_escape_string($conexion, $_POST['nuevo_correo']);
    $updates[] = "email='$newEmail'";
}

// Actualizar contraseña
if (!empty($_POST['nueva_contraseña'])) {
    $newPassword = mysqli_real_escape_string($conexion, $_POST['nueva_contraseña']);
    $updates[] = "contraseña='$newPassword'";
}

// Actualizar foto de perfil
if (isset($_FILES['profile']) && $_FILES['profile']['error'] === 0) {
    $directorioDestino = 'IMG/uploads/';
    
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0777, true); // Crea la carpeta si no existe
    }

    $nombreArchivo = uniqid() . '_' . basename($_FILES['profile']['name']);
    $rutaCompleta = $directorioDestino . $nombreArchivo;

    if (move_uploaded_file($_FILES['profile']['tmp_name'], $rutaCompleta)) {
        $rutaParaBD = mysqli_real_escape_string($conexion, $rutaCompleta);
        $updates[] = "foto='$rutaParaBD'";
    } else {
        echo "Error al subir la imagen.";
        exit();
    }
}

// Solo si hay datos para actualizar
if (!empty($updates)) {
    $sql = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE documento='$documento'";

    if (mysqli_query($conexion, $sql)) {
        // ✅ Refrescar datos en la sesión
        $query = "SELECT * FROM usuarios WHERE documento='$documento'";
        $resultado = mysqli_query($conexion, $query);
        if ($fila = mysqli_fetch_assoc($resultado)) {
            $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];
            $_SESSION['email'] = $fila['email'];
            $_SESSION['foto'] = $fila['foto'];
        }

        header("Location: ../inventario.php");
        exit();
    } else {
        echo "❌ Error al actualizar el registro: " . mysqli_error($conexion);
    }
} else {
    echo "⚠️ No se enviaron datos para actualizar.";
}
?>
