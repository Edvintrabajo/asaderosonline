<?php
include 'utils/functions.php';

$error = false;
$config = include 'database/config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "SELECT * FROM usuarios";
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
    <!-- Asadero Item-->
    <div class="col-md-6 col-lg-4 mb-5">
        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal<?php echo codificarHTML($fila["id"]); ?>">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
            </div>
            <div class="card img-fluid">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <h5 class="card-title p-2"><?php echo codificarHTML($fila["nombre"]); ?></h5>
                    <p class="card-text"><?php echo codificarHTML($fila["email"]); ?></p>
                    <p class="card-text"><?php echo codificarHTML($fila["telefono"]); ?></p>
                    <p class="card-text"><?php if($fila["admin"]) { echo 'Admin'; }else { echo 'No admin'; }; ?></p>
                    <p class="card-text"><?php echo codificarHTML($fila["creadoen"]); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Usuario Modal 1-->
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
                                <!-- Portfolio Modal - Email-->
                                <p class="mb-4 lead ">Email: <?php echo codificarHTML($fila["email"]); ?></p>
                                <!-- Portfolio Modal - Telefono-->
                                <p class="mb-4 lead">Telefono: <?php echo codificarHTML($fila["telefono"]); ?></p>
                                <!-- Portfolio Modal - Admin-->
                                <p class="mb-4 lead">Admin: <?php if($fila["admin"]) { echo 'Si'; }else { echo 'No'; }; ?></p>
                                <!-- Portfolio Modal - Creado en-->
                                <p class="mb-4 lead">Creado en: <?php echo codificarHTML($fila["creadoen"]); ?></p>

                                <div class="d-flex justify-content-center">
                                    <!-- Portfolio Modal - Boton Reservar-->
                                    <a class="btn btn-danger btn-lg m-2" href="admineliminarusuario.php?id=<?php echo codificarHTML($fila["id"]); ?>">Eliminar</a>
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
    <h4 class="text-center">No hay usuarios registrados...</h4>
<?php
}
?>