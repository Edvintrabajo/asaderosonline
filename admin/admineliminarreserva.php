<?php
$config = include '../database/config.php';

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $consultaSQL = "DELETE FROM reservas WHERE id = :id";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    header("Location: adminreservas.php");
}
?>