<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/FacturaDAO.php");

class Factura {
    private $id;
    private $id_factura;
    private $codigo_qr;
    private $fecha_emision;
    private $total;

    public function __construct($id = "", $codigo_qr = "", $fecha_emision = "", $total = "", $id_factura="") {
        $this->id = $id;
        $this->codigo_qr = $codigo_qr;
        $this->fecha_emision = $fecha_emision;
        $this->total = $total;
        $this->id_factura = $id_factura;
    }

    public function getId() {
        return $this->id;
    }

    public function getCodigoQR() {
        return $this->codigo_qr;
    }

    public function getFechaEmision() {
        return $this->fecha_emision;
    }

    public function getTotal() {
        return $this->total;
    }
    
    public function getIdFactura() {
        return $this->id_factura;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCodigoQR($codigo_qr) {
        $this->codigo_qr = $codigo_qr;
    }

    public function setFechaEmision($fecha_emision) {
        $this->fecha_emision = $fecha_emision;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
}
?>
