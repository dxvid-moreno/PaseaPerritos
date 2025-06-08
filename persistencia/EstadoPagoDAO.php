<?php

class EstadoPagoDAO {
    private $id;
    private $nombre;

    public function __construct($id = 0, $nombre = "") {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function consultarTodos() {
        return "SELECT idEstadoPago, nombre FROM EstadoPago";
    }

    public function consultar() {
        return "SELECT nombre FROM EstadoPago WHERE idEstadoPago = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO EstadoPago (nombre) VALUES ('" . $this->nombre . "')";
    }

    public function actualizar() {
        return "UPDATE EstadoPago SET nombre = '" . $this->nombre . "' WHERE idEstadoPago = '" . $this->id . "'";
    }
}
?>
