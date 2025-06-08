<?php

class PagoDAO {
    private $id;
    private $factura;       // idFactura (entero)
    private $fecha_pago;
    private $valor;
    private $estadoPago;    // idEstadoPago (entero)

    public function __construct($id = 0, $factura = 0, $fecha_pago = "", $valor = "", $estadoPago = 0) {
        $this->id = $id;
        $this->factura = $factura;
        $this->fecha_pago = $fecha_pago;
        $this->valor = $valor;
        $this->estadoPago = $estadoPago;
    }

    public function consultar() {
        return "SELECT idFactura, fecha_pago, valor, idEstadoPago
                FROM Pago
                WHERE idPago = '" . $this->id . "'";
    }

    public function consultarPorFactura() {
        return "SELECT idPago, fecha_pago, valor, idEstadoPago
                FROM Pago
                WHERE idFactura = '" . $this->factura . "'";
    }

    public function insertar() {
        return "INSERT INTO Pago (idFactura, fecha_pago, valor, idEstadoPago)
                VALUES ('" . $this->factura . "', '" . $this->fecha_pago . "', '" . $this->valor . "', '" . $this->estadoPago . "')";
    }

    public function actualizar() {
        return "UPDATE Pago
                SET idFactura = '" . $this->factura . "',
                    fecha_pago = '" . $this->fecha_pago . "',
                    valor = '" . $this->valor . "',
                    idEstadoPago = '" . $this->estadoPago . "'
                WHERE idPago = '" . $this->id . "'";
    }
}
?>
