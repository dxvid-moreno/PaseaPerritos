<?php
include ("presentacion/encabezado.php");
?>
<div class="container mt-5">
    <h4 class="card-title">Buscar Perrito</h4>
    <input type="text" class="form-control" id="filtro" placeholder="Nombre o raza del perrito" autocomplete="off" />
    <div id="resultados" class="mt-3"></div>
</div>

<script>
$(document).ready(function(){
    $("#filtro").keyup(function(){
        if ($("#filtro").val().length > 2) {
            var ruta = "ajax/buscarPerritoAjax.php?filtro=" + encodeURIComponent($("#filtro").val());
            console.log(ruta);
            $("#resultados").load(ruta);
        } else {
            $("#resultados").empty();
        }
    });
});
</script>
