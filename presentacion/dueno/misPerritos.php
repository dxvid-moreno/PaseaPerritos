<?php
include("presentacion/encabezado.php");
$id = $_SESSION["id"];
$perrito = new Perrito("", "", "", "","", $id);
$lista = $perrito->consultarPorDueno();

$msg = "";
if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    unset($_SESSION["msg"]);
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editar_id"])) {
    
    $idPerrito = $_POST["editar_id"];
    $nombre = $_POST["editar_nombre"];
    $raza = $_POST["editar_raza"];
    $edad = $_POST["editar_edad"];
    $foto_url = $_POST["foto_actual"]; // valor por defecto
    
    if (isset($_FILES["editar_foto"]) && $_FILES["editar_foto"]["error"] === UPLOAD_ERR_OK) {
        if (!file_exists("imagenes/perritos")) {
            mkdir("imagenes/perritos", 0755, true);
        }
        $nombreArchivo = basename($_FILES["editar_foto"]["name"]);
        $rutaTemporal = $_FILES["editar_foto"]["tmp_name"];
        $destino = "imagenes/perritos/" . time() . "_" . $nombreArchivo;
        if (move_uploaded_file($rutaTemporal, $destino)) {
            $foto_url = $destino;
        }
    }
    
    $perrito = new Perrito($idPerrito, $nombre, $raza, $foto_url, $edad, $_SESSION["id"]);
    $dao = new PerritoDAO($idPerrito, $nombre, $raza, $foto_url, $edad, $_SESSION["id"]);
    
    $conexion = new Conexion();
    $conexion->abrir();
    $conexion->ejecutar($dao->actualizar());
    $conexion->cerrar();
    
    $_SESSION["msg"] = "Perrito actualizado correctamente.";
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar_id"])) {
    $idEliminar = $_POST["eliminar_id"];
    
    $conexion = new Conexion();
    $conexion->abrir();
    
    // Verificar si tiene paseos
    $verificarSQL = "SELECT COUNT(*) FROM Paseo WHERE idPerrito = '$idEliminar'";
    $conexion->ejecutar($verificarSQL);
    $resultado = $conexion->registro();
    
    if ($resultado[0] > 0) {
        $_SESSION["msg"] = "No se puede eliminar el perrito porque tiene paseos registrados.";
    } else {
        // Eliminar perrito
        $dao = new PerritoDAO($idEliminar);
        $conexion->ejecutar("DELETE FROM Perrito WHERE idPerrito = '$idEliminar'");
        $_SESSION["msg"] = "Perrito eliminado correctamente.";
    }
    
    $conexion->cerrar();
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Perritos</title>
    <style>
        .perritos-container {
            max-width: 800px;
            margin: 40px auto;
        }

        .perrito-card {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }

        .foto img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }

        .info {
            flex: 1;
            margin-left: 20px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }
    </style>
</head>
<body>

<h2>Mis Perritos Registrados</h2>
<div style="text-align: center; margin-bottom: 20px;">
    <a href="?pid=<?php echo base64_encode("presentacion/dueno/anadirPerrito.php"); ?>" class="btn btn-primary">+ Añadir Nuevo Perrito</a>
</div>
<div class="container">
                <?php if ($msg): ?>
                  <div class="alert alert-info text-center"><?= $msg ?></div>
                <?php endif; ?>
            </div>
<div class="perritos-container">
    <?php if (count($lista) === 0): ?>
        <p style="text-align:center;">No tienes perritos registrados aún.</p>
    <?php else: ?>
        <?php foreach ($lista as $p): ?>
            <div class="perrito-card">
                <div class="foto">
                    <img src="<?= htmlspecialchars($p->getFotoUrl()) ?>" alt="Sin Imagen">
                </div>
                <div class="info">
                    <h3><?= htmlspecialchars($p->getNombre()) ?></h3>
                    <p><strong>Raza:</strong> <?= htmlspecialchars($p->getRaza()) ?></p>
                    <p><strong>Edad:</strong> <?= htmlspecialchars($p->getEdad()) ?> año(s)</p>
                    <p><strong>ID:</strong> <?= htmlspecialchars($p->getId()) ?></p>
                </div>
                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarModal<?= $p->getId() ?>">Editar</button>
                <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este perrito?');" style="display:inline-block; margin-left: 10px;">
                    <input type="hidden" name="eliminar_id" value="<?= $p->getId() ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </div>
            <div class="modal fade" id="editarModal<?= $p->getId() ?>" tabindex="-1">
              <div class="modal-dialog">
                <form method="POST" enctype="multipart/form-data" class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar Perrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="editar_id" value="<?= $p->getId() ?>">
                    <input type="hidden" name="foto_actual" value="<?= $p->getFotoUrl() ?>">
            
                    <div class="mb-3">
                      <label>Nombre</label>
                      <input type="text" name="editar_nombre" class="form-control" value="<?= htmlspecialchars($p->getNombre()) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Raza</label>
                      <input type="text" name="editar_raza" class="form-control" value="<?= htmlspecialchars($p->getRaza()) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Edad</label>
                      <input type="number" name="editar_edad" class="form-control" value="<?= htmlspecialchars($p->getEdad()) ?>" required>
                    </div>
                    <div class="mb-3">
                      <label>Foto</label>
                      <input type="file" name="editar_foto" class="form-control" accept="image/*">
                      <small class="text-muted">Dejar vacío si no desea cambiar la imagen.</small>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>
            </div>
            
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
