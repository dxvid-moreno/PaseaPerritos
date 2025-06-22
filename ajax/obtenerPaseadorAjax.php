<?php
require_once("../logica/Paseador.php");

if (isset($_GET["id"])) {
    $p = new Paseador($_GET["id"]);
    $p->consultar();
    echo json_encode([
        "id" => $p->getId(),
        "nombre" => $p->getNombre(),
        "correo" => $p->getCorreo(),
        "descripcion" => $p->getDescripcion()
    ]);
}
