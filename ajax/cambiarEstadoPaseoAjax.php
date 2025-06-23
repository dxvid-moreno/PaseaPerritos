<?php
require_once("../logica/Paseo.php");
require_once("../logica/EstadoPaseo.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idPaseo = intval($_POST["id"]);
    $nuevoEstado = intval($_POST["estado"]);
    
    $paseo = new Paseo($idPaseo);
    $paseo->cambiarEstado($nuevoEstado);
    
    $mensajes = [
        1 => "Paseo aceptado.",
        2 => "Paseo marcado como realizado.",
        3 => "Paseo cancelado.",
        4 => "Paseo rechazado.",
        5 => "Paseo marcado como pendiente."
    ];
    
    echo $mensajes[$nuevoEstado] ?? "Estado actualizado.";
} else {
    echo "Solicitud inválida.";
}
