<?php 
require_once(__DIR__ . "/../logica/Persona.php");
require_once(__DIR__ . "/../logica/Paseador.php");
require_once(__DIR__ . "/../persistencia/Conexion.php");


$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";

$paseador = new Paseador();
$conexion = new Conexion();
$conexion->abrir();

$sql = "SELECT idPaseador, nombre, correo FROM Paseador 
        WHERE nombre LIKE '%$filtro%'";
$conexion->ejecutar($sql);

$salida = "";
if ($conexion->filas() > 0) {
    $salida .= "<table class='table table-striped table-hover mt-3'>";
    $salida .= "<thead><tr><th>ID</th><th>Nombre</th><th>Correo</th></tr></thead><tbody>";
    while ($datos = $conexion->registro()) {
        $nombreResaltado = str_ireplace($filtro, "<strong>" . $filtro . "</strong>", $datos[1]);
        $correoResaltado = str_ireplace($filtro, "<strong>" . $filtro . "</strong>", $datos[2]);
        $salida .= "<tr><td>{$datos[0]}</td><td>{$nombreResaltado}</td><td>{$correoResaltado}</td></tr>";
    }
    $salida .= "</tbody></table>";
} else {
    $salida .= "<div class='alert alert-danger mt-3'>No se encontraron paseadores</div>";
}

$conexion->cerrar();
echo $salida;
?>
