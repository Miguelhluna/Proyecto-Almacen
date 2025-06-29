<?php
session_start();
if (isset($_POST['documento'])) {
    include_once 'Conexion.php';

    $documentoFuncionario = $_POST['documento'];

    // Eliminar el funcionario de la base de datos
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
        header("Location: ../Administrador.php");
        exit();
    } else {
        echo "Error al eliminar el funcionario: " . mysqli_error($conexion);
    }
}
}
?>