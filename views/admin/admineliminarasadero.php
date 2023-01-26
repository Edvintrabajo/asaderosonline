<?php
/**
 * File: adminaeliminarsadero.php
 * Date: 27/04/2021
 * Description: Admin eliminar asadero
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package admin-scripts
 * @version 1.0
 * @since 1.0
 */

// Sessión de usuario
session_start();

/**
 * Comprobamos si el usuario ya está logueado, si no es así, lo redirigimos a la página de login
 * También comprobamos si es admin, si no es así, lo redirigimos a la página del index
 */
if(!isset($_SESSION['usuario'])) {
    header("location: ../login.php");
} else {
    if(!$_SESSION['usuario']['admin']) {
        header("location: ../../index.php");
    }
}

/**
 * Iniciamos la conexión a la base de datos
 * Comprobamos si se ha pasado el id del asadero por GET
 * Si se ha pasado, eliminamos el asadero de la base de datos
 */
if (isset($_GET["id"])) {
    $config = include '../../database/config.php';

    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $id = $_GET["id"];
    $consultaSQL = "DELETE FROM asaderos WHERE id = :id";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(":id", $id);
    $sentencia->execute();
    header("Location: adminasaderos.php");
}
?>