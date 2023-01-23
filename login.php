<?php
session_start();

if(isset($_SESSION['usuario'])) {
    header("location: index.php");
}

try {
    if (isset($_POST["signin"])) {
        $resultado = [
            'error' => false,
            'mensaje' => 'Datos introducidos incorrectos'
        ];
        $config = include 'database/config.php';
    
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $consultaSQL = "SELECT * FROM usuarios WHERE nombre = :nombre";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(":nombre", $_POST["your_name"]);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($_POST["your_pass"], $usuario['contrasena'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
        } else {
            $resultado['error'] = true;
        }
    }
} catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'Error al iniciar sesión';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar sesión</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="src/fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="src/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Main css -->
    <link rel="stylesheet" href="src/css/signstyles.css">
</head>
<body>

    <div class="main">
        <!-- MENSAJE DE ERROR -->
        <?php
        if(isset($resultado) && $resultado['error']) {
        ?>
            <div class="container">
                <div class="alert alert-danger" role="alert">
                        <?= $resultado['mensaje'] ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="src/assets/img/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Crear una cuenta</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Iniciar sesión</h2>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="your_name" id="your_name" placeholder="Tu nombre"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="your_pass" id="your_pass" placeholder="Contraseña"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Iniciar sesión"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>