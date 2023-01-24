<?php
include '../utils/functions.php';

$error = false;
$config = include '../database/config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "SELECT * FROM asaderos";
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
    <!-- Asaderos Item-->
    <div class="col-md-6 col-lg-4 mb-5">
        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal<?php echo codificarHTML($fila["id"]); ?>">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
            </div>
            <div class="card img-fluid">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title p-2"><?php echo codificarHTML($fila["nombre"]); ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo codificarHTML($fila["fecha"]); ?></h6>
                    <p class="card-text"><?php echo codificarHTML($fila["lugar"]); ?></p>
                    <p class="card-text text-primary"><?php echo codificarHTML($fila["precio"]); ?>€</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Asadero Modal 1-->
    <div class="portfolio-modal modal fade" id="portfolioModal<?php echo codificarHTML($fila["id"]); ?>" tabindex="-1" aria-labelledby="portfolioModal<?php echo codificarHTML($fila["id"]); ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body text-center pb-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <!-- Portfolio Modal - Nombre-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0"><?php echo codificarHTML($fila["nombre"]); ?></h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <div class="d-flex justify-content-evenly">
                                    <!-- Portfolio Modal - Lugar-->
                                    <p class="mb-4 lead">Lugar: <?php echo codificarHTML($fila["lugar"]); ?></p>
                                    <!-- Portfolio Modal - Fecha-->
                                    <p class="mb-4 lead">Fecha: <?php echo codificarHTML($fila["fecha"]); ?></p>
                                </div>

                                <div class="d-flex justify-content-evenly">
                                    <!-- Portfolio Modal - Maxpersonas-->
                                    <p class="mb-4 lead">Máximo de personas: <?php echo codificarHTML($fila["maxpersonas"]); ?></p>
                                    <!-- Portfolio Modal - Precio-->
                                    <p class="mb-4 lead">Precio: <span class="text-primary"><?php echo codificarHTML($fila["precio"]); ?>€</span></p>
                                </div>
                                <!-- Portfolio Modal - Descripcion-->
                                <p class="mb-4 lead"><?php echo codificarHTML($fila["descripcion"]); ?></p>

                                <div class="d-flex justify-content-center">
                                    <!-- Portfolio Modal - Boton Reservar-->
                                    <a class="btn btn-primary btn-lg m-2" href="index.php?reservar&idasadero=<?php echo codificarHTML($fila["id"]); ?>">Reservar</a>
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
    <h4 class="text-center">No hay asaderos disponibles...</h4>
<?php
}
?>