<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("location: index.php");
}

$config = include '../database/config.php';

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $consultaSQL = "DELETE FROM reservas WHERE id = :id AND idusuario = :idusuario";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(":id", $id);
    $sentencia->bindParam(":idusuario", $_SESSION['usuario']['id']);
    $sentencia->execute();
    header("location: misreservas.php");
}
?>