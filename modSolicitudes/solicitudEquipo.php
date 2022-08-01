<?php
$pagNom = 'EQUIPOS ASIGNADOS';
?>

<?php include("../public/header.php"); ?>

<?php if ($idTipoUsuario == 3) { ?>

  <?php
  include("../database.php");

  $alumno = new database();   //instanciar el objeto

  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $idGrupo =  $alumno->sanitize($_POST['idGrupo']);
    $idUsuario =  $alumno->sanitize($_POST['idUsuario']);
    $alumnoN = $alumno->sanitize($_POST['alumnoN']);
    $razon =  $alumno->sanitize($_POST['razon']);
    $idLaboratorio = $alumno->sanitize($_POST['idLaboratorio']);
    $res = $alumno->createSolicitudAL($idGrupo, $idUsuario, 2, $alumnoN, $razon, $idLaboratorio, "");

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
    <table class="table table-bordered " cellspacing="0" width="100%" id="miEquipoTable" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Equipo lab IoT</th>
          <th>Equipo lab desarrollo</th>
          <th>Equipo lab Soporte</th>
        </tr>
      </thead>

      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $equiposAsignadosAl =  $alumno->equiposA();
        ?>

        <?php
        while ($row = mysqli_fetch_object($equiposAsignadosAl)) {
          //antes del = es la variable del form, después es la de BDD

          $nombreCAlum = $row->nombreC;
          if ($_SESSION['nombreC'] ==  $nombreCAlum) {
            $nombreGrupo = $row->nombreGrupo;
            $idEquipoIOT = $row->equipoIOT;
            $idEquipoDesarrollo = $row->equipoDesarrollo;
            $idEquipoSoporte = $row->equipoSoporte;
        ?>
            <tr>
              <td><?php if ($idEquipoIOT == 0) {
                    echo 'No aplica';
                  } else {
                    echo $idEquipoIOT;
                  } ?></td>
              <td><?php if ($idEquipoDesarrollo == 0) {
                    echo 'No aplica';
                  } else {
                    echo $idEquipoDesarrollo;
                  } ?></td>
              <td><?php if ($idEquipoSoporte == 0) {
                    echo 'No aplica';
                  } else {
                    echo $idEquipoSoporte;
                  } ?></td>

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
                  <input type="hidden" name="idUsuario" id="idUsuario" class="form-control" required value="<?php echo  $_SESSION['idUsuario']; ?>">


                  <label> Elige el laboratorio: </label>
                  <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio" required>
                    <option value="">Selecciona una Laboratorio:</option>
                    <?php
                    $listaSolicitudesAL = $alumno->readLaboratorioS('nombreLaboratorio');
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
    <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Solicitudes</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="../modSolicitudes/solicitudes.php">Solcitudes de acceso</a></li>
      <li><a class="dropdown-item" href="../modSolicitudes/solicitudEquipo.php">Cambio de equipo</a></li>

    </ul>
  </div>

  </br>
  <?php
  include("../database.php"); ?>
  <div class="container">
    <table class="table table-bordered" id="solicitudesTableCEquipo" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre solicitante</th> <!-- ENcabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Grupo</th>
          <th>Motivo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $alumno = new Database(); //
        $listaSolicitudesE = $alumno->readSolicitudEquipo();
        $listaalumno = $alumno->readAlumno(); //se crea la variable listasolicitudesE
        ?>

        <?php
        while ($row = mysqli_fetch_object($listaSolicitudesE)) { //antes del = es la variable del form, después es la de BDD
          $idsolicitudCambioE = $row->idsolicitudCambioE;
          $alumnoN = $row->alumnoN;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $idGrupo = $row->idGrupo;
          $razon = $row->razon;
          $fecha = $row->fecha;
          $estado = $row->estado;




        ?>
          <tr>
            <!-- Muestra-->

            <td><?php echo $alumnoN; ?></td> <!-- Muestra-->
            <td><?php echo $nombreLaboratorio; ?></td>
            <td><?php echo $idGrupo; ?></td>
            <td><?php echo $razon; ?></td>
            <td><?php echo $fecha; ?></td>
            <td><?php if ($estado == 2) {
                  echo 'Pendiente';
                } else if ($estado == 1) {
                  echo 'Aceptada';
                } else {
                  echo 'Rechazada'; ?> <abbr title="Razon de rechazo"><a type="button" data-bs-toggle="modal" data-bs-target="#RazonE<?php echo $idsolicitudCambioE; ?>" class="btn btn-outline-primary"><i class="fa-solid fa-question"></i></a></abbr>
              <?php } ?></td>
            <td>
              <?php if ($estado == 1) { ?>
                <abbr title="Aceptar"><a type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i></a></abbr>

              <?php } else if ($estado == 0) { ?>
                <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#razonE<?php echo $idsolicitudCambioE; ?>"><i class="fa-solid fa-xmark"></i></a></abbr>
              <?php  } else { ?>

                <abbr title="Aceptar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#asignacionE<?php echo $idUsuario; ?>"><i class="fa-solid fa-check"></i></a></abbr>
                <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modRazonE<?php echo $idsolicitudCambioE; ?>"><i class="fa-solid fa-xmark"></i></a></abbr>
              <?php  } ?>
              <abbr title="Eliminar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="deleteSE.php?idsolicitudCambioE=<?php echo $idsolicitudCambioE ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>

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
                    $datos_SolicitudE = $alumno->single_recordSolicitudE($idsolicitudCambioE);
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
                    <button type="submit" class="btn btn-warning" onclick="return alertaRechazar()">Rechazar</button>



                  </div>

                </form>
              </div>
            </div>
          </div>
          <!---fin modal editar-->

          <!--  MODAL PARA ASIGNAR EQUIPO -->
          <div class="modal fade" id="asignacionE<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editar equipos asignados del alumno</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php
                $datos_SolicitudE = $alumno->readAlumno(); //se crea la variable listasolicitudesE
                ?>
               

                <form method="POST" action="../modUsuarios/EditarAlumno.php">
                  <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                  <div class="modal-body">

                    <div class="form-group">
                      <label for="" class="col-form-label">Equipo lab IoT: </label>
                      <select class="form-select" aria-label="Default select example" id="idEquipoIOT" name="idEquipoIOT">
                        <?php
                        $datos_SolicitudE = $alumno->single_recordusuarioAl($idUsuario);
                        ?>
                        <option selected hidden value="<?php echo $datos_SolicitudE->idEquipoIOT; ?>"><?php if ($idEquipoIOT == 0) {
                                                                                                        echo 'No aplica';
                                                                                                      } else {
                                                                                                        echo $idEquipoIOT;
                                                                                                      } ?></option>
                        <option value="1">No aplica</option>
                        <?php
                        $listaEIOTEdit = $alumno->equiposIOT('numSerieEquipo');
                        while ($row = mysqli_fetch_object($listaEIOTEdit)) {
                          $idEquipo = $row->idEquipo;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idEquipo; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-form-label">Equipo lab desarrollo: </label>
                      <select class="form-select" aria-label="Default select example" id="idEquipoDesarrollo" name="idEquipoDesarrollo">
                        <?php
                        $datos_SolicitudE = $alumno->single_recordusuarioAl($idUsuario);
                        ?>
                        <option selected hidden value="<?php echo $datos_SolicitudE->idEquipoDesarrollo; ?>"><?php if ($idEquipoDesarrollo == 0) {
                                                                                                                echo 'No aplica';
                                                                                                              } else {
                                                                                                                echo $idEquipoDesarrollo;
                                                                                                              } ?></option>
                        <option value="1">No aplica</option>
                        <?php
                        $listaEDitarED = $alumno->equiposDESARROLLO('numSerieEquipo');
                        while ($row = mysqli_fetch_object($listaEDitarED)) {
                          $idEquipo = $row->idEquipo;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idEquipo; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-form-label">Equipo lab soporte: </label>
                      <select class="form-select" aria-label="Default select example" id="idEquipoSoporte" name="idEquipoSoporte">
                        <?php
                        $datos_SolicitudE = $alumno->single_recordusuarioAl($idUsuario);
                        ?>
                        <option selected hidden value="<?php echo $datos_SolicitudE->idEquipoSoporte; ?>"><?php if ($idEquipoSoporte == 0) {
                                                                                                            echo 'No aplica';
                                                                                                          } else {
                                                                                                            echo $idEquipoSoporte;
                                                                                                          } ?></option>
                        <option value="1">No aplica</option>
                        <?php
                        $listaESEdit = $alumno->equiposSOPORTE('numSerieEquipo');
                        while ($row = mysqli_fetch_object($listaESEdit)) {
                          $idEquipo = $row->idEquipo;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idEquipo; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return alertaEditar()">Actualizar</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
          <!---fin ventana asignar alumno--->

        <?php

        }
        ?>
      </tbody>
    </table>
  </div>
  <?php include("../public/footer.php");
  ?><?php } else if ($_SESSION['idTipoUsuario'] != 1 && $_SESSION['idTipoUsuario'] != 3) { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>