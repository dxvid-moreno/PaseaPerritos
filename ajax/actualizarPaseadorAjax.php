<?php
require_once("../logica/Paseador.php");
require_once("../logica/TarifaPaseador.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $descripcion = $_POST["descripcion"];
    $valor_hora = $_POST["valor_hora"];
    
    $paseador = new Paseador($id);
    $paseador->consultar(); // Cargar datos actuales
    
    $paseador->setNombre($nombre);
    $paseador->setCorreo($correo);
    $paseador->setDescripcion($descripcion);
    $paseador->setDescripcion($valor_hora);
    if (!empty($clave)) {
        $paseador->setClave($clave);
    }
    
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
    
    $paseador->actualizar();
    
    // Consultar tarifa actual
    $tarifaActual = new TarifaPaseador("", $id);
    $tarifaActual->consultarActualPorPaseador();
    
    // Insertar nueva tarifa solo si cambia
    if ($tarifaActual->getValorHora() != $valor_hora) {
        // Cerrar tarifa anterior
        if ($tarifaActual->getId()) {
            $dao = new TarifaPaseadorDAO(
                $tarifaActual->getId(),
                $id,
                $tarifaActual->getValorHora(),
                $tarifaActual->getFechaInicio(),
                date("Y-m-d") // Fecha fin de la anterior
                );
            $conexion = new Conexion();
            $conexion->abrir();
            $conexion->ejecutar($dao->actualizar());
            $conexion->cerrar();
        }
        
        // Insertar nueva tarifa
        $nuevaTarifa = new TarifaPaseador(
            "", $id, $valor_hora, date("Y-m-d"), null
            );
        $nuevaTarifa->insertar();
    }
    
    echo "Paseador actualizado correctamente";
} else {
    echo "Error: método no permitido";
}
