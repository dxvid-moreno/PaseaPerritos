<?php

class PaseoDAO {
    private $id;
    private $perrito;
    private $paseador;
    private $estadoPaseo;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $tarifa;
    private $duracion;
    private $precio;
    
    
    public function __construct($id = 0, $perrito = 0, $paseador = 0, $estadoPaseo = 0, $fecha = "", $hora_inicio = "", $hora_fin = "", $tarifa = "", $precio = "", $duracion = "") {
        $this->id = $id;
        $this->perrito = $perrito;
        $this->paseador = $paseador;
        $this->estadoPaseo = $estadoPaseo;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->tarifa = $tarifa;
        $this->precio = $precio;
        $this->duracion = $duracion;
    }
    
    
    public function insertar() {
        $idPerrito = is_object($this->perrito) ? $this->perrito->getId() : $this->perrito;
        $idPaseador = is_object($this->paseador) ? $this->paseador->getId() : $this->paseador;
        $idEstado = is_object($this->estadoPaseo) ? $this->estadoPaseo->getId() : $this->estadoPaseo;
        $idTarifa = ($this->tarifa === null ? "NULL" : "'" . $this->tarifa . "'");
        
        return "INSERT INTO Paseo (idPerrito, idPaseador, idEstadoPaseo, fecha, hora_inicio, hora_fin, idTarifa, precio, duracion_minutos)
        VALUES (
            '$idPerrito',
            '$idPaseador',
            '$idEstado',
            '$this->fecha',
            '$this->hora_inicio',
            '$this->hora_fin',
            $idTarifa,
            '$this->precio',
            '$this->duracion'
        )";
            
    }
    
    public function consultarPaseosSimultaneos($fecha, $hora_inicio, $hora_fin, $idPaseador) {
        $id = is_object($idPaseador) ? $idPaseador->getId() : $idPaseador;
        
        return "SELECT COUNT(*) as cantidad
                FROM Paseo
                WHERE idPaseador = '$id'
                AND fecha = '$fecha'
                AND (
                    (hora_inicio < '$hora_fin' AND hora_fin > '$hora_inicio')
                )";
    }

    public function consultar() {
        return "SELECT idPerrito, idPaseador, idEstadoPaseo, fecha, hora_inicio, hora_fin, idFactura
                FROM Paseo
                WHERE idPaseo = '" . $this->id . "'";
    }

    public function consultarPorDueno($idDueno) {
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin, pa.nombre AS paseador_nombre, tp.valor_hora, ep.nombre AS estado_paseo
                FROM Paseo p
                INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
                INNER JOIN Paseador pa ON p.idPaseador = pa.idPaseador
                INNER JOIN TarifaPaseador tp ON tp.idPaseador = pa.idPaseador
                INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
                WHERE pe.idDueno = '" . $idDueno . "'
                ORDER BY p.fecha DESC, p.hora_inicio DESC";
    }

    public function consultarPorPaseador($idPaseador) {
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin, pe.nombre AS perrito_nombre, d.nombre AS dueno_nombre, tp.valor_hora, ep.nombre AS estado_paseo
                FROM Paseo p
                INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
                INNER JOIN Dueno d ON pe.idDueno = d.idDueno
                INNER JOIN TarifaPaseador tp ON tp.idPaseador = p.idPaseador
                INNER JOIN Estado_Paseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
                WHERE p.idPaseador = '" . $idPaseador . "'
                ORDER BY p.fecha DESC, p.hora_inicio DESC";
    }
    public function actualizar() {
        return "UPDATE Paseo
                SET idPerrito = '" . $this->perrito . "',
                    idPaseador = '" . $this->paseador . "',
                    idEstadoPaseo = '" . $this->estadoPaseo . "',
                    fecha = '" . $this->fecha . "',
                    hora_inicio = '" . $this->hora_inicio . "',
                    hora_fin = '" . $this->hora_fin . "',
                    idFactura = " . ($this->factura === null ? "NULL" : "'" . $this->factura . "'") . "
                WHERE idPaseo = '" . $this->id . "'";
    }

    public function consultarPorEstado($estadoId, $rol, $usuarioId) {
        $filtro = "";
        
        if ($rol == "dueno") {
            $filtro = "AND pe.idDueno = '$usuarioId'";
        } else if ($rol == "paseador") {
            $filtro = "AND p.idPaseador = '$usuarioId'";
        }
        
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin,
           pe.nombre AS perrito_nombre, d.nombre AS dueno_nombre,
           pa.nombre AS paseador_nombre, ep.idEstadoPaseo, ep.nombre AS estado_paseo, tp.valor_hora
        FROM Paseo p
        INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
        INNER JOIN Dueno d ON pe.idDueno = d.idDueno
        INNER JOIN Paseador pa ON p.idPaseador = pa.idPaseador
        INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
        INNER JOIN TarifaPaseador tp 
            ON tp.idPaseador = pa.idPaseador AND tp.fecha_fin_vigencia IS NULL
        WHERE p.idEstadoPaseo = '$estadoId'
        $filtro
        ORDER BY p.fecha DESC, p.hora_inicio DESC";
        
    }
    
    public function consultarTodosPorRol($rol, $usuarioId) {
        $filtro = "";
        
        if ($rol == "dueno") {
            $filtro = "WHERE pe.idDueno = '$usuarioId'";
        } else if ($rol == "paseador") {
            $filtro = "WHERE p.idPaseador = '$usuarioId'";
        }
        
        return "SELECT p.idPaseo, p.fecha, p.hora_inicio, p.hora_fin,
               pe.nombre AS perrito_nombre, d.nombre AS dueno_nombre,
               pa.nombre AS paseador_nombre, ep.idEstadoPaseo, ep.nombre AS estado_paseo, tp.valor_hora

        FROM Paseo p
        INNER JOIN Perrito pe ON p.idPerrito = pe.idPerrito
        INNER JOIN Dueno d ON pe.idDueno = d.idDueno
        INNER JOIN Paseador pa ON p.idPaseador = pa.idPaseador
        INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
        INNER JOIN TarifaPaseador tp ON tp.idPaseador = pa.idPaseador
        $filtro
        ORDER BY p.fecha DESC, p.hora_inicio DESC";
    }
    
    public function actualizarEstado() {
        return "UPDATE paseo SET idEstadoPaseo = " . $this->estadoPaseo->getId() . " WHERE idPaseo = " . $this->id;
    }
    
    public function obtenerResumenEstadisticas() {
        return "
        SELECT
            COUNT(*) AS total_paseos,
            SUM(precio) AS total_ingresos,
            AVG(duracion_minutos) AS duracion_promedio,
            MIN(fecha) AS fecha_inicio,
            MAX(fecha) AS fecha_fin
        FROM Paseo
    ";
    }
    
    public function paseosPorPaseador() {
        return "
        SELECT pa.nombre, COUNT(*) AS cantidad
        FROM Paseo p
        INNER JOIN Paseador pa ON p.idPaseador = pa.idPaseador
        GROUP BY pa.nombre
        ORDER BY cantidad DESC
        LIMIT 5
    ";
    }
    
    public function paseosPorEstado() {
        return "
        SELECT ep.nombre AS estado, COUNT(*) AS cantidad
        FROM Paseo p
        INNER JOIN EstadoPaseo ep ON p.idEstadoPaseo = ep.idEstadoPaseo
        GROUP BY ep.nombre
        ORDER BY cantidad DESC
    ";
    }
    
    
}
?>
