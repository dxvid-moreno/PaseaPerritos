<style>
.btn-estado {
  width: 120px;
  text-align: center;
  white-space: nowrap;
  font-size: 0.9rem;
}
.badge-estado {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 110px;
  height: 30px;
  font-size: 0.9rem;
  text-align: center;
}
</style>

<?php 
require_once(__DIR__ . "/../logica/Persona.php");
require_once(__DIR__ . "/../logica/Paseador.php");
require_once(__DIR__ . "/../persistencia/Conexion.php");

$filtro = isset($_GET["filtro"]) ? $_GET["filtro"] : "";

$paseador = new Paseador();
$conexion = new Conexion();
$conexion->abrir();

$sql = "SELECT idPaseador, nombre, correo, estado FROM Paseador
        WHERE nombre LIKE '%$filtro%' OR correo LIKE '%$filtro%'";
$conexion->ejecutar($sql);

$salida = "<table class='table table-striped table-hover mt-3'>";
$salida .= "<thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Estado</th><th>Acción</th></tr></thead><tbody>";

while ($datos = $conexion->registro()) {
    $id = $datos[0];
    $nombre = str_ireplace($filtro, "<strong>$filtro</strong>", $datos[1]);
    $correo = str_ireplace($filtro, "<strong>$filtro</strong>", $datos[2]);
    $estado = $datos[3];

    $estadoTexto = ($estado == 1)
        ? "<span class='badge bg-success badge-estado'>Habilitado</span>"
        : "<span class='badge bg-danger badge-estado'>Inhabilitado</span>";

    $botonEstado = ($estado == 1)
        ? "<button class='btn btn-sm btn-danger btn-estado cambiar-estado' data-id='$id' data-estado='0'>Inhabilitar</button>"
        : "<button class='btn btn-sm btn-success btn-estado cambiar-estado' data-id='$id' data-estado='1'>Habilitar</button>";

    $botonEditar = "<button class='btn btn-warning btn-sm btn-estado editar-paseador' data-id='$id'>Editar</button>";

    $salida .= "<tr>
                  <td>$id</td>
                  <td>$nombre</td>
                  <td>$correo</td>
                  <td>$estadoTexto</td>
                  <td>$botonEstado $botonEditar</td>
                </tr>";
}
$salida .= "</tbody></table>";
$conexion->cerrar();
echo $salida;
?>

<!-- Modal -->
<div class="modal fade" id="modalEditarPaseador" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditarPaseador" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Paseador</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="paseadorId">
          <div class="mb-3">
            <label for="nombrePaseador" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" id="nombrePaseador" required>
          </div>
          <div class="mb-3">
            <label for="correoPaseador" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo" id="correoPaseador" required>
          </div>
          <div class="mb-3">
            <label for="clavePaseador" class="form-label">Clave (dejar vacía para no cambiar)</label>
            <input type="password" class="form-control" name="clave" id="clavePaseador">
          </div>
          <div class="mb-3">
            <label for="descripcionPaseador" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcionPaseador"></textarea>
          </div>
          <div class="mb-3">
              <label for="valorHora" class="form-label">Tarifa por hora ($)</label>
              <input type="number" class="form-control" name="valor_hora" id="valorHora" required min="5000">
            </div>
          <div class="mb-3">
            <label for="fotoPaseador" class="form-label">Foto de perfil (opcional)</label>
            <input type="file" class="form-control" name="foto" id="fotoPaseador" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Mostrar modal de edición
  $(document).on('click', '.editar-paseador', function() {
    const id = $(this).data('id');
    $.get("ajax/obtenerPaseadorAjax.php", { id }, function(res) {
      const datos = JSON.parse(res);
      $("#paseadorId").val(datos.id);
      $("#nombrePaseador").val(datos.nombre);
      $("#correoPaseador").val(datos.correo);
      $("#descripcionPaseador").val(datos.descripcion || "");
      $("#clavePaseador").val("");
      $("#valorHora").val(datos.valor_hora);
      const modal = new bootstrap.Modal(document.getElementById('modalEditarPaseador'));
      modal.show();
    });
  });

  // Enviar cambios
  $("#formEditarPaseador").submit(function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      url: "ajax/actualizarPaseadorAjax.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(res) {
        alert(res);
        const modalElement = document.getElementById('modalEditarPaseador');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) modalInstance.hide();

        setTimeout(() => {
          $(".modal-backdrop").remove();
          $("body").removeClass("modal-open").css("padding-right", "");
        }, 300);

        $("#filtro").keyup();
      }
    });
  });

  // Cambiar estado
  $(document).on("click", ".cambiar-estado", function() {
    const id = $(this).data("id");
    const nuevoEstado = $(this).data("estado");
    $.post("ajax/cambiarEstadoPaseadorAjax.php", { id, estado: nuevoEstado }, function(res) {
      $("#filtro").keyup(); // Recargar resultados
    });
  });
});
</script>
