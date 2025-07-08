<?php 
include ("presentacion/encabezado.php");
?>
<div class="container mt-5">
    <h4 class="card-title">Buscar Paseador</h4>
    <input type="text" class="form-control" id="filtro" placeholder="Buscar por nombre o correo de paseador" autocomplete="off" />
    <button class="btn btn-secondary mt-2" id="btnConsultarTodos">Consultar todos</button>
    <div id="resultados" class="mt-3"></div>
</div>

<script>
$(document).ready(function(){
    // Búsqueda en tiempo real
    $("#filtro").keyup(function(){
        if ($("#filtro").val().length > 2) {
            var ruta = "ajax/buscarPaseadorAjax.php?filtro=" + encodeURIComponent($("#filtro").val());
            console.log(ruta);
            $("#resultados").load(ruta);
        } else {
            $("#resultados").load("ajax/buscarPaseadorAjax.php?filtro="); 
        }
    });

    // Evento delegado para los botones de cambiar estado
    $("#resultados").on("click", ".cambiar-estado", function() {
        const id = $(this).data("id");
        const nuevoEstado = $(this).data("estado");

        $.ajax({
            url: "ajax/cambiarEstadoPaseadorAjax.php",
            type: "POST",
            data: { id: id, estado: nuevoEstado },
            success: function(respuesta) {
                if (respuesta.trim() === "ok") {
                    $("#filtro").trigger("keyup");
                } else {
                    alert("Error al cambiar el estado");
                }
            },
            error: function() {
                alert("Error de red al intentar cambiar el estado");
            }
        });
    });
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });
    
    $("#btnConsultarTodos").click(function() {
    $("#filtro").val("");
    $("#resultados").load("ajax/buscarPaseadorAjax.php?filtro=");
});
    
});
</script>


