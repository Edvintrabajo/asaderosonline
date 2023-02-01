<?php
/**
 * File: eliminarreserva.php
 * Date: 27/04/2021
 * Description: Eliminar reserva
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package scripts
 * @version 1.0
 * @since 1.0
 */

// Sessión de usuario
session_start();

/**
 * Comprobamos si el usuario ya está logueado, si no es así, lo redirigimos a la página de login
 */
if(!isset($_SESSION['usuario'])) {
    header("location: login.php");
}

/**
 * Iniciamos la conexión a la base de datos
 * Comprobamos si se ha pasado el id de la reserva por GET
 * Si es así, eliminamos la reserva
 */
if (isset($_GET["id"])) {
    $config = include '../database/config.php';

    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
    $id = $_GET["id"];
    $consultaSQL = "DELETE FROM reservas WHERE id = :id AND idusuario = :idusuario";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(":id", $id);
    $sentencia->bindParam(":idusuario", $_SESSION['usuario']['id']);
    $sentencia->execute();
    header("location: misreservas.php");
}
?>