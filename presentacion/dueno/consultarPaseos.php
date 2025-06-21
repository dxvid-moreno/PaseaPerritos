<?php
include("presentacion/encabezado.php");
require_once("logica/Paseo.php");
require_once("logica/EstadoPaseo.php");
require_once("logica/Paseador.php");
require_once("logica/Perrito.php");
require_once("logica/Dueno.php");

$id = $_SESSION["id"];
$rol = $_SESSION["rol"];

// Obtener estado desde GET
$estado = isset($_GET["estado"]) ? intval($_GET["estado"]) : 0;

// Crear instancia de Paseo
$paseo = new Paseo();

// Consultar paseos según el estado
if ($estado > 0) {
    $paseos = $paseo->consultarPorEstado($estado, $rol, $id);
} else {
    $paseos = $paseo->consultarTodosPorRol($rol, $id);
}

// Definir estados
$estados = [
    0 => 'Todos',
    1 => 'Reservados',
    2 => 'Realizados',
    3 => 'Cancelados'
];

$colores = [
    0 => 'primary',
    1 => 'success',
    2 => 'secondary',
    3 => 'danger'
];
?>

<div class="container mt-5">
    <form method="get" class="mb-3">
        <input type="hidden" name="pid" value="<?php echo $_GET["pid"]; ?>">
        <div class="btn-group" role="group" aria-label="Filtro de estado">
            <?php
            foreach ($estados as $key => $label) {
                $active = ($estado == $key) ? 'active' : '';
                echo '<button type="submit" name="estado" value="' . $key . '" class="btn btn-outline-' . $colores[$key] . ' ' . $active . '">' . $label . '</button>';
            }
            ?>
        </div>
    </form>
    


    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Paseador</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($paseos) > 0) {
                foreach ($paseos as $p) {
                    echo "<tr>";
                    echo "<td>" . $p->getFecha() . "</td>";
                    echo "<td>" . $p->getHoraInicio() . "</td>";
                    echo "<td>" . $p->getHoraFin() . "</td>";
                    echo "<td>" . $p->getPaseador()->getNombre() . "</td>";
                    echo "<td>$" . number_format($p->getTarifa(), 0, ',', '.') . "</td>";
                    echo "<td>" . $p->getEstadoPaseo()->getNombre() . "</td>";
                    echo "<td>aqui va ajax</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay paseos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
