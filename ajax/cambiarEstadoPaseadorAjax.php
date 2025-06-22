<?php
require_once(__DIR__ . "/../logica/Paseador.php");

if (isset($_POST['id']) && isset($_POST['estado'])) {
    $id = intval($_POST['id']);
    $estado = intval($_POST['estado']);

    $p = new Paseador($id);
    $p->consultar();
    $p->setEstado($estado);
    $p->actualizar();

    echo "ok";
} else {
    echo "error";
}
