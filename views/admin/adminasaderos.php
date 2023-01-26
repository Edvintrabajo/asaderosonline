<?php
/**
 * File: adminasaderos.php
 * Date: 27/04/2021
 * Description: Vista de administración de asaderos
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package admin-views
 * @version 1.0
 * @since 1.0
 */

// Sessión de usuario
session_start();

/**
 * Comprobamos si el usuario ya está logueado, si no es así, lo redirigimos a la página de login
 * También comprobamos si es admin, si no es así, lo redirigimos a la página del index
 */
if(!isset($_SESSION['usuario'])) {
    header("location: ../login.php");
} else {
    if(!$_SESSION['usuario']['admin']) {
        header("location: ../index.php");
    }
}

/**
 * Comprobamos si se ha pulsado el botón de submit del formulario de crear asadero
 */
if(isset($_POST['submit'])){
    $resultado = [
        'error' => false,
        'mensaje' => 'El asadero ' . $_POST['nombre'] . ' ha sido agregado con éxito'
    ];
    $config = include "../../database/config.php";

    /**
     * Conexión a la base de datos y manejo de errores
     */
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        include '../../utils/functions.php';
        $resultado = validatecrearasadero($_POST['nombre'], $_POST['lugar'], $_POST['fecha'], $_POST['descripcion'], $_POST['precio'], $_POST['maxpersonas']);
        if (!$resultado['error']) {
            $consultaSQL = "SELECT * FROM asaderos WHERE nombre = :nombre";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(":nombre", $_POST['nombre']);
            $sentencia->execute();
            $asadero = $sentencia->fetch(PDO::FETCH_ASSOC);

            /**
             * Comprobamos si el nombre del asadero ya existe en la base de datos
             * Si es así, mostramos un mensaje de error
             * Si no es así, agregamos el asadero a la base de datos
             */
            if ($asadero) {
                $resultado['error'] = true;
                $resultado['mensaje'] = 'El nombre del asadero ya existe';
            } else {
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
            }
        }
    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
};
?>

<?php include "../../parts/adminheader.php"; ?>

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
        <?php
        if(isset($resultado) && $resultado['error']) {
        ?>
            <!-- MENSAJE DE ERROR -->
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
        <!-- Asaderos Grid Items-->
        <div class="row justify-content-center">
            <?php include "adminverasaderos.php"; ?>
        </div>
    </div>
</section>


<!-- Crear asadero Modal -->
<div class="portfolio-modal modal fade" id="crear" tabindex="-1" aria-labelledby="crear" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body text-center pb-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <!-- Crear asadero Modal - Nombre-->
                            <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Crear Asadero</h2>
                            <!-- Icon Divider-->
                            <div class="divider-custom">
                                <div class="divider-custom-line"></div>
                                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                <div class="divider-custom-line"></div>
                            </div>
                            <!-- Crear asadero Modal - Formulario-->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <div class="form-group mb-3">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" required>
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
<script src="../../src/js/scripts.js"></script>