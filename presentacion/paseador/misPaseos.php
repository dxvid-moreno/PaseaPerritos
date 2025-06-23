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

$paseos = $estado > 0
    ? $paseo->consultarPorEstado($estado, $rol, $id)
    : $paseo->consultarTodosPorRol($rol, $id);

$estados = [
    0 => 'Reservado',
    1 => 'Realizado',
    2 => 'Cancelado',
    3 => 'Rechazado',
    4 => 'Pendiente'
];

$colores = [
    0 => 'primary',
    1 => 'success',
    2 => 'danger',
    3 => 'secondary',
    4 => 'warning'
];
?>

<div class="container mt-5">
    <div class="mb-3">
        <div class="btn-group" role="group" id="botones-estado">
            <button class="btn btn-outline-dark" data-estado="0">Todos</button>
            <?php foreach ($estados as $key => $label): ?>
                <button class="btn btn-outline-<?= $colores[$key] ?>" data-estado="<?= $key + 1 ?>"><?= $label ?></button>
            <?php endforeach; ?>
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
            <!-- Se cargará dinámicamente con JS -->
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabla = document.getElementById("tabla-paseos");

    function cargarPaseos(estado) {
        fetch("ajax/cargarPaseosAjax.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `estado=${estado}`
        })
        .then(res => res.text())
        .then(html => {
            tabla.innerHTML = html;
            activarAcciones();
        });
    }

    function cambiarEstado(idPaseo, estadoNuevo, mensajeConfirmacion) {
        if (confirm(mensajeConfirmacion)) {
            fetch("ajax/cambiarEstadoPaseoAjax.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${idPaseo}&estado=${estadoNuevo}`
            })
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                cargarPaseos(0); // recargar todos
            });
        }
    }

    function activarAcciones() {
        document.querySelectorAll(".cancelar-paseo").forEach(btn =>
            btn.addEventListener("click", () =>
                cambiarEstado(btn.dataset.id, 3, "¿Cancelar este paseo?")
            )
        );
        document.querySelectorAll(".realizar-paseo").forEach(btn =>
            btn.addEventListener("click", () =>
                cambiarEstado(btn.dataset.id, 2, "¿Marcar como realizado?")
            )
        );
        document.querySelectorAll(".aceptar-paseo").forEach(btn =>
            btn.addEventListener("click", () =>
                cambiarEstado(btn.dataset.id, 1, "¿Aceptar este paseo?")
            )
        );
        document.querySelectorAll(".rechazar-paseo").forEach(btn =>
            btn.addEventListener("click", () =>
                cambiarEstado(btn.dataset.id, 4, "¿Rechazar este paseo?")
            )
        );
    }

    document.querySelectorAll("button[data-estado]").forEach(btn =>
        btn.addEventListener("click", () => cargarPaseos(btn.dataset.estado))
    );

    cargarPaseos(0); // inicial
});
</script>
