<?php 
    include 'conexion.php'; 
    $Documento_L = $_POST["document"];
    $Contraseña_L = $_POST["password"];
    // Validar que el documento y la contraseña sean correctos y existan en la base de datos.
    $verify_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE documento = '$Documento_L' AND contraseña = '$Contraseña_L'");
    if (mysqli_num_rows($verify_login) > 0) {
        header("Location: ../index.html");
    } else {
        echo "<script>alert('Usuario no registrado')
        window.location = '../login.php';
        </script>";
        exit();
    }


?>