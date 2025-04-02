

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturar datos</title>
</head>

<body>
    <?php
    include '/PHP/Conexion.php'; // Asegúrate de que la ruta sea correcta

    if (isset($_POST['crear'])) {

            $nombre = $_POST['nombres'];
            $apellido = $_POST['apellidos'];
            $documento = $_POST['documento'];
            $username = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $password = $_POST['contraseña'];
            
            

            $sql = "INSERT INTO usuarios (nombres, apellidos, documento, nombre_usuario, email, telefono, contraseña, fecha_Registro) VALUES (?,?,?,?,?,?,?,now())";
            $stmt= $conn->prepare($sql);


    } else {
        echo "Usuario no registrado";
    }

    if ($stmt) {
        // Vincular parámetros (tipos: s = string, i = integer)
        $stmt->bind_param('sssssss', $nombre, $apellido, $documento, $username, $email, $telefono, $password);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script> alert ('Usuario registrado correctamente') </script>";
        } else {
            echo "<script> alert ('Usuario registrado correctamente') </script>" . $stmt->error;
        }

        $stmt->close(); // Cerrar el statement
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close(); // Cerrar la conexión


    ?>
</body>

</html>