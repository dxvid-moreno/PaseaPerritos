<?php
require_once("../logica/Paseo.php");
require_once("../logica/EstadoPaseo.php");
require_once("../logica/Paseador.php");
require_once("../logica/Perrito.php");
require_once("../logica/Dueno.php");

session_start();
$rol = $_SESSION["rol"];
$id = $_SESSION["id"];
$estado = isset($_POST["estado"]) ? intval($_POST["estado"]) : 0;

$paseo = new Paseo();
$paseos = $estado > 0
? $paseo->consultarPorEstado($estado, $rol, $id)
: $paseo->consultarTodosPorRol($rol, $id);

if (count($paseos) === 0) {
    echo "<tr><td colspan='8' class='text-center'>No hay paseos disponibles.</td></tr>";
    exit;
}

foreach ($paseos as $p) {
    echo "<tr>";
    echo "<td>" . $p->getFecha() . "</td>";
    echo "<td>" . $p->getPerrito()->getNombre() . "</td>";
    echo "<td>" . $p->getHoraInicio() . "</td>";
    echo "<td>" . $p->getHoraFin() . "</td>";
    echo "<td>" . $p->getPaseador()->getNombre() . "</td>";
    echo "<td>$" . number_format($p->getTarifa(), 0, ',', '.') . "</td>";
    echo "<td>" . $p->getEstadoPaseo()->getNombre() . "</td>";
    echo "<td>";
    
    $estadoId = $p->getEstadoPaseo()->getId();
    
    // Acciones dinámicas
    if ($estadoId == 5 && $rol == "paseador") {
        echo '<button class="btn btn-sm btn-primary aceptar-paseo" data-id="' . $p->getId() . '">Aceptar</button> ';
        echo '<button class="btn btn-sm btn-secondary rechazar-paseo" data-id="' . $p->getId() . '">Rechazar</button>';
    } elseif ($estadoId == 1 && $rol == "dueno") {
        echo '<button class="btn btn-sm btn-danger cancelar-paseo" data-id="' . $p->getId() . '">Cancelar</button>';
    } elseif ($estadoId == 1 && $rol == "paseador") {
        echo '<button class="btn btn-sm btn-success realizar-paseo" data-id="' . $p->getId() . '">Realizar</button>';
    } elseif ($estadoId == 2) {
        echo '<span class="text-success">Realizado</span>';
    } elseif ($estadoId == 3) {
        echo '<span class="text-danger">Cancelado</span>';
    } elseif ($estadoId == 4) {
        echo '<span class="text-secondary">Rechazado</span>';
    } elseif ($estadoId == 5) {
        echo '<span class="text-warning">Pendiente</span>';
    } else {
        echo '-';
    }
    
    echo "</td></tr>";
}
