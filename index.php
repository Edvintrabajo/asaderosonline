<?php
/**
 * File: index.php
 * Date: 27/04/2021
 * Description: Vista del index
 * Author: Edvin Freyer Ortega
 * Email: EdvinTrabajo@gmail.com
 * Github: https://github.com/Edvintrabajo
 * 
 * @package views
 * @version 1.0
 * @since 1.0
 */

// Sessión de usuario
session_start();

// Incluimos las funciones
include './utils/functions.php';

/**
 * Comprobamos si el usuario ya está logueado, si no es así, lo redirigimos a la página de login
 */
if(!isset($_SESSION['usuario'])){
    header("location: ./views/login.php");
}

if(empty($_SESSION['usuario']['id'])) {
    header("location: ./views/login.php");
}

/**
 * Comprobamos si se ha pulsado el botón de cerrar sesión, si es así, lo redirigimos a la página de login y destruimos la sesión
 */
if(isset($_GET['cerrarsession'])){
    session_destroy();
    header("location: ./views/login.php");
}

/**
 * Comprobamos si se ha pulsado el botón de reservar
 */
if(isset($_GET['reservar'])) {
    $resultado = [
        'error' => false,
        'mensaje' => ''
    ];
    $config = include "database/config.php";
    
    /**
     * Comprobamos si el usuario ya tiene una reserva en ese asadero
     */
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $consultaSQL = "SELECT * FROM reservas WHERE idasadero = :idasadero AND idusuario = :idusuario";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(":idasadero", $_GET['idasadero']);
        $sentencia->bindParam(":idusuario", $_SESSION['usuario']['id']);
        $sentencia->execute();
        $reserva = $sentencia->fetchall();

        /** 
         * Si el usuario ya tiene una reserva en ese asadero, se muestra un mensaje de error
         * Si no, se comprueba si hay cupo en el asadero
         * Si hay cupo, se realiza la reserva
         */
        if($reserva){
            $resultado['error'] = true;
            $resultado['mensaje'] = 'Ya tienes una reserva en este asadero';
        } else {
            $consultaSQL = "SELECT maxpersonas FROM asaderos WHERE id = :idasadero";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(":idasadero", $_GET['idasadero']);
            $sentencia->execute();
            $asadero = $sentencia->fetch();
            
            $consultaSQL = "SELECT count(asaderos.id) as reservas FROM reservas INNER JOIN asaderos ON reservas.idasadero = asaderos.id WHERE reservas.idasadero = :idasadero";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(":idasadero", $_GET['idasadero']);
            $sentencia->execute();
            $reservas = $sentencia->fetch();

            /** 
             * Si hay cupo, se realiza la reserva
             */
            if ($reservas['reservas'] >= $asadero['maxpersonas']) {
                $resultado['error'] = true;
                $resultado['mensaje'] = 'No hay cupo en este asadero';
            } else {
                $consultaSQL = "INSERT INTO reservas (idasadero, idusuario) VALUES (:idasadero, :idusuario)";
                $sentencia = $conexion->prepare($consultaSQL);
                $sentencia->bindParam(":idasadero", $_GET['idasadero']);
                $sentencia->bindParam(":idusuario", $_SESSION['usuario']['id']);
                $sentencia->execute();
                header("location: index.php");
            }          
        }
    } catch(PDOException $error) {
        header("location: index.php");
    }
}


/**
 * Comprobamos si se ha pulsado el boton de submit del formulario de contacto
 */
if(isset($_POST['contact-submit'])) {
    enviaremail($_POST['contact-name'], $_POST['contact-email'], $_POST['contact-phone'], $_POST['contact-message']);
}


include "parts/header.php";?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">Asaderos Online</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#asaderos">Asaderos</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">Acerca de</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contacto">Contacto</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="index.php?cerrarsession">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Masthead-->
<header class="masthead text-white text-center">
    <div class="shadow container d-flex align-items-center flex-column">
        
        <?php
        /**
        * Si el usuario no es admin, se muestra el avatar normal, si es admin, se muestra el avatar con link a admin
        */
        if (!$_SESSION['usuario']['admin']) {
        ?>
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="src/assets/img/avataaars.svg" alt="..." />
        <?php
        } else{
        ?>
        <!-- Masthead Avatar Admin-->
        <a href="./views/admin/adminasaderos.php"><img class="masthead-avatar mb-5" src="src/assets/img/avataaars.svg" alt="..." /></a>
        <?php
        }
        ?>
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">Asaderos Online</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">Gestor de Asaderos Online</p>
        <p class="masthead-subheading font-weight-light mb-0">Invita a tus amigos :)</p>
    </div>
</header>

<!-- Asaderos Section-->
<section class="page-section portfolio" id="asaderos">
    <div class="container">
        <!-- Asaderos Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Asaderos</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Asaderos Grid Items-->
        <div class="row justify-content-center">
            <?php include "./views/verasaderos.php"; ?>
        </div>
        <?php
        if(isset($resultado) && $resultado['error']) {
        ?>
            <!-- MENSAJE DE ERROR -->
            <div class="container">
                <div class="alert alert-danger" role="alert">
                        <?= $resultado['mensaje'] ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- Mis Reservas -->
        <div class="d-flex justify-content-center">
            <a class="btn btn-primary btn-lg m-2 p-3" href="./views/misreservas.php">Mis Reservas</a>
        </div>
    </div>
</section>

<!-- Acerca de Section-->
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- Acerca de Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-white">Acerca de</h2>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Acerca de Section Content-->
        <div class="row">
            <div class="col-lg-4 ms-auto"><p class="lead">Esta página está hecha por el desarrollador web Edvin, como proyecto para la asignatura DSW.</p></div>
            <div class="col-lg-4 me-auto"><p class="lead">Se ha creado con HTML, CSS, JavaScript, MySQL y PHP.</p></div>
        </div>
        <!-- Acerca de Section Button-->
        <div class="text-center mt-4">
            <a class="btn btn-xl btn-outline-light" href="https://github.com/Edvintrabajo?tab=repositories" target="_blank">
                <i class="fas fa-download me-2"></i>
                Si quieres ver más proyecto mios, click aquí!
            </a>
        </div>
    </div>
</section>

<!-- Contacto Section-->
<section class="page-section" id="contacto">
    <div class="container">
        <!-- Contacto Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contacta Conmigo</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contacto Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form method="POST" action="<?= $_SERVER["PHP_SELF"] ?>" id="contactForm">
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" name="contact-name" id="contact-name" type="text" required placeholder="Introduce tu nombre..."/>
                        <label for="contact-name">Nombre</label>
                        <div class="invalid-feedback">El nombre es obligatorio.</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" name="contact-email" id="contact-email" type="email" required placeholder="nombre@ejemplo.com"/>
                        <label for="contact-email">Correo electrónico</label>
                        <div class="invalid-feedback">El email es obligatorio</div>
                        <div class="invalid-feedback" >Email no válido.</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" name="contact-phone" id="contact-phone" type="tel" required placeholder="666666666"/>
                        <label for="contact-phone">Número de teléfono</label>
                        <div class="invalid-feedback">El número de teléfono es obligatorio.</div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="contact-message" id="contact-message" type="text" required placeholder="Introduce tu mensaje aquí..." style="height: 10rem"></textarea>
                        <label for="contact-message">Mensaje</label>
                        <div class="invalid-feedback"">El mensaje es obligatorio.</div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Se ha enviado el mensaje correctamente!</div>
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error al enviar el mensaje!</div></div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit" name="contact-submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "parts/footer.php"; ?>