<?php
require_once("../logica/Paseo.php");
require_once("../logica/EstadoPaseo.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idPaseo = intval($_POST["id"]);
    $nuevoEstado = intval($_POST["estado"]);

    $paseo = new Paseo($idPaseo);
    $paseo->cambiarEstado($nuevoEstado); // Asegúrate que este método exista

    echo "Paseo cancelado correctamente.";
} else {
    echo "Solicitud inválida.";
}
