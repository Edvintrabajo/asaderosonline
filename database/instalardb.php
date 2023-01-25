<?php
/**
 * File: instalardb.php
 * Date: 27/04/2021
 * Description: Instalación de la base de datos
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package config-script
 * @version 1.0
 * @since 1.0
 */

$config = include 'config.php';

/**
 * Conectamos a la base de datos y ejecutamos el script de creación de la base de datos y la tablas
 */
try {
    $conexion = new PDO(
        'mysql:host=' . $config['db']['host'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['options']
    );
    $sql = file_get_contents('asaderos-online.sql');
    $conexion->exec($sql);
    echo 'Base de datos y tablas creadas con éxito';
} catch (PDOException $error) {
    echo $error->getMessage();
}
?>