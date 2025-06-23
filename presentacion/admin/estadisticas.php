<?php
include("presentacion/encabezado.php");
require_once("logica/Paseo.php");

$paseo = new Paseo();
$data = $paseo->obtenerEstadisticas();

$resumen = $data["resumen"];
$porPaseador = $data["porPaseador"];
$porEstado = $data["porEstado"];
?>

<div class="container mt-5">
    <h2 class="mb-4">Estadísticas de Paseos</h2>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Resumen General</div>
        <div class="card-body">
            <p><strong>Total de Paseos:</strong> <?= $resumen[0] ?></p>
            <p><strong>Duración Promedio:</strong> <?= round($resumen[2], 2) ?> minutos</p>
            <p><strong>Ingresos Totales:</strong> $<?= number_format($resumen[1], 0, ',', '.') ?></p>
            <p><strong>Desde:</strong> <?= $resumen[3] ?> <strong>hasta:</strong> <?= $resumen[4] ?></p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Top Paseadores con Más Paseos</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($porPaseador as $p): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $p[0] ?>
                        <span class="badge bg-primary "><?= $p[1] ?> paseos</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-success text-white">Distribución por Estado</div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($porEstado as $item): ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        CANTIDAD TOTAL DE PASEOS REGISTRADOS
                        <span class="badge bg-success"><?= $item["cantidad"] ?></span>
                    </div>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
