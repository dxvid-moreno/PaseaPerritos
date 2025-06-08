<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/PagoDAO.php");

class Pago {
    private $id;
    private $factura;
    private $estadoPago;
    private $fecha_pago;
    private $monto_pagado;

    public function __construct($id = "", $factura = null, $estadoPago = null, $fecha_pago = "", $monto_pagado = "") {
        $this->id = $id;
        $this->factura = $factura;
        $this->estadoPago = $estadoPago;
        $this->fecha_pago = $fecha_pago;
        $this->monto_pagado = $monto_pagado;
    }

    public function getId() {
        return $this->id;
    }

    public function getFactura() {
        return $this->factura;
    }

    public function getEstadoPago() {
        return $this->estadoPago;
    }

    public function getFechaPago() {
        return $this->fecha_pago;
    }

    public function getMontoPagado() {
        return $this->monto_pagado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFactura($factura) {
        $this->factura = $factura;
    }

    public function setEstadoPago($estadoPago) {
        $this->estadoPago = $estadoPago;
    }

    public function setFechaPago($fecha_pago) {
        $this->fecha_pago = $fecha_pago;
    }

    public function setMontoPagado($monto_pagado) {
        $this->monto_pagado = $monto_pagado;
    }
}
?>
