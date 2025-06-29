<?php
include 'Conexion.php';
session_start();

if (
    isset($_POST['documento']) &&
    isset($_POST['nueva_contrasena']) &&
    isset($_POST['confirmar_contrasena']) &&
    isset($_POST['codigo_verificacion'])
) {
    $documento = mysqli_real_escape_string($conexion, $_POST['documento']);
    $codigoIngresado = mysqli_real_escape_string($conexion, $_POST['codigo_verificacion']);
    $nuevaPass = $_POST['nueva_contrasena'];
    $confirmarPass = $_POST['confirmar_contrasena'];

    // Validar que las contraseñas coincidan
    if ($nuevaPass !== $confirmarPass) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Las contraseñas no coinciden.'
        ];
        header("Location: ../index.php");
        exit();
    }

    // Validar seguridad de la contraseña
    $errores = [];
    if (strlen($nuevaPass) < 6)
        $errores[] = "Debe tener al menos 6 caracteres.";
    if (!preg_match('/[A-Z]/', $nuevaPass))
        $errores[] = "Debe contener al menos una letra mayúscula.";
    if (!preg_match('/[0-9]/', $nuevaPass))
        $errores[] = "Debe contener al menos un número.";
    if (!preg_match('/[\W]/', $nuevaPass))
        $errores[] = "Debe contener al menos un símbolo.";

    if (!empty($errores)) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Contraseña inválida',
            'texto' => implode(" ", $errores)
        ];
        header("Location: ../index.php");
        exit();
    }

    // Consultar el código de verificación del usuario
    $consulta = "SELECT codigo_verificacion FROM usuarios WHERE documento = '$documento'";
    $resultado = mysqli_query($conexion, $consulta);

    if (!$resultado) {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error de base de datos',
            'texto' => 'No se pudo verificar el código. ' . mysqli_error($conexion)
        ];
        header("Location: ../index.php");
        exit();
    }

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        if ($fila['codigo_verificacion'] == $codigoIngresado) {
            $hashedPassword = mysqli_real_escape_string($conexion, password_hash($nuevaPass, PASSWORD_DEFAULT));
            $update = "UPDATE usuarios SET contraseña = '$hashedPassword', codigo_verificacion = NULL WHERE documento = '$documento'";
            mysqli_query($conexion, $update);

            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => 'Contraseña actualizada',
                'texto' => 'Tu contraseña ha sido cambiada correctamente.'
            ];
            header("Location: ../index.php");
            exit();

        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Código incorrecto',
                'texto' => 'El código ingresado no es válido.'
            ];
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Documento no encontrado',
            'texto' => 'No se encontró un usuario con ese documento.'
        ];
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Datos incompletos',
        'texto' => 'Faltan campos por completar.'
    ];
    header("Location: ../index.php");
    exit();
}
?>