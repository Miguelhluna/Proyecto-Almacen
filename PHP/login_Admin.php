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
        ];
        header("Location: ../index.php");
        exit();
    }

?>
