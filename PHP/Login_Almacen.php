<?php
include_once 'Conexion.php';
session_start();

if (isset($_POST['document']) && isset($_POST['password'])) {
    $Documento_L = $_POST["document"];
    $Contraseña_L = $_POST["password"];

    // Buscar usuario
    $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento_L' AND rol = 'Almacenista' AND Estado_funcionario = 'Activo'");

    $usuario = ($query && mysqli_num_rows($query) > 0) ? mysqli_fetch_assoc($query) : null;

    // Usamos un switch para manejar el resultado de validaciones
    switch (true) {
        case !$usuario:
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'Usuario no encontrado o inactivo'
            ];
            header("Location: ../index.php");
            exit();

        case !password_verify($Contraseña_L, $usuario['contraseña']):
            $_SESSION['mensaje'] = [
                'tipo' => 'error',
                'titulo' => 'Error',
                'texto' => 'Contraseña incorrecta'
            ];
            header("Location: ../index.php");
            exit();

        default:
            // Credenciales válidas
            $_SESSION['documento'] = $usuario['documento'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['foto'] = $usuario['foto'];

            header("Location: ../inventario.php");
            exit();
    }

} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error',
        'texto' => 'Documento o contraseña no proporcionados'
    ];
    header("Location: ../index.php");
    exit();
}
?>
