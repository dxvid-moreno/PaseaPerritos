<?php
include("presentacion/encabezado.php");
$paseador = new Paseador();
$paseadores = $paseador->consultarTodos();
?>
<br>
<br>
<h2 style="text-align:center; color:#2e7d32;">Elige un Paseador para tu perrito</h2>

<style>
.img-paseador {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ccc;
}
</style>

<div class="container mt-4">
    <div class="row">
        <?php 
        foreach ($paseadores as $item) {
            $paseador = $item["paseador"];
            $tarifa = $item["tarifa"];
            ?>
            <div class="card mb-3">
                <div class="row g-0 align-items-center">
                    <div class="col-auto p-3">
                        <img src="<?= $paseador->getFotoUrl() ?>" class="img-paseador" alt="Sin imagen">
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <h5 class="card-title"><?= $paseador->getNombre() ?></h5>
                            <p class="card-text"><?= $paseador->getDescripcion() ?></p>
                            <p class="card-text"><strong>Precio/hora:</strong> $<?= number_format($tarifa->getValorHora(), 2) ?></p>
                            <a href='index.php?pid=<?= base64_encode("presentacion/dueno/crearReserva.php") ?>&idPaseador=<?= $paseador->getId() ?>' class='btn btn-success'>Reservar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
