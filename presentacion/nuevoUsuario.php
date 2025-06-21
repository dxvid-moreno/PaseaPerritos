<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("logica/Dueno.php");
require_once("logica/Paseador.php");
require_once("logica/Admin.php");
require_once("logica/TarifaPaseador.php");
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rol = $_POST['rol'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    
    if (!empty($rol) && !empty($nombre) && !empty($correo) && !empty($clave)) {
        if ($rol == "dueno") {
            $d = new Dueno("", $nombre, $correo, $clave);
            if ($d->existeCorreo($correo)) {
                $msg = "Error: Ya existe un correo asociado a otro dueño";
            } else {
                $d->insertar();
                header("Location: ?pid=" . base64_encode("presentacion/autenticar.php"));
                exit;
            }
        } elseif ($rol == "paseador") {
            $tarifa = $_POST['tarifa'];
            $descripcion = $_POST['descripcion'];
            $foto_url = "";
            
            if (!file_exists("imagenes/paseadores")) {
                mkdir("imagenes/paseadores", 0755, true);
            }
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $rutaTemporal = $_FILES['foto']['tmp_name'];
                $nombreArchivo = basename($_FILES['foto']['name']);
                $destino = "imagenes/paseadores/" . time() . "_" . $nombreArchivo;
                
                if (move_uploaded_file($rutaTemporal, $destino)) {
                    $foto_url = $destino;
                }
            }
            
            $p = new Paseador("", $nombre, $correo, $clave, $foto_url, $descripcion);
            
            if ($p->existeCorreo($correo)) {
                $msg = "Error: Ya existe un correo asociado a otro paseador";
            } else {
                $p->insertar();
                $idPaseadorNuevo = $p->obtenerUltimoId();
                $fechaInicio = date("Y-m-d");
                $t = new TarifaPaseador("", $idPaseadorNuevo, $tarifa,$fechaInicio);
                $t->insertar();
                header("Location: ?pid=" . base64_encode("presentacion/autenticar.php"));
                exit;
            }
        }
    } else {
        $msg = "Error: Debes completar todos los campos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro Global</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script>
    function mostrarCampos() {
      var rol = document.getElementById('rol').value;
      document.getElementById('tarifaField').style.display = (rol === 'paseador') ? 'block' : 'none';
      document.getElementById('descripcionField').style.display = (rol === 'paseador') ? 'block' : 'none';
      document.getElementById('fotoField').style.display = (rol === 'paseador') ? 'block' : 'none';
    }
  </script>
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://img.icons8.com/ios-filled/100/ffffff/dog-training.png" alt="DogGo" width="40" height="40" class="me-2" />
            <span class="fw-bold">DogGo</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item me-2">
                    <a class="nav-link nav-btn" href="?pid=<?php echo base64_encode("presentacion/autenticar.php"); ?>">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="?pid=<?php echo base64_encode("presentacion/nuevoUsuario.php"); ?>">Registrarse</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body class="bg-light">
  <div class="container my-5 d-flex justify-content-center align-items-start" style="min-height:70vh;">
    <div class="card shadow" style="max-width:500px; width:100%;">
      <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">Registro Global</h4>
      </div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data" oninput="mostrarCampos()">
          <div class="mb-3">
            <label for="rol" class="form-label">Seleccionar Rol</label>
            <select id="rol" name="rol" class="form-select" required onchange="mostrarCampos()">
              <option value="">-- Seleccionar --</option>
              <option value="dueno">Dueño</option>
              <option value="paseador">Paseador</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input id="nombre" type="text" name="nombre" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input id="correo" type="email" name="correo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="clave" class="form-label">Clave</label>
            <input id="clave" type="password" name="clave" class="form-control" required />
          </div>
          <div class="mb-3" id="tarifaField" style="display:none;">
            <label for="tarifa" class="form-label">Tarifa por hora ($)</label>
            <input id="tarifa" type="number" name="tarifa" class="form-control" min="0" />
          </div>
          <div class="mb-3" id="descripcionField" style="display:none;">
            <label for="descripcion" class="form-label">Descripción del Paseador</label>
            <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-3" id="fotoField" style="display:none;">
            <label for="foto" class="form-label">Foto de perfil</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
          </div>
          <button type="submit" class="btn btn-success w-100">Registrar</button>
        </form>
        <?php if (!empty($msg)): ?>
          <div class="alert alert-<?php echo (strpos($msg, "Error") !== false ? "danger" : "success"); ?> mt-4 text-center">
            <?php echo $msg; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="card-footer text-center">
        <a href="?pid=<?php echo base64_encode("presentacion/inicio.php"); ?>" class="btn btn-secondary">Regresar al inicio</a>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
