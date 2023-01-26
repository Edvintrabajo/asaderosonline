<?php
/**
 * File: adminverusuarios.php
 * Date: 27/04/2021
 * Description: Ver usuarios
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package admin-mini-views
 * @version 1.0
 * @since 1.0
 */

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
 * Iniciamos la conexión a la base de datos y menejamos los errores
 * Listamos los usuarios
 */
try {
    $error = false;
    
    include '../../utils/functions.php';
    $config = include '../../database/config.php';
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
    <!-- MENSAJE DE ERROR -->
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

/**
 * Mostramos los usuarios en la página si hay alguno
 */
if ($asaderos && $sentencia->rowCount() > 0) {
    foreach ($asaderos as $fila) {
?>
    <!-- Usuario Item-->
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
                                <!-- Usuario Modal - Nombre-->
                                <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0"><?php echo codificarHTML($fila["nombre"]); ?></h2>
                                <!-- Icon Divider-->
                                <div class="divider-custom">
                                    <div class="divider-custom-line"></div>
                                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                    <div class="divider-custom-line"></div>
                                </div>
                                <!-- Usuario Modal - Email-->
                                <p class="mb-4 lead ">Email: <?php echo codificarHTML($fila["email"]); ?></p>
                                <!-- Usuario Modal - Telefono-->
                                <p class="mb-4 lead">Telefono: <?php echo codificarHTML($fila["telefono"]); ?></p>
                                <!-- Usuario Modal - Admin-->
                                <p class="mb-4 lead">Admin: <?php if($fila["admin"]) { echo 'Si'; }else { echo 'No'; }; ?></p>
                                <!-- Usuario Modal - Creado en-->
                                <p class="mb-4 lead">Creado en: <?php echo codificarHTML($fila["creadoen"]); ?></p>

                                <div class="d-flex justify-content-center">
                                    <!-- Usuario Modal - Boton Reservar-->
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