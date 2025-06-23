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

if ($estado > 0) {
    $paseos = $paseo->consultarPorEstado($estado, $rol, $id);
} else {
    $paseos = $paseo->consultarTodosPorRol($rol, $id);
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
    switch ($p->getEstadoPaseo()->getId()) {
        case 1:
            echo '<button class="btn btn-sm btn-danger cancelar-paseo" data-id="' . $p->getId() . '">Cancelar</button>';
            break;
        case 2:
            echo '<span class="text-success">Realizado</span>';
            break;
        case 3:
            echo '<span class="text-danger">Cancelado</span>';
            break;
        default:
            echo '-';
    }
    echo "</td>";
    echo "</tr>";
}

if (count($paseos) === 0) {
    echo "<tr><td colspan='8' class='text-center'>No hay paseos disponibles.</td></tr>";
}
