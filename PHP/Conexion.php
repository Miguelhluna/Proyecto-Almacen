<?php
/* 
$servidor = 'localhost';  // Dirección del servidor de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = '';  // Contraseña del usuario
$dbname = 'propuesta';  // Nombre de la base de datos
try {
    $connect = new PDO ("Mysql:host=.$servidor;dbname=$dbname", $username, $password,
    array (PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMET 'utf8'"));
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Conexión fallida " . $e->getMessage();
}
$conexion = null; */


$servidor = 'localhost';  // Dirección del servidor de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = '';  // Contraseña del usuario
$dbname = 'propuesta';  // Nombre de la base de datos

$conexion = new mysqli($servidor, $username, $password, $dbname);
if (!$conexion) {
    die("Conexión fallida: " . $conexion->connect_error);
} 

?>