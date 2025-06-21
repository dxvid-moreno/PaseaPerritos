<?php

class TarifaPaseadorDAO {
    private $id;
    private $paseador;
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
        return "SELECT idPaseador, valor_hora, fecha_inicio_vigencia, fecha_fin_vigencia
                FROM TarifaPaseador
                WHERE idTarifa = '" . $this->id . "'";
    }
    
    public function consultarActualPorPaseador() {
        $idPaseador = is_object($this->paseador) ? $this->paseador->getId() : $this->paseador;
        
        return "SELECT idTarifa, valor_hora
            FROM TarifaPaseador
            WHERE idPaseador = '" . $idPaseador . "'
              AND (fecha_fin_vigencia IS NULL OR fecha_fin_vigencia >= CURDATE())
            ORDER BY fecha_inicio_vigencia DESC
            LIMIT 1";
    }
    
    public function insertar() {
        return "INSERT INTO TarifaPaseador (idPaseador, valor_hora, fecha_inicio_vigencia, fecha_fin_vigencia)
                VALUES (
                    '" . $this->paseador . "',
                    '" . $this->valor_hora . "',
                    '" . $this->fecha_inicio . "',
                    " . ($this->fecha_fin == "" ? "NULL" : "'" . $this->fecha_fin . "'") . "
                )";
    }
    
    public function actualizar() {
        return "UPDATE TarifaPaseador
                SET idPaseador = '" . $this->paseador . "',
                    valor_hora = '" . $this->valor_hora . "',
                    fecha_inicio_vigencia = '" . $this->fecha_inicio . "',
                    fecha_fin_vigencia = " . ($this->fecha_fin == "" ? "NULL" : "'" . $this->fecha_fin . "'") . "
                WHERE idTarifa = '" . $this->id . "'";
    }
}
?>
