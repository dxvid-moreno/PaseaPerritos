<?php
require_once("../logica/Paseador.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $descripcion = $_POST["descripcion"];
    
    $paseador = new Paseador($id);
    $paseador->consultar(); // Carga datos actuales
    
    $paseador->setNombre($nombre);
    $paseador->setCorreo($correo);
    $paseador->setDescripcion($descripcion);
    
    // Si se envía una nueva clave, actualizarla
    if (!empty($clave)) {
        $paseador->setClave($clave);
    }
    
    // Si se sube una nueva imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        if (!file_exists("../imagenes/paseadores")) {
            mkdir("../imagenes/paseadores", 0755, true);
        }
        
        $rutaTemporal = $_FILES['foto']['tmp_name'];
        $nombreArchivo = basename($_FILES['foto']['name']);
        $destino = "../imagenes/paseadores/" . time() . "_" . $nombreArchivo;
        
        if (move_uploaded_file($rutaTemporal, $destino)) {
            $paseador->setFotoUrl($destino);
        }
    }
    
    // Guardar cambios
    $paseador->actualizar();
    echo "Paseador actualizado correctamente";
} else {
    echo "Error: método no permitido";
}
