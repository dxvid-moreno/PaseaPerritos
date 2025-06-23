<?php
include("presentacion/encabezado.php");
require_once("logica/Perrito.php");

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $raza = $_POST["raza"];
    $edad = $_POST["edad"];
    $dueno = $_SESSION["id"];
    $foto_url = "";
    
    // Procesar la imagen
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        if (!file_exists("imagenes/perritos")) {
            mkdir("imagenes/perritos", 0755, true);
        }
        
        $rutaTemporal = $_FILES["foto"]["tmp_name"];
        $nombreArchivo = basename($_FILES["foto"]["name"]);
        $destino = "imagenes/perritos/" . time() . "_" . $nombreArchivo;
        
        if (move_uploaded_file($rutaTemporal, $destino)) {
            $foto_url = $destino;
        }
    }
    
    // Crear y guardar el perrito
    $perrito = new Perrito("", $nombre, $raza, $foto_url, $edad, $dueno);
    $dao = new PerritoDAO("", $nombre, $raza, $foto_url, $edad, $dueno);
    
    $conexion = new Conexion();
    $conexion->abrir();
    $conexion->ejecutar($dao->insertar());
    $conexion->cerrar();
    
    $msg = "¡Perrito registrado exitosamente!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Perrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="card mx-auto shadow" style="max-width: 500px;">
    <div class="card-header bg-success text-white text-center">
      <h4 class="mb-0">Registrar Nuevo Perrito</h4>
    </div>
    <div class="card-body">

      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="raza" class="form-label">Raza</label>
          <input type="text" class="form-control" id="raza" name="raza" required>
        </div>
        <div class="mb-3">
          <label for="edad" class="form-label">Edad</label>
          <input type="number" class="form-control" id="edad" name="edad" min="0" required>
        </div>
        <div class="mb-3">
          <label for="foto" class="form-label">Foto del Perrito</label>
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success w-100">Registrar</button>
      </form>
    </div>
    <div class="container">
    <?php if ($msg): ?>
        <div class="alert alert-success text-center"><?php echo $msg; ?></div>
      <?php endif; ?>
      </div>
    <div class="card-footer text-center">
      <a href="?pid=<?php echo base64_encode("presentacion/dueno/misPerritos.php"); ?>" class="btn btn-secondary">Ver Mis Perritos</a>
    </div>
  </div>
</div>

</body>
</html>
