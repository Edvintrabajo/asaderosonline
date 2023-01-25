<?php
/**
 * Admin Eliminar Usuario
 */

/**
 * Sessión de usuario
 */
session_start();

/**
 * Comprobamos si el usuario ya está logueado, si no es así, lo redirigimos a la página de login
 * También comprobamos si es admin, si no es así, lo redirigimos a la página del index
 */
if(!isset($_SESSION['usuario'])) {
    header("location: ../login.php");
} else {
    if(!$_SESSION['usuario']['admin']) {
        header("location: ../index.php");
    }
}

/**
 * Iniciamos la conexión a la base de datos
 */
$config = include '../../database/config.php';

$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

/**
 * Comprobamos si se ha pasado el id del usuario por GET
 */
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $consultaSQL = "DELETE FROM usuarios WHERE id = :id";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    header("Location: adminusuarios.php");
}
?>