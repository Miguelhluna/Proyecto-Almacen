<?php
session_start();

function alertasPrestamos($conexion)
{
    #cuando se haga un insert en la tabla usuarios con el rol de almacenista, se le mostrará un mensaje de alerta al administrador con la contraseña en la página Administrador.php con sweet alert
    $query = "SELECT * FROM usuarios WHERE rol = 'Almacenista' AND contraseña IS NOT NULL";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nombre = $row['Nombre_completo'];
            $contraseña = $row['contraseña'];

            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'titulo' => '¡Almacenista registrado!',
                'texto' => "Nombre: $nombre, Contraseña: $contraseña"
            ];
            header("Location: ../Administrador.php");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'error',
            'titulo' => 'Error',
            'texto' => 'Ocurrió un error al obtener los datos del almacenista'
        ];
    }
}

?>