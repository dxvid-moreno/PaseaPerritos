<?php
include("presentacion/encabezado.php");
require_once("logica/Paseo.php");
require_once("logica/EstadoPaseo.php");
require_once("logica/Paseador.php");
require_once("logica/Perrito.php");
require_once("logica/Dueno.php");

$id = $_SESSION["id"];
$rol = $_SESSION["rol"];

$estado = isset($_GET["estado"]) ? intval($_GET["estado"]) : 0;

$paseo = new Paseo();

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
    <div class="mb-3">
        <div class="btn-group" role="group" aria-label="Filtro de estado" id="botones-estado">
            <?php
            foreach ($estados as $key => $label) {
                echo '<button type="button" data-estado="' . $key . '" class="btn btn-outline-' . $colores[$key] . '">' . $label . '</button>';
            }
            ?>
        </div>
    </div>

    


    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Perrito</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Paseador</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="tabla-paseos">
            <?php
            if (count($paseos) > 0) {
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
                    if ($p->getEstadoPaseo()->getId() == 1) { // Solo cuando está Reservado
                        echo '<button class="btn btn-sm btn-danger cancelar-paseo" data-id="' . $p->getId() . '">Cancelar</button>';
                    } elseif ($p->getEstadoPaseo()->getId() == 3) {
                        echo '<span class="text-danger">Cancelado</span>';
                    } elseif ($p->getEstadoPaseo()->getId() == 2) {
                        echo '<span class="text-success">Realizado</span>';
                    } else {
                        echo '-';
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No hay paseos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabla = document.getElementById("tabla-paseos");

    function cargarPaseos(estado) {
        fetch("ajax/cargarPaseosAjax.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `estado=${estado}`
        })
        .then(res => res.text())
        .then(html => {
            tabla.innerHTML = html;
            activarBotonesCancelar();
        });
    }

    function activarBotonesCancelar() {
        document.querySelectorAll(".cancelar-paseo").forEach(boton => {
            boton.addEventListener("click", function() {
                const idPaseo = this.getAttribute("data-id");
                if (confirm("¿Estás seguro de que deseas cancelar este paseo?")) {
                    fetch("ajax/cambiarEstadoPaseoAjax.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `id=${idPaseo}&estado=3`
                    })
                    .then(res => res.text())
                    .then(msg => {
                        alert(msg);
                        cargarPaseos(0);
                    });
                }
            });
        });
    }

    document.querySelectorAll("button[data-estado]").forEach(btn => {
        btn.addEventListener("click", function() {
            const estado = this.getAttribute("data-estado");
            cargarPaseos(estado);
        });
    });
    activarBotonesCancelar();

});
</script>


