<?php
require_once("logica/Admin.php");
require_once("logica/Dueno.php");
require_once("logica/Paseador.php");

if (isset($_GET["sesion"]) && $_GET["sesion"] == "false") {
    session_destroy();
}

$error = false;

if (isset($_POST["autenticar"])) {
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    
    $admin = new Admin("", "", $correo, $clave);
    if ($admin->autenticar()) {
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        header("Location: ?pid=" . base64_encode("presentacion/admin/sesionAdmin.php"));
        exit;
    } else {
        $dueno = new Dueno("", "", $correo, $clave);
        if ($dueno->autenticar()) {
            $_SESSION["id"] = $dueno->getId();
            $_SESSION["rol"] = "dueno";
            header("Location: ?pid=" . base64_encode("presentacion/dueno/sesionDueno.php"));
            exit;
        } else {
            $paseador = new Paseador("", "", $correo, $clave);
            if ($paseador->autenticar()) {
                $_SESSION["id"] = $paseador->getId();
                $_SESSION["rol"] = "paseador";
                header("Location: ?pid=" . base64_encode("presentacion/paseador/sesionPaseador.php"));
                exit;
            } else {
                $error = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Autenticación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid" >
      <a class="navbar-brand" href="?pid=<?php echo base64_encode("presentacion/inicio.php") ?>">
        <img width="60" height="60" src="https://img.icons8.com/ios-filled/100/ffffff/dog-training.png" alt="Registro" />
      </a>
    </div>
  </nav>

  <div class="container my-5 d-flex justify-content-center align-items-start" style="min-height:70vh;">
    <div class="card shadow" style="max-width:420px; width:100%;">
      <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">Iniciar Sesión</h4>
      </div>
      <div class="card-body">
        <form action="?pid=<?php echo base64_encode("presentacion/autenticar.php"); ?>" method="post">
          <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input id="correo" type="email" name="correo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="clave" class="form-label">Clave</label>
            <input id="clave" type="password" name="clave" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary w-100" name="autenticar">Iniciar Sesión</button>
        </form>

        <?php if ($error): ?>
          <div class="alert alert-danger mt-4 text-center">
            Credenciales incorrectas
          </div>
        <?php endif; ?>
      </div>
      <div class="card-footer text-center">
        <a href="?pid=<?php echo base64_encode("presentacion/nuevoUsuario.php"); ?>" class="btn btn-secondary">Registrarse</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
