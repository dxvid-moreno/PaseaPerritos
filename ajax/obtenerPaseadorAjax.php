<?php
require_once("../logica/Paseador.php");
require_once("../logica/TarifaPaseador.php");

if (isset($_GET["id"])) {
    $p = new Paseador($_GET["id"]);
    $p->consultar();
    $tarifa = new TarifaPaseador("", $p->getId());
    $tarifa->consultarActualPorPaseador();
    $valorHora = $tarifa->getValorHora();
    
    echo json_encode([
        "id" => $p->getId(),
        "nombre" => $p->getNombre(),
        "correo" => $p->getCorreo(),
        "descripcion" => $p->getDescripcion(),
        "valor_hora" => $valorHora
    ]);
}
