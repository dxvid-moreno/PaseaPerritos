<?php
include("presentacion/encabezado.php");
require_once("logica/Factura.php");

$idDueno = $_SESSION["id"]; 
$facturaObj = new Factura();
$facturas = $facturaObj->consultarPorDueno($idDueno);
?>

<div class="container mt-5">
    <h2 class="mb-4">Mis Facturas</h2>

    <?php if (count($facturas) > 0): ?>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha de Paseo</th>
                <th>Hora</th>
                <th>Perrito</th>
                <th>Total</th>
                <th>QR</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturas as $f): ?>
            <tr>
                <td><?= $f->datos["fecha_paseo"] ?></td>
                <td><?= $f->datos["hora_inicio"] ?></td>
                <td><?= $f->datos["nombre_perrito"] ?></td>
                <td>$<?= number_format($f->getTotal(), 0, ',', '.') ?></td>
                <td>
                    <?php if (file_exists($f->getCodigoQR())): ?>
                        <img src="<?= $f->getCodigoQR() ?>" alt="QR" width="60">
                    <?php else: ?>
                        <span class="text-muted">No disponible</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($f->getUrlPdf()): ?>
                        <a href="<?= $f->getUrlPdf() ?>" target="_blank" class="btn btn-sm btn-outline-primary">Ver PDF</a>
                    <?php else: ?>
                        <span class="text-muted">No generado</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-info">No hay facturas disponibles.</div>
    <?php endif; ?>
</div>
