<?php
if (isset($_POST["submit"])) {
    $resultado = [
        'error' => false,
        'mensaje' => 'El asadero ' . $_POST['nombre'] . ' ha sido actualizado con éxito'
    ];
    $config = include '../database/config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $lugar = $_POST["lugar"];
        $fecha = $_POST["fecha"];
        $descripcion = $_POST["descripcion"];
        $precio = $_POST["precio"];
        $maxpersonas = $_POST["maxpersonas"];
        $consultaSQL = "UPDATE asaderos SET nombre = :nombre, lugar = :lugar, fecha = :fecha, descripcion = :descripcion, precio = :precio, maxpersonas = :maxpersonas WHERE id = :id";
        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->bindParam(":id", $id);
        $sentencia->bindParam(":nombre", $nombre);
        $sentencia->bindParam(":lugar", $lugar);
        $sentencia->bindParam(":fecha", $fecha);
        $sentencia->bindParam(":descripcion", $descripcion);
        $sentencia->bindParam(":precio", $precio);
        $sentencia->bindParam(":maxpersonas", $maxpersonas);

        $sentencia->execute();
    } catch(PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = $error->getMessage();
    }
}
?>

<?php include "../parts/adminheader.php"; ?>

<?php
if(isset($resultado)) {
?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
               <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0 text-center mt-4">Editar asadero con el id = <?= $_REQUEST["id"] ?></h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
           <hr>
           
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <input type="hidden" name="id" value="<?= $_REQUEST["id"]?>">
                <div class="form-group mb-3">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required value="<?= $_REQUEST["nombre"]?>">
                </div>
                <div class="form-group mb-3">
                    <label for="lugar">Lugar:</label>
                    <input type="text" class="form-control" name="lugar" id="lugar" required value="<?= $_REQUEST["lugar"]?>">
                </div>
                <div class="d-flex justify-content-between flex-wrap mb-3">
                    <div class="form-group mb-3">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" name="fecha" id="fecha" required value="<?= $_REQUEST["fecha"]?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="precio">Precio:</label>
                        <input type="number" class="form-control" name="precio" id="precio" min="1" required value="<?= $_REQUEST["precio"]?>">
                    </div>
                    <div class="form-group mb-3">
                        <label for="maxpersonas">Máximo de personas:</label>
                        <input type="number" class="form-control" name="maxpersonas" id="maxpersonas" min="1" required value="<?= $_REQUEST["maxpersonas"]?>">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" style="height: 10rem" required><?= $_REQUEST["descripcion"] ?></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type="submit" class="btn btn-primary mt-2" name="submit" value="Actualizar">
                    <a class="btn btn-primary mt-2" href="adminasaderos.php">Regresar al inicio</a>
                </div>
            </form>
        </div>
    </div>
</div>