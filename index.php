<?php 
 session_start();
 require ("logica/Persona.php");
 require ("logica/Admin.php");
 require ("logica/Dueno.php");
 require ("logica/EstadoPago.php");
 require ("logica/EstadoPaseo.php");
 require ("logica/Factura.php");
 require ("logica/Pago.php");
 require ("logica/Paseador.php");
 require ("logica/Paseo.php");
 require ("logica/Perrito.php");
 require ("logica/TarifaPaseador.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Paseo Perritos</title>

<!-- Bootstrap -->
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">

<!-- FontAwesome -->
<link href="https://use.fontawesome.com/releases/v6.7.2/css/all.css"
	rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" ></script>
</head>
<?php 
if(!isset($_GET["pid"])){
    include ("presentacion/inicio.php");
}else{
    include (base64_decode($_GET["pid"]));
}    
?>
</html>