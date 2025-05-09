<?php 
    session_start();
    // Verificar si el usuario ya ha iniciado sesión
    include 'conexion.php'; 
    $Documento_L = $_POST["document"];
    $Contraseña_L = $_POST["password"];
    // Validar que el documento y la contraseña sean correctos y existan en la base de datos.
    $verify_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento_L' AND contraseña = '$Contraseña_L'");
    if (mysqli_num_rows($verify_login) > 0) {
        $usuario = mysqli_fetch_assoc($verify_login); // Obtener los datos del usuario
    
        $_SESSION['documento'] = $Documento_L; // Ya lo tienes
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario']; // Asegúrate de que la columna se llame así
    
        header("Location: ../inventario.php");
    } else {
        echo "<script>
            alert('Usuario no registrado');
            window.location = '../login.php';
        </script>";
        exit();
    }

?>
