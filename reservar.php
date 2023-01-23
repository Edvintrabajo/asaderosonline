<?php
session_start();
$resultado = [
    'error' => false,
    'mensaje' => 'El asadero ' . $_POST['nombre'] . ' ha sido agregado con éxito'
];
$config = include "database/config.php";

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    
    $reserva = array(
        "idasadero" => $_GET['idasadero'],
        "idusuario" => $_SESSION['usuario']['id']
    );

    $consultaSQL = "INSERT INTO reservas (idasadero, idusuario)";
    $consultaSQL .= "VALUES (:" . implode(", :", array_keys($reserva)) . ")";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute($reserva);
    header("location: index.php");
    
} catch(PDOException $error) {
    header("location: index.php");
}
?>