<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("location: ../index.php");
} else {
    if(!$_SESSION['usuario']['admin']) {
        header("location: ../index.php");
    }
}

if(isset($_POST['submit'])){
    $resultado = [
        'error' => false,
        'mensaje' => 'El asadero ' . $_POST['nombre'] . ' ha sido agregado con éxito'
    ];
    $config = include "../database/config.php";

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        
        $asadero = array(
            "nombre" => $_POST['nombre'],
            "lugar" => $_POST['lugar'],
            "fecha" => $_POST['fecha'],
            "descripcion" => $_POST['descripcion'],
            "precio" => $_POST['precio'],
            "maxpersonas" => $_POST['maxpersonas']
        );

        $consultaSQL = "INSERT INTO asaderos (nombre, lugar, fecha, descripcion, precio, maxpersonas)";
        $consultaSQL .= "VALUES (:" . implode(", :", array_keys($asadero)) . ")";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($asadero);
        header("location: adminasaderos.php");
        
    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
};
?>

<?php include "../parts/adminheader.php"; ?>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="subNav">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Asaderos Online</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded active" href="adminasaderos.php">Asaderos</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="adminusuarios.php">Usuarios</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="adminreservas.php">Reservas</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- MENSAJE DE ERROR -->
<?php
if(isset($resultado) && $resultado['error']) {
?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
               <div class="alert alert-danger" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- Asaderos Section-->
<section class="page-section portfolio mt-5" id="asaderos">
    <div class="container">
        <!-- Asaderos Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Asaderos</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crear">Crear</a>
        </div>
        <!-- Asaderos Grid Items-->
        <div class="row justify-content-center">
            <?php include "adminverasaderos.php"; ?>
        </div>
    </div>
</section>


<!-- Modal Crear -->
<div class="portfolio-modal modal fade" id="crear" tabindex="-1" aria-labelledby="crear" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body text-center pb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <!-- Portfolio Modal - Nombre-->
                            <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Crear Asadero</h2>
                            <!-- Icon Divider-->
                            <div class="divider-custom">
                                <div class="divider-custom-line"></div>
                                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                <div class="divider-custom-line"></div>
                            </div>
                            <!-- Portfolio Modal - Formulario-->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <div class="form-group mb-3">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="lugar">Lugar:</label>
                                    <input type="text" class="form-control" name="lugar" id="lugar" required>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
                                    <div class="form-group mb-3">
                                        <label for="fecha">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" id="fecha" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" name="precio" id="precio" min="1" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="maxpersonas">Máximo de personas:</label>
                                        <input type="number" class="form-control" name="maxpersonas" id="maxpersonas" min="1" required>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="descripcion">Descripción:</label>
                                    <textarea class="form-control" name="descripcion" id="descripcion" style="height: 10rem" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="submit" class="btn btn-primary mt-2" name="submit" value="Crear">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core theme JS-->
<script src="src/js/scripts.js"></script>