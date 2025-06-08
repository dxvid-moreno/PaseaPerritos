<?php

class TarifaPaseadorDAO {
    private $id;
    private $paseador;    // idPaseador
    private $valor_hora;
    private $fecha_inicio;
    private $fecha_fin;

    public function __construct($id = 0, $paseador = 0, $valor_hora = "", $fecha_inicio = "", $fecha_fin = "") {
        $this->id = $id;
        $this->paseador = $paseador;
        $this->valor_hora = $valor_hora;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function consultar() {
        return "SELECT idPaseador, valor_hora, fecha_inicio, fecha_fin
                FROM TarifaPaseador
                WHERE idTarifaPaseador = '" . $this->id . "'";
    }

    public function consultarActualPorPaseador() {
        return "SELECT idTarifaPaseador, valor_hora
                FROM TarifaPaseador
                WHERE idPaseador = '" . $this->paseador . "'
                  AND (fecha_fin IS NULL OR fecha_fin >= CURDATE())
                ORDER BY fecha_inicio DESC
                LIMIT 1";
    }

    public function insertar() {
        return "INSERT INTO TarifaPaseador (idPaseador, valor_hora, fecha_inicio, fecha_fin)
                VALUES ('" . $this->paseador . "', '" . $this->valor_hora . "', '" . $this->fecha_inicio . "', " .
                ($this->fecha_fin == "" ? "NULL" : "'" . $this->fecha_fin . "'") . ")";
    }

    public function actualizar() {
        return "UPDATE TarifaPaseador
                SET idPaseador = '" . $this->paseador . "',
                    valor_hora = '" . $this->valor_hora . "',
                    fecha_inicio = '" . $this->fecha_inicio . "',
                    fecha_fin = " . ($this->fecha_fin == "" ? "NULL" : "'" . $this->fecha_fin . "'") . "
                WHERE idTarifaPaseador = '" . $this->id . "'";
    }
}
?>
