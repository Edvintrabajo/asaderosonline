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

// CONGIGURACIÓN PARA USAR .ENV EN PRODUCCIÓN EN HEROKU
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
?>