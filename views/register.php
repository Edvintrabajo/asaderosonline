<?php
/**
 * File: register.php
 * Date: 27/04/2021
 * Description: Vista del formulario de registro
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

/**
 * Comprobamos si el usuario ya está logueado, si es así, lo redirigimos a la página principal
 */
if(isset($_SESSION['usuario'])) {
    header("location: ../index.php");
}

/**
 * Iniciamos la conexión a la base de datos y manejamos los errores
 */
try {

    /**
     * Comprobamos si se ha pulsado el botón de registrarse
     */
    if (isset($_POST["signup"])) {
        $config = include '../database/config.php';
        include '../utils/functions.php';

        $resultado = validateregister($_POST["name"], $_POST["pass"], $_POST["re_pass"], $_POST["email"], $_POST["telefono"]);
        /** 
         * Validamos los datos introducidos en el formulario
         */
        if (!$resultado['error']) {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $consultaSQL = "SELECT * FROM usuarios WHERE email = :emailaux";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(":emailaux", $_POST["email"]);
            $sentencia->execute();
            $resultadoaux = $sentencia->fetchAll();
            
            $consultaSQL = "SELECT * FROM usuarios WHERE telefono = :telefonoaux";
            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->bindParam(":telefonoaux", $_POST["telefono"]);
            $sentencia->execute();
            $resultadoaux2 = $sentencia->fetchAll();

            /** 
             * Comprobamos si el email o el telefono ya existen en la base de datos
             * Si es así, mostramos un mensaje de error
             * Si no hay errores, insertamos el usuario en la base de datos
             */
            if ($resultadoaux) {
                $resultado['error'] = true;
                $resultado['mensaje'] = 'El email ya existe';
            } else if ($resultadoaux2) {
                $resultado['error'] = true;
                $resultado['mensaje'] = 'El telefono ya existe';
            } else {
                $consultaSQL = "INSERT INTO usuarios (nombre, contrasena, telefono, email) VALUES (:nombre, :contrasena, :telefono, :email)";
                $password_hash = password_hash($_POST["pass"], PASSWORD_DEFAULT);
                $sentencia = $conexion->prepare($consultaSQL);
                $sentencia->bindParam(":nombre", $_POST["name"]);
                $sentencia->bindParam(":contrasena", $password_hash);
                $sentencia->bindParam(":telefono", $_POST["telefono"]);
                $sentencia->bindParam(":email", $_POST["email"]);
                $sentencia->execute();
                header("Location: ../index.php");
            }
        }
    }
} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error al registarse';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear una cuenta</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="../src/fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../src/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Main css -->
    <link rel="stylesheet" href="../src/css/signstyles.css">
</head>
<body>

    <div class="main">
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
        <!-- FORMULARIO DE REGISTRO -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Crear una cuenta</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Tu nombre"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Tu email"/>
                            </div>
                            <div class="form-group">
                                <label for="telefono"><i class="zmdi zmdi-phone"></i></label>
                                <input type="telefono" name="telefono" id="telefono" placeholder="Tu telefono"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Contraseña"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repite tu contraseña"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Registrarse"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="../src/assets/img/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">Ya tengo cuenta</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>