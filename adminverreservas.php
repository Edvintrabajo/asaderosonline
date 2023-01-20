<?php
include 'utils/functions.php';

$error = false;
$config = include 'database/config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "SELECT * FROM reservas";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $asaderos = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}

if ($error) {
?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            </div>
        </div>
    </div>
<?php
}

if ($asaderos && $sentencia->rowCount() > 0) {
    foreach ($asaderos as $fila) {
?>
    <!-- Reserva Item-->
    <div class="col-md-6 col-lg-4 mb-5">
        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal<?php echo codificarHTML($fila["id"]); ?>">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
            </div>
            <div class="card img-fluid">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title p-2"><?php echo codificarHTML($fila["idasadero"]); ?></h5>
                    <p class="card-text"><?php echo codificarHTML($fila["idusuario"]); ?></p>
                    <p class="card-text"><?php echo codificarHTML($fila["creadoen"]); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reserva Modal 1-->
    <div class="portfolio-modal modal fade" id="portfolioModal<?php echo codificarHTML($fila["id"]); ?>" tabindex="-1" aria-labelledby="portfolioModal<?php echo codificarHTML($fila["id"]); ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Nombre-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Reserva <?php echo codificarHTML($fila["id"]); ?></h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Portfolio Modal - ID Asadero-->
                                <p class="mb-4 lead ">ID Asadero: <?php echo codificarHTML($fila["idasadero"]); ?></p>
                                <!-- Portfolio Modal - ID Usuario-->
                                <p class="mb-4 lead">ID Usuario: <?php echo codificarHTML($fila["idusuario"]); ?></p>
                                <!-- Portfolio Modal - Creado en-->
                                <p class="mb-4 lead">Creado en: <?php echo codificarHTML($fila["creadoen"]); ?></p>

                                <div class="d-flex justify-content-center">
                                    <!-- Portfolio Modal - Boton Reservar-->
                                    <a class="btn btn-danger btn-lg m-2" href="admineliminarreserva.php?id=<?php echo codificarHTML($fila["id"]); ?>">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    }
} else {
?>
    <h4 class="text-center">No hay reservas registradas...</h4>
<?php
}
?>