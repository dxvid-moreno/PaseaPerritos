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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <!-- Logo y marca -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://img.icons8.com/ios-filled/100/ffffff/dog-training.png" alt="DogGo" width="40" height="40" class="me-2" />
            <span class="fw-bold">DogGo</span>
        </a>

        <!-- Botón para colapsar menú en dispositivos pequeños -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item me-2">
                    <a class="nav-link nav-btn" href="?pid=<?php echo base64_encode("presentacion/autenticar.php"); ?>">
                        
                        Iniciar Sesión
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-btn" href="?pid=<?php echo base64_encode("presentacion/nuevoUsuario.php"); ?>">
                        
                        Registrarse
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body class="bg-light">

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

<script>
document.querySelector("form").addEventListener("submit", function (e) {
    const correo = document.getElementById("correo").value.trim();
    const clave = document.getElementById("clave").value.trim();

    if (correo === "" || clave === "") {
        alert("Los campos no pueden estar vacíos ni tener solo espacios.");
        e.preventDefault();
        return;
    }

    // Validación adicional: no permitir espacios en medio del correo o clave
    if (/\s/.test(correo) || /\s/.test(clave)) {
        alert("Los campos no deben contener espacios.");
        e.preventDefault();
    }
});
</script>

</html>