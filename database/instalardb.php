<?php
$config = include 'config.php';

try {
    $conexion = new PDO(
        'mysql:host=' . $config['db']['host'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['options']
    );
    $sql = file_get_contents('asaderos-online.sql');
    $conexion->exec($sql);
    echo 'Base de datos y tabla creada con éxito';
} catch (PDOException $error) {
    echo $error->getMessage();
}
?>