<?php
session_start();
include_once 'Conexion.php';

if (isset($_POST['Updatedocumento'])) {
    $documentoFuncionario = $_POST['Updatedocumento'];
    $updateFuncionario = [];

    if (!empty($_POST['Updatenombre'])) {
        $newName = mysqli_real_escape_string($conexion, $_POST['Updatenombre']);
        $updateFuncionario[] = "Nombre_completo='$newName'";
    }
    if (!empty($_POST['Updatetelefono'])) {
        $newPhone = mysqli_real_escape_string($conexion, $_POST['Updatetelefono']);
        $updateFuncionario[] = "telefono='$newPhone'";
    }
    if (!empty($_POST['Updateemail'])) {
        $newCorreo = mysqli_real_escape_string($conexion, $_POST['Updateemail']);
        $updateFuncionario[] = "email='$newCorreo'";
    }
    if (!empty($_POST['rol'])) {
        $newRole = mysqli_real_escape_string($conexion, $_POST['rol']);
        $updateFuncionario[] = "Rol='$newRole'";
    }
    if (!empty($_POST['estado_funcionario'])) {
        $newEstado = mysqli_real_escape_string($conexion, $_POST['estado_funcionario']);
        $updateFuncionario[] = "Estado_funcionario='$newEstado'";
    }

    if (!empty($updateFuncionario)) {
        $sql = "UPDATE usuarios SET " . implode(", ", $updateFuncionario) . " WHERE documento='$documentoFuncionario'";

        if (mysqli_query($conexion, $sql)) {
            // Actualiza los datos en sesión si es necesario
            $query = "SELECT * FROM usuarios WHERE documento='$documentoFuncionario'";
            $resultado = mysqli_query($conexion, $query);
            if ($fila = mysqli_fetch_assoc($resultado)) {
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['telefono'] = $fila['telefono'];
                $_SESSION['correo'] = $fila['correo'];
                $_SESSION['rol'] = $fila['rol'];
                $_SESSION['estado_funcionario'] = $fila['estado_funcionario'];
            }
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => 'Funcionario actualizado',
                'texto' => 'Los datos del funcionario se han actualizado correctamente.'
            ];
            header("Location: ../Administrador.php");
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error al actualizar',
                'texto' => 'No se pudieron actualizar los datos del funcionario: ' . mysqli_error($conexion)
            ];
            header("Location: ../Administrador.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'warning',
            'titulo' => 'No se realizaron cambios',
            'texto' => 'No se proporcionaron datos para actualizar.'
        ];
    }
    header("Location: ../Administrador.php");
    exit();
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'No se ha proporcionado el documento del funcionario.'
    ];
    header("Location: ../Administrador.php");
    exit();
}

?>