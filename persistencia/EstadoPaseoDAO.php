<?php

class EstadoPaseoDAO {
    private $id;
    private $nombre;

    public function __construct($id = 0, $nombre = "") {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function consultarTodos() {
        return "SELECT idEstadoPaseo, nombre FROM EstadoPaseo";
    }

    public function consultar() {
        return "SELECT nombre FROM EstadoPaseo WHERE idEstadoPaseo = '" . $this->id . "'";
    }

    public function insertar() {
        return "INSERT INTO EstadoPaseo (nombre) VALUES ('" . $this->nombre . "')";
    }

    public function actualizar() {
        return "UPDATE EstadoPaseo SET nombre = '" . $this->nombre . "' WHERE idEstadoPaseo = '" . $this->id . "'";
    }
}
?>
