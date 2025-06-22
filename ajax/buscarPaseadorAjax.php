<style>
.btn-estado {
  width: 120px;         
  text-align: center;
  white-space: nowrap;
  font-size: 0.9rem;    
}
.badge-estado {
  display: inline-flex;
  align-items: center;      
  justify-content: center;  
  width: 110px;
  height: 30px; 
  font-size: 0.9rem;      
} text-align: center;

</style>
<?php 
require_once(__DIR__ . "/../logica/Persona.php");
require_once(__DIR__ . "/../logica/Paseador.php");
require_once(__DIR__ . "/../persistencia/Conexion.php");


$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";

$paseador = new Paseador();
$conexion = new Conexion();
$conexion->abrir();

$sql = "SELECT idPaseador, nombre, correo, estado FROM Paseador
        WHERE nombre LIKE '%$filtro%' OR correo LIKE '%$filtro%'";

$conexion->ejecutar($sql);

$salida = "";
$salida .= "<table class='table table-striped table-hover mt-3'>";
$salida .= "<thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Estado</th><th>Acción</th></tr></thead>";

while ($datos = $conexion->registro()) {
    $id = $datos[0];
    $nombre = str_ireplace($filtro, "<strong>$filtro</strong>", $datos[1]);
    $correo = str_ireplace($filtro, "<strong>$filtro</strong>", $datos[2]);
    $estado = $datos[3];
    
    $estadoTexto = ($estado == 1)
    ? "<span class='badge bg-success badge-estado'>Habilitado</span>"
        : "<span class='badge bg-danger badge-estado'>Inhabilitado</span>";
        
        $boton = ($estado == 1)
        ? "<button class='btn btn-sm btn-danger btn-estado cambiar-estado' data-id='$id' data-estado='0'>Inhabilitar</button>"
        : "<button class='btn btn-sm btn-success btn-estado cambiar-estado' data-id='$id' data-estado='1'>Habilitar</button>";
        $salida .= "<tr>
                  <td>$id</td>
                  <td>$nombre</td>
                  <td>$correo</td>
                  <td>$estadoTexto</td>
                  <td>$boton</td>
                </tr>";
}

$salida .= "</tbody></table>";

$conexion->cerrar();
echo $salida;
?>
