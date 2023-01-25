<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("location: login.php");
} 

include '../utils/functions.php';

$error = false;
$config = include '../database/config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "SELECT * FROM reservas WHERE idusuario = :idusuario";
    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->bindParam(':idusuario', $_SESSION['usuario']['id']);
    $sentencia->execute();
    $reservas = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}

include '../parts/header.php';?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="subNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">Asaderos Online</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="index.php?cerrarsession">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php
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
?>

<!-- Reservas Section-->
<section class="page-section portfolio mt-5" id="reservas">
    <div class="container">
        <!-- Reservas Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Reservas</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Reservas Grid Items-->
        <div class="row justify-content-center">
            <?php 
            if ($reservas && $sentencia->rowCount() > 0) {
                $contador = 1;
                foreach ($reservas as $fila) {
            ?>
                <!-- Reserva Item-->
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal<?php echo $contador; ?>">
                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <div class="card img-fluid">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <h5 class="card-title p-2"><?php echo codificarHTML($fila["idasadero"]); ?></h5>
                                <p class="card-text"><?php echo codificarHTML($fila["creadoen"]); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Reserva Modal 1-->
                <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $contador; ?>" tabindex="-1" aria-labelledby="portfolioModal<?php echo codificarHTML($fila["id"]); ?>" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                            <div class="modal-body text-center pb-5">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <!-- Portfolio Modal - Nombre-->
                                            <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Reserva <?php echo $contador; ?></h2>
                                            <!-- Icon Divider-->
                                            <div class="divider-custom">
                                                <div class="divider-custom-line"></div>
                                                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                                <div class="divider-custom-line"></div>
                                            </div>
                                            <!-- Portfolio Modal - ID Asadero-->
                                            <p class="mb-4 lead ">ID Asadero: <?php echo codificarHTML($fila["idasadero"]); ?></p>
                                            <!-- Portfolio Modal - Creado en-->
                                            <p class="mb-4 lead">Creado en: <?php echo codificarHTML($fila["creadoen"]); ?></p>
            
                                            <div class="d-flex justify-content-center">
                                                <!-- Portfolio Modal - Boton Reservar-->
                                                <a class="btn btn-danger btn-lg m-2" href="eliminarreserva.php?id=<?php echo codificarHTML($fila["id"]); ?>">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                    $contador++;
                }
            } else {
            ?>
                <h4 class="text-center">No hay reservas registradas...</h4>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core theme JS-->
<script src="../src/js/scripts.js"></script>