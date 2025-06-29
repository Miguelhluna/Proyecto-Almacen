<<<<<<< HEAD
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
=======
<?php 
    session_start();
    // Verificar si el usuario ya ha iniciado sesión
    include 'conexion.php'; 
    $Documento_L = $_POST["document"];
    $Contraseña_L = $_POST["password"];
    // Validar que el documento y la contraseña sean correctos y existan en la base de datos.
    $verify_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento_L' AND contraseña = '$Contraseña_L' AND Estado_funcionario = 'Activo' AND Rol = 'Administrador'");
    if (mysqli_num_rows($verify_login) > 0) {
        $usuario = mysqli_fetch_assoc($verify_login); // Obtener los datos del usuario
    
        $_SESSION['documento'] = $Documento_L; // Ya lo tienes
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario']; // Asegúrate de que la columna se llame así
        $_SESSION['rol'] = $usuario['Rol']; // Asegúrate de que la columna se llame así
        $_SESSION['id_usuario'] = $usuario['id_usuario']; // Asegúrate de que la columna se llame así
        $_SESSION['foto'] = $usuario['foto']; // Asegúrate de que la columna se llame así
        $_SESSION['email'] = $usuario['email']; // Asegúrate de que la columna se llame así
    
        header("Location: ../Administrador.php");
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Documento o contraseña incorrectos'
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
        ];
        header("Location: ../index.php");
        exit();
    }
<<<<<<< HEAD
} else {
    $_SESSION['mensaje'] = [
        'tipo' => 'error',
        'titulo' => 'Error de envío',
        'texto' => 'Debes completar todos los campos.'
    ];
    header("Location: ../index.php");
    exit();
}
=======

>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
?>
