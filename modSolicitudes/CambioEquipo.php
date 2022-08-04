<?php 
$pagNom = 'EQUIPOS';
?>

<?php include("../public/header.php"); ?>
<!-- MAESTRO -->
<?php if ($idTipoUsuario == 3) { ?>

  <?php
  include("../database.php");

  $solicitudAL = new database();   //instanciar el objeto

  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $idGrupo =  $solicitudAL->sanitize($_POST['idGrupo']);
    $alumnoN = $solicitudAL->sanitize($_POST['alumnoN']);
    $razon =  $solicitudAL->sanitize($_POST['razon']);
    $idLaboratorio = $solicitudAL->sanitize($_POST['idLaboratorio']);
    $res = $solicitudAL->createSolicitudAL($idGrupo, 2, $alumnoN, $razon, $idLaboratorio, "Pendiente");

    if ($res) {
      $message = "Datos insertados con exito";
      $class = "alert alert-success";
    } else {
      $message = "No se pudieron insertar los datos... ";
      $class = "alert alert-danger";
    }
  ?>
    	<div class="<?php echo $class ?>">
		<?php echo $message; ?>
	</div>
  <?php
  }

  ?>


  <!--Botón de registro -->
  <a type="button" class="btn btn-outline-dark" href="#RSolicitudCambio" data-bs-toggle="modal">Solicitar cambio de equipo</a></br></br>



<!-- Mostrar tabla-->
<div class="container">
  <table  class="table table-bordered " cellspacing="0" width="100%" id="miEquipoTable" style="background-color: #04aa89;  ">
    <thead>
      <!-- Secciones o cabeceros -->
      <tr >
        <!-- filas -->
        <?php echo "Equipos asignados por laboratorio: " ?> <br>
        <th>Equipo lab IoT</th>
        <th>Equipo lab desarrollo</th>
        <th>Equipo lab Soporte</th>
      </tr> 
    </thead>

    <tbody>
      <!-- Cuerpo de la tabla, se llena con la BDD-->
      <?php
      $equiposAsignadosAl =  $solicitudAL->equiposA(); 
      ?>

      <?php
      while ($row = mysqli_fetch_object($equiposAsignadosAl)) { 
        //antes del = es la variable del form, después es la de BDD
        
        $nombreCAlum= $row->nombreC;
        if ($_SESSION['nombreC'] ==  $nombreCAlum) {
        $nombreGrupo = $row->nombreGrupo;
        $idEquipoIOT=$row->equipoIOT;
          $idEquipoDesarrollo=$row->equipoDesarrollo;
          $idEquipoSoporte=$row->equipoSoporte;
      ?>
        <tr >
          <td><?php if ($idEquipoIOT==0){ echo 'No aplica'; } else{echo $idEquipoIOT; }?></td>
          <td><?php if ($idEquipoDesarrollo==0){ echo 'No aplica'; } else{echo $idEquipoDesarrollo; }?></td>
          <td><?php if ($idEquipoSoporte==0){ echo 'No aplica'; } else{echo $idEquipoSoporte; }?></td>

        </tr>
        <?php } ?>
        <?php
      } 
      ?>
    </tbody>
  </table>
</div>


  <div class="modal fade" id="RSolicitudCambio" tabindex="-1" aria-labelledby="RegistroGrupo" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Solicitar cambio de equipo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>
                <input type="hidden" name="alumnoN" id="alumnoN" class="form-control" required value="<?php echo  $_SESSION['nombreC']; ?>">

                  <label> Elige el laboratorio </label>
                  <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio" required>
                    <option value="">Selecciona una Laboratorio</option>
                    <?php
                    $listaSolicitudesAL = $solicitudAL->readLaboratorioS('nombreLaboratorio');
                    while ($row = mysqli_fetch_object($listaSolicitudesAL)) {
                      $idLaboratorio = $row->idLaboratorio;
                      $nombreLaboratorio = $row->nombreLaboratorio; ?>
                      <option value="<?php echo $idLaboratorio; ?>"><?php echo $nombreLaboratorio; ?></option>
                    <?php } ?>
                  </select>

                  <input type="hidden" name="idGrupo" id="idGrupo" class="form-control" required value="<?php echo $nombreGrupo; ?>">

                  <label>Motivo:</label>
                  <textarea name="razon" id="razon" class="form-control" required></textarea>

                </center>
              </div>
              <!-- Botón para enviar datos-->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-dark" onclick="return alertaRegistrar()">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  <?php include("../public/footer.php"); ?>
<?php } else { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>