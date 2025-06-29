<?php
session_start();
include 'Conexion.php'; // asegúrate que esta conexión funcione

if (isset($_POST["document"]) && isset($_POST["password"])) {
    $documento = mysqli_real_escape_string($conexion, $_POST["document"]);
    $passwordIngresada = $_POST["password"];

    // Buscar usuario
    $query = "SELECT * FROM usuarios WHERE documento = '$documento' AND Estado_funcionario = 'Activo'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        $hashGuardado = $usuario['contraseña'];

        // Validar contraseña
        if (password_verify($passwordIngresada, $hashGuardado)) {
            // Guardar en sesión
            $_SESSION['documento'] = $usuario['documento'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['rol'] = $usuario['Rol'];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['foto'] = $usuario['foto'];
            $_SESSION['email'] = $usuario['email'];

            // Redirigir según el rol
            switch ($usuario['Rol']) {
                case 'Administrador':
                    header("Location: ../Administrador.php");
                    break;
                case 'Almacenista':
                    header("Location: ../inventario.php");
                    break;
                default:
                    $_SESSION['mensaje'] = [
                        'tipo' => 'error',
                        'titulo' => 'Acceso denegado',
                        'texto' => 'Tu rol no tiene acceso a este sistema.'
                    ];
                    header("Location: ../index.php");
                    break;
            }
            exit();
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Contraseña incorrecta',
                'texto' => 'Verifica tu contraseña e intenta de nuevo.'
            ];
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Usuario no encontrado',
            'texto' => 'El documento no existe o está inactivo.'
        ];
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error de envío',
        'texto' => 'Debes completar todos los campos.'
    ];
    header("Location: ../index.php");
    exit();
}
?>
