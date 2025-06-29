<?php
<<<<<<< HEAD
session_start();
=======
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
if (isset($_POST['documento'])) {
    include_once 'Conexion.php';

    $documentoFuncionario = $_POST['documento'];

    // Eliminar el funcionario de la base de datos
<<<<<<< HEAD
    $consultaFuncionario = "SELECT Estado_funcionario FROM usuarios WHERE documento='$documentoFuncionario'";
    $resultadoFuncionario = mysqli_query($conexion, $consultaFuncionario);

    if ($resultadoFuncionario && mysqli_num_rows($resultadoFuncionario) > 0) {
    $fila = mysqli_fetch_assoc($resultadoFuncionario);
    $estadoFuncionario = $fila['Estado_funcionario'];

    if ($estadoFuncionario === 'Activo') {
        $sql = "UPDATE usuarios SET Estado_funcionario='Inactivo' WHERE documento='$documentoFuncionario'";
        $resultadoEliminacion = mysqli_query($conexion, $sql);
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => 'Funcionario eliminado',
            'texto' => 'Funcionario eliminado correctamente.'
        ];
        header("Location: ../Administrador.php");
        exit();
    } elseif ($estadoFuncionario === 'Inactivo') {
        $sql = "UPDATE usuarios SET Estado_funcionario='Activo' WHERE documento='$documentoFuncionario'";
        $resultadoActivacion = mysqli_query($conexion, $sql);
        $_SESSION['mensaje'] = [
            'tipo' => 'success',
            'titulo' => 'Funcionario activado correctamente',
            'texto' => 'El funcionario ha sido activado nuevamente.'
        ];
=======
    $sql = "UPDATE usuarios SET Estado_funcionario='Inactivo' WHERE documento='$documentoFuncionario'";

    if (mysqli_query($conexion, $sql)) {
        // Redirigir a la página de administración después de eliminar
>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
        header("Location: ../Administrador.php");
        exit();
    } else {
        echo "Error al eliminar el funcionario: " . mysqli_error($conexion);
    }
<<<<<<< HEAD
}
}
=======
} 

>>>>>>> dd7504437f140b0225450237e2c8883a599d978f
?>