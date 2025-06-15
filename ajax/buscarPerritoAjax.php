<?php
session_start();
require_once(__DIR__ . "/../logica/Perrito.php");
require_once(__DIR__ . "/../persistencia/Conexion.php");

if (!isset($_SESSION["id"]) || !isset($_SESSION["rol"])) {
    echo "<div class='alert alert-danger'>Debes iniciar sesión para buscar perritos.</div>";
    exit();
}

$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";
$idUsuario = $_SESSION["id"];
$rol = $_SESSION["rol"];

$conexion = new Conexion();
$conexion->abrir();

if ($rol == "admin") {
    // Admin ve todos los perritos
    $sql = "SELECT p.idPerrito, d.idDueno, p.nombre, p.raza, p.edad, p.foto_url
            FROM Perrito p
            JOIN Dueno d ON d.idDueno = p.idDueno
            WHERE p.nombre LIKE '%$filtro%' OR p.raza LIKE '%$filtro%'";
} elseif ($rol == "dueno") {
    // Dueño solo ve sus perritos
    $sql = "SELECT p.idPerrito, p.nombre, p.raza, p.edad, p.foto_url
            FROM Perrito p
            WHERE p.idDueno = '$idUsuario'
            AND (p.nombre LIKE '%$filtro%' OR p.raza LIKE '%$filtro%')";
} else {
    echo "<div class='alert alert-danger'>Rol no autorizado para esta acción.</div>";
    $conexion->cerrar();
    exit();
}

$conexion->ejecutar($sql);

$salida = "";
if ($conexion->filas() > 0) {
    $salida .= "<table class='table table-striped table-hover mt-3'>";
    $salida .= "<thead><tr>";
    $salida .= "<th>ID</th>";
    if ($rol == "admin") {
        $salida .= "<th>ID Dueño</th>";
    }
    $salida .= "<th>Nombre</th><th>Raza</th><th>Edad</th><th>Foto</th></tr></thead><tbody>";
    
    while ($datos = $conexion->registro()) {
        $nombreResaltado = str_ireplace($filtro, "<strong>$filtro</strong>", $rol == "admin" ? $datos[2] : $datos[1]);
        
        $salida .= "<tr>";
        $salida .= "<td>{$datos[0]}</td>";
        if ($rol == "admin") {
            $salida .= "<td>{$datos[1]}</td>"; // idDueno
            $salida .= "<td>$nombreResaltado</td>";
            $salida .= "<td>{$datos[3]}</td><td>{$datos[4]}</td><td><img src='{$datos[5]}' width='80' height='80'></td>";
        } else {
            $salida .= "<td>$nombreResaltado</td>";
            $salida .= "<td>{$datos[2]}</td><td>{$datos[3]}</td><td><img src='{$datos[4]}' width='80' height='80'></td>";
        }
        $salida .= "</tr>";
    }
    
    $salida .= "</tbody></table>";
} else {
    $salida .= "<div class='alert alert-warning mt-3'>No se encontraron perritos.</div>";
}

$conexion->cerrar();
echo $salida;
