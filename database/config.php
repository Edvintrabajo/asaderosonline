<?php
/**
 * File: config.php
 * Date: 27/04/2021
 * Description: Configuración de la base de datos
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package config
 * @version 1.0
 * @since 1.0
 */

// Si existe la variable de entorno CLEARDB_DATABASE_URL, significa que estamos en entorno de producción, si no existe significa que estamos en entorno de desarrollo
if (getenv('CLEARDB_DATABASE_URL')) {
    return [
        'db' => [
            'host' => getenv('DB_HOST'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASS'),
            'name' => getenv('DB_NAME'),
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        ]
    ];
} else {

    require  __DIR__ .'/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    return [
        'db' => [
            'host' => $_ENV['DB_HOST'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
            'name' => $_ENV['DB_NAME'],
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        ]
    ];
}
?>