<?php
    include("presentacion/encabezado.php");
    
    require_once("logica/Perrito.php");
    require_once("logica/Paseo.php");
    
    $idDueno = $_SESSION["id"];
    $idPaseador = $_GET["idPaseador"] ?? null;
    
    if (!$idPaseador) {
        echo "<p class='alert alert-warning'>Debes seleccionar un paseador.</p>";
        exit;
    }
    
    $perrito = new Perrito("", "", "", "","", $idDueno);
    $perritos = $perrito->consultarPorDueno();
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $tarifa = new TarifaPaseador("", $idPaseador);
        $tarifa->consultarActualPorPaseador();
        $idTarifa = $tarifa->getId();         // ✔️ ID de la tarifa
        $valorHora = $tarifa->getValorHora(); // ✔️ Valor por hora
        
        $factura = new Factura("", "", date("Y-m-d"), $valorHora);
        $precio = ((int)$_POST['duracion'] / 60) * (float)$valorHora;
        $paseo = new Paseo(
            "",
            $_POST['fecha'],
            $_POST['hora_inicio'],
            $_POST['duracion'],
            $_POST['idPerrito'],
            $idDueno,
            $idPaseador,
            1,          
            $idTarifa,
            "",          
            $precio      
            );
        
        
        $resultado = $paseo->insertarConValidacion();
    }
?>

<!-- Formulario -->
<h2 class="text-center text-primary mt-5">Reservar Paseo</h2>

<form method="POST" class="container mt-4" style="max-width: 600px;">
    <div class="mb-3">
        <label class="form-label">Selecciona tu perrito:</label>
        <select name="idPerrito" class="form-select" required>
            <?php foreach ($perritos as $p): ?>
                <option value="<?= $p->getId() ?>"><?= $p->getNombre() ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha:</label>
        <input type="date" name="fecha" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Hora de inicio:</label>
        <input type="time" name="hora_inicio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duración del paseo (minutos):</label>
        <input type="number" name="duracion" class="form-control" max="180" step="60" required>
    </div>

    <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
</form>

<div class ="container">
<?php if (isset($resultado)): ?>
    <div class="alert <?= $resultado["ok"] ? 'alert-success' : 'alert-danger' ?> mt-3 text-center">
        <?= $resultado["mensaje"] ?>
    </div>
<?php endif; ?>
</div>

