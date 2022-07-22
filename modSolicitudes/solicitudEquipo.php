<?php
$pagNom = 'CAMBIO EQUIPO';
?>

<?php include("../public/header.php"); ?>

  <?php if ($idTipoUsuario == 3) { ?>

<?php
include("../database.php");

$solicitudAL = new database();   //instanciar el objeto

if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
  $idGrupo =  $solicitudAL->sanitize($_POST['idGrupo']);
  $alumnoN = $solicitudAL->sanitize($_POST['alumnoN']);
  $razon =  $solicitudAL->sanitize($_POST['razon']);
  $idLaboratorio = $solicitudAL->sanitize($_POST['idLaboratorio']);
  $res = $solicitudAL->createSolicitudAL($idGrupo, 2, $alumnoN, $razon, $idLaboratorio, "");

  if ($res) {
    $message = "Datos insertados con exito";
    $class = "alert alert-success";
  } else {
    $message = "No se pudieron insertar los datos... ";
    $class = "alert alert-danger";
  }
?>
  
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
<?php }
 if ($_SESSION['idTipoUsuario'] == 1) { ?>

  
    <div class="dropdown">
      <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
        Solicitudes</button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item"  href="../modSolicitudes/solicitudes.php">Solcitudes de acceso</a></li>
        <li><a class="dropdown-item"  href="../modSolicitudes/solicitudEquipo.php">Cambio de equipo</a></li>

      </ul>
    </div>
    
    </br>
    <?php
    include("../database.php"); ?>
    <div class="container">
      <table class="table table-bordered" id="solicitudesTable" style="background-color: #04aa89;  ">
        <thead>
          <!-- Secciones o cabeceros -->
          <tr>
            <!-- filas -->
            <th>Nombre solicitante</th> <!-- ENcabezados de las tablas-->
            <th>Laboratorio</th>
            <th>Grupo</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Cuerpo de la tabla, se llena con la BDD-->
          <?php
          $solicitudAL = new Database(); //
          $listaSolicitudesE = $solicitudAL->readSolicitudEquipo(); //se crea la variable listasolicitudesE
          ?>
  
          <?php
          while ($row = mysqli_fetch_object($listaSolicitudesE)) { //antes del = es la variable del form, después es la de BDD
            $idsolicitudCambioE = $row->idsolicitudCambioE;
            $alumno = $row->alumno;
            $nombreLaboratorio = $row->nombreLaboratorio;
            $idGrupo = $row->idGrupo;
            $razon = $row->razon;
            $estado = $row->estado;
   
  
  
  
          ?>
            <tr>
              <!-- Muestra-->
  
              <td><?php echo $alumno; ?></td> <!-- Muestra-->
              <td><?php echo $nombreLaboratorio; ?></td>
              <td><?php echo $idGrupo; ?></td>
              <td><?php echo $razon; ?></td>
              <td><?php if ($estado == 2) {
                    echo 'Pendiente';
                  } else if ($estado == 1) {
                    echo 'Aceptada';
                  } else {
                    echo 'Rechazada'; ?> <abbr title="Razon de rechazo"><a type="button" data-bs-toggle="modal" data-bs-target="#RazonE<?php echo $idsolicitudCambioE; ?>" class="btn btn-outline-primary"><i class="fa-solid fa-question"></i></a></abbr>
                <?php } ?></td>
              <td>
                <?php if ($estado == 1) { ?>
                  <abbr title="ACEPTAR"><a type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i></a></abbr>
  
                <?php } else if ($estado == 0) { ?>
                  <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#razonE<?php echo $idsolicitudCambioE; ?>"><i class="fa-solid fa-xmark"></i></a></abbr>
                <?php  } else { ?>
  
  
                  <abbr title="ACEPTAR"><a type="button" class="btn btn-outline-dark" href="updateSE.php?idsolicitudCambioE=<?php echo $idsolicitudCambioE; ?>"><i class="fa-solid fa-check"></i></a></abbr>
                  <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modRazonE<?php echo $idsolicitudCambioE; ?>"><i class="fa-solid fa-xmark"></i></a></abbr>
                <?php  } ?>
                <abbr title="Borrar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="deleteSE.php?idsolicitudCambioE=<?php echo $idsolicitudCambioE ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>
  
              </td>
            </tr>
  
  
  <!-- 
  MODAL PARA RECHAZAR -->
            
            <div class="modal fade" id="modRazonE<?php echo $idsolicitudCambioE; ?>" tabindex="-1" aria-labelledby="modRazonEAlLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <center>
                      <h5 class="modal-title" id="exampleModalLabel">Rechazar Solicitud</h5>
                    </center>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
  
                  <form method="POST" action="razonE.php">
                    <input type="hidden" name="idsolicitudCambioE" value="<?php echo $idsolicitudCambioE; ?>">
  
  
                    <div class="modal-body" id="cont_modal">
                      <?php
                      $datos_SolicitudE = $solicitudAL->single_recordSolicitudE($idsolicitudCambioE);
                      ?>
  
                      <div class="form-group">
  
                        <label for="post" class="col-form-label">Razón de rechazo</label>
                        <textarea name="respuesta" id="respuesta" name type="text" class="form-control" placeholder="¿Por qué rechaza esta solicitud?" required><?php echo $datos_SolicitudE->respuesta; ?></textarea>
                        
  
                      </div>
                    </div>
                    <div class="modal-footer">
  
                      <!-- Botón para enviar datos-->
                </center>
  
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button  type="submit"  class="btn btn-warning" onclick="return alertaRechazar()"><a id="botonRechazar" style="text-decoration: none;" type="submit"  href="updateSE2.php?idsolicitudCambioE=<?php echo $idsolicitudCambioE; ?>">Rechazar</a></button>
                      
  

                    </div>
  
                  </form>
                </div>
              </div>
            </div>
            <!---fin modal editar-->
  
            <!-- modal para  ver rechazo -->
            <div class="modal fade" id="RazonE<?php echo $idsolicitudCambioE; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Razón de rechazo</h5>
                  </div>
  
                  <div class="modal-body">
                    <?php
                    $datos_SolicitudE = $solicitudAL->single_recordSolicitudE($idsolicitudCambioE);
                    ?>
                    <br><label>Razón de rechazo de la solicitud: <strong><?php echo $datos_SolicitudE->respuesta; ?></strong></label></br>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            <!---fin modal ver mas-->
  
          <?php
  
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php include("../public/footer.php");
    ?><?php } else if($_SESSION['idTipoUsuario']!=1 && $_SESSION['idTipoUsuario']!=3){ ?>
    <?php header("Location: ../index.php"); ?>
  <?php } ?>