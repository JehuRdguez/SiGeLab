<?php
$pagNom = 'SOLICITUDES DE ACCESO';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>

  <?php
  include("../database.php");


  $solicitud = new database();   //instanciar el objeto

  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $maestro = $solicitud->sanitize($_POST['maestro']);
    $idLaboratorio = $solicitud->sanitize($_POST['idLaboratorio']);
    $idGrupo =  $solicitud->sanitize($_POST['idGrupo']);
    $materia =  $solicitud->sanitize($_POST['materia']);
    $fecha = $solicitud->sanitize($_POST['fecha']);
    $fechaSalida = $solicitud->sanitize($_POST['fechaSalida']);
    $horaEntrada = $solicitud->sanitize($_POST['horaEntrada']);
    $horaSalida = $solicitud->sanitize($_POST['horaSalida']);

    $res = $solicitud->createSolicitud($maestro, $idLaboratorio, $idGrupo, $materia, $fecha, $fechaSalida, $horaEntrada, $horaSalida, 2, 0, '');

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


  <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Solicitudes</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="../modSolicitudes/solicitudes.php">Solcitudes de acceso</a></li>
      <li><a class="dropdown-item" href="../modSolicitudes/solicitudEquipo.php">Cambio de equipo</a></li>

    </ul>
    <!--Botón de registro -->
    <a type="button" class="btn btn-outline-dark" href="#RegistroSolicitud" data-bs-toggle="modal">Registrar Solicitud</a> 
    <a  type="button" href="reporteSolicitudes.php" target="_blank" class="btn btn-outline-dark">Reporte PDF</a>

  </div>
  </br>


  <!-- Mostrar tabla-->
  <div class="container">
    <table class="table table-bordered " cellspacing="0" width="100%" id="solicitudesTable" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre del solicitante</th> <!-- ENcabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Grupo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Estado Laboratorio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $solicitud = new Database(); //
        $listaSolicitudes = $solicitud->readSolicitud(); //se crea la variable listasolicitudes
        ?>

        <?php
        while ($row = mysqli_fetch_object($listaSolicitudes)) { //antes del = es la variable del form, después es la de BDD
          $idSolicitudAcceso = $row->idSolicitudAcceso;
          $maestro = $row->maestro;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $nombreGrupo = $row->nombreGrupo;
          $fecha = $row->fecha;
          $estado = $row->estado;
          $estadoLaboratorio = $row->estadoLaboratorio;


        ?>
          <tr>
            <!-- Muestra-->

            <td><?php echo $maestro; ?></td> <!-- Muestra-->
            <td><?php echo $nombreLaboratorio; ?></td>
            <td><?php echo $nombreGrupo; ?></td>
            <td><?php echo $fecha ?></td>
            <td><?php if ($estado == 2) {
                  echo 'Pendiente';
                } else if ($estado == 1) {
                  echo 'Aceptada';
                } else {
                  echo 'Rechazada'; ?> <abbr title="Razon de rechazo"><a type="button" data-bs-toggle="modal" data-bs-target="#razon<?php echo $idSolicitudAcceso; ?>" class="btn btn-outline-primary"><i class="fa-solid fa-question"></i></a></abbr>
              <?php } ?></td>
            <td><?php if ($estado == 0) {
                  echo 'No aplica';
                } else if ($estadoLaboratorio == 1) {
                  echo 'Liberado';
                } else {
                  echo 'Ocupado';
                } ?></td>
            <td>
              <?php if ($estado == 1) { ?>
                <abbr title="ACEPTAR"><a type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i></a></abbr>

              <?php } else if ($estado == 0) { ?>
                <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal"><i class="fa-solid fa-xmark"></i></a></abbr>
              <?php  } else { ?>


                <abbr title="ACEPTAR"><a type="button" class="btn btn-outline-dark" href="updateS.php?idSolicitudAcceso=<?php echo $idSolicitudAcceso; ?>"><i class="fa-solid fa-check"></i></a></abbr>
                <abbr title="Rechazar"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modRazon<?php echo $idSolicitudAcceso; ?>"><i class="fa-solid fa-xmark"></i></a></abbr>
              <?php  } ?>
              <abbr title="Borrar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="deleteS.php?idSolicitudAcceso=<?php echo $idSolicitudAcceso ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>
              <abbr title="Ver mas"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#verMas<?php echo $idSolicitudAcceso; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>

            </td>
          </tr>
          <div class="modal fade" id="modRazon<?php echo $idSolicitudAcceso; ?>" tabindex="-1" aria-labelledby="modRazonAlLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <center>
                    <h5 class="modal-title" id="exampleModalLabel">Rechazar Solicitud</h5>
                  </center>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="razon.php">
                  <input type="hidden" name="idSolicitudAcceso" value="<?php echo $idSolicitudAcceso; ?>">


                  <div class="modal-body" id="cont_modal">
                    <?php
                    $datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
                    ?>

                    <div class="form-group">

                      <label for="post" class="col-form-label">Razón de rechazo</label>
                      <textarea name="razon" id="razon" name type="text" class="form-control" placeholder="¿Por qué rechaza esta solicitud?" required><?php echo $datos_Solicitud->razon; ?></textarea>


                    </div>
                  </div>
                  <div class="modal-footer">

                    <!-- Botón para enviar datos-->
                    <center>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-warning" onclick="return alertaRechazar()"><a style="text-decoration: none;" href="updateS2.php?idSolicitudAcceso=<?php echo $idSolicitudAcceso; ?>">Rechazar</a></button>
                    </center>
                    <br>
                    <!-- Botón -->
                  </div>

                </form>
              </div>
            </div>
          </div>
          <!---fin modal editar-->

          <!-- modal para  ver rechazo -->
          <div class="modal fade" id="razon<?php echo $idSolicitudAcceso; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Razón de rechazo</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
                  ?>
                  <br><label>Razón de rechazo de la solicitud: <strong><?php echo $datos_Solicitud->razon; ?></strong></label></br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!---fin modal ver mas-->


          <!-- modal para detalles -->
          <div class="modal fade" id="verMas<?php echo $idSolicitudAcceso; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
                  ?>
                  <br><label>Materia: <strong><?php echo $datos_Solicitud->materia; ?></strong></label><br><br>
                  <label for=""><strong> USO DE LABORATORIO</strong></label><br>
                  <br><label>Fecha de inicio: <strong><?php echo $datos_Solicitud->fecha; ?></strong></label></br>
                  <br><label>Fecha de termino: <strong><?php if ($datos_Solicitud->fechaSalida == '') {
                                                          echo 'No aplica';
                                                        } else if ($datos_Solicitud->fecha == $datos_Solicitud->fechaSalida) {
                                                          echo 'No aplica';
                                                        } else {
                                                          echo $datos_Solicitud->fechaSalida;
                                                        } ?></strong></label></br>
                  <br><label>Hora de entrada: <strong><?php echo $datos_Solicitud->horaEntrada; ?></strong></label></br>
                  <br><label>Hora de salida: <strong><?php echo $datos_Solicitud->horaSalida; ?></strong></label></br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!---fin modal detalles--->
        <?php

        }
        ?>
      </tbody>
    </table>
  </div>




  <!--Modal-Hoja de registro de solicitudes-->

  <div class="modal fade" id="RegistroSolicitud" tabindex="-1" aria-labelledby="RegistroSolicitudAlLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


          <center>
            <h5 class="modal-title" id="RegistroSolicitud">Hoja de registro de solicitud</h5>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>

                  <div class="col-sm-10">
                    <input type="hidden" name="maestro" id="maestro" class="form-control" required value="<?php echo  $_SESSION['nombreC']; ?>">

                  </div>
                  <div class="col-sm-10">
                    <label> Elige el laboratorio </label>
                    <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio" required>
                      <option selected disabled>Selecciona un Laboratorio</option>
                      <?php
                      $listaSolicitudes = $solicitud->readLaboratorioS('nombreLaboratorio');
                      while ($row = mysqli_fetch_object($listaSolicitudes)) {
                        $idLaboratorio = $row->idLaboratorio;
                        $nombreLaboratorio = $row->nombreLaboratorio; ?>
                        <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                      <?php } ?>
                    </select>

                    <label for="">Grupo</label>
                    <select class="form-select" aria-label="Default select example" id="idGrupo" name="idGrupo" required>
                      <option selected disabled>Selecciona un Grupo</option>
                      <?php
                      $listaGrupos = $solicitud->readGrupos('nombreGrupo');
                      while ($row = mysqli_fetch_object($listaGrupos)) {
                        $idGrupo = $row->idGrupo;
                        $nombreGrupo = $row->nombreGrupo; ?>
                        <option value="<?php echo $idGrupo ?>"><?php echo $nombreGrupo ?></option>
                      <?php } ?>
                    </select>

                    <label>Materia</label>
                    <input type="text" name="materia" id="materia" class="form-control" required>

                    <label>Fecha</label>
                    <input type="text" name="fecha" id="fecha" class="form-control" min=<?php $hoy = date("Y-m-d");
                                                                                        echo $hoy; ?> required>

                    <label>Fecha de Termino</label>
                    <input type="text" name="fechaSalida" id="fechaSalida" class="form-control" min=<?php $hoy = date("Y-m-d");
                                                                                                    echo $hoy; ?>>
                    <h6 style="color:red ;">*Solo llene este si lo utilizara mas de un dia</h6>

                    <label>Hora entrada</label>
                    <input type="time" name="horaEntrada" id="horaEntrada" class="form-control" min="07:30" max="19:00" required>

                    <label>Hora salida</label>
                    <input type="time" name="horaSalida" id="horaSalida" class="form-control" min="07:30" max="19:00" required>


                </center>
              </div>


              <!-- Botón para enviar datos-->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" id="registrarS" class="btn btn-dark" onclick="return alertaRegistrarS()">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>





  <?php include("../public/footer.php"); ?>
<?php }
if ($_SESSION['idTipoUsuario'] == 2) { ?>
  <!-- MAESTRO -->


  <?php
  include("../database.php");

  $solicitud = new database();   //instanciar el objeto

  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $maestro = $solicitud->sanitize($_POST['maestro']);
    $idLaboratorio = $solicitud->sanitize($_POST['idLaboratorio']);
    $idGrupo =  $solicitud->sanitize($_POST['idGrupo']);
    $materia =  $solicitud->sanitize($_POST['materia']);
    $fecha = $solicitud->sanitize($_POST['fecha']);
    $fechaSalida = $solicitud->sanitize($_POST['fechaSalida']);
    $horaEntrada = $solicitud->sanitize($_POST['horaEntrada']);
    $horaSalida = $solicitud->sanitize($_POST['horaSalida']);


    $res = $solicitud->createSolicitud($maestro, $idLaboratorio, $idGrupo, $materia, $fecha, $fechaSalida, $horaEntrada, $horaSalida, 2, 0, '');

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
  <a type="button" class="btn btn-outline-dark" href="#RegistroSolicitud" data-bs-toggle="modal">Registrar Solicitud</a> <br />
  <br>
  <!-- Mostrar tabla-->
  <div class="container">
    <table class="table table-bordered " cellspacing="0" width="100%" id="solicitudesTable2" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre solicitante</th> <!-- ENcabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Grupo</th>
          <th>Fecha</th>
          <th>Estado de Solicitud</th>
          <th>Estado de Laboratorio</th>
          <th>Detalles</th>
          <th>¿Concluir estancia?</th>

        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $solicitud = new Database(); //
        $listaSolicitudes = $solicitud->readSolicitud(); //se crea la variable listasolicitudes
        ?>

        <?php
        while ($row = mysqli_fetch_object($listaSolicitudes)) { //antes del = es la variable del form, después es la de BDD
          $idSolicitudAcceso = $row->idSolicitudAcceso;
          $maestro = $row->maestro;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $nombreGrupo = $row->nombreGrupo;
          $fecha = $row->fecha;
          $estado = $row->estado;
          $estadoLaboratorio = $row->estadoLaboratorio;


        ?>
          <tr>
            <!-- Muestra-->
            <?php
            if ($_SESSION['nombreC'] == $maestro) { ?>
              <td><?php echo $maestro; ?></td> <!-- Muestra-->
              <td><?php echo $nombreLaboratorio; ?></td>
              <td><?php echo $nombreGrupo; ?></td>
              <td><?php echo $fecha; ?></td>
              <td><?php if ($estado == 0) {
                    echo 'Rechazada' ?> <abbr title="Razon de rechazo"><a type="button" data-bs-toggle="modal" data-bs-target="#razon<?php echo $idSolicitudAcceso; ?>" class="btn btn-outline-primary"><i class="fa-solid fa-question"></i></a></abbr>
                <?php } else if ($estado == 1) {
                    echo 'Aceptada';
                  } else echo 'Pendiente';
                ?></td>
              <td><?php if ($estado == 0) {
                    echo 'No aplica';
                  } else if ($estadoLaboratorio == 0) {
                    echo 'Pendiente';
                  } else if ($estadoLaboratorio == 1) {
                    echo 'Liberado';
                  } else echo 'Error';  ?></td>
              <td> <abbr title="Ver mas"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#verMas<?php echo $idSolicitudAcceso; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr></td>

              <td>

                <?php
                if ($estado == 0) {
                  echo 'No aplica';
                } else if ($estadoLaboratorio == 1) { ?>
                  <abbr title="Laboratorio Liberado"><a type="button" class="btn btn-outline-dark"><i class="fa-solid fa-check"></i></a></abbr>

                <?php } else if ($estadoLaboratorio == 0) { ?>
                  <abbr title="Liberar Laboratorio"><a type="button" class="btn btn-outline-dark" href="updateS.php?idSolicitudAcceso=<?php echo $idSolicitudAcceso; ?>"><i class="fa-solid fa-clock"></i></a></abbr>
                <?php } ?>


              </td>
              <!-- <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a> -->
          </tr>
          <!-- modal para  ver rechazo -->
          <div class="modal fade" id="razon<?php echo $idSolicitudAcceso; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Razón de rechazo</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
                  ?>
                  <br><label>Razón de rechazo de la solicitud: <strong><?php echo $datos_Solicitud->razon; ?></strong></label></br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!---fin modal ver mas-->





          <!-- modal para detalles -->
          <div class="modal fade" id="verMas<?php echo $idSolicitudAcceso; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
                  ?>
                  <br><label>Materia: <strong><?php echo $datos_Solicitud->materia; ?></strong></label><br><br>
                  <label for=""><strong> USO DE LABORATORIO</strong></label><br>
                  <br><label>Dias de uso: <strong><?php echo $datos_Solicitud->fecha; ?></strong></label></br>
                  <br><label>Hora de entrada: <strong><?php echo $datos_Solicitud->horaEntrada; ?></strong></label></br>
                  <br><label>Hora de salida: <strong><?php echo $datos_Solicitud->horaSalida; ?></strong></label></br>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
          <!---fin modal detalles--->
      <?php
            }
          }
      ?>
      </tbody>
    </table>
  </div>




  <!--Modal-Hoja de registro de solicitudes-->

  <div class="modal fade" id="RegistroSolicitud" tabindex="-1" aria-labelledby="RegistroSolicitudAlLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


          <center>
            <h5 class="modal-title" id="RegistroSolicitud">Hoja de registro de solicitud</h5>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>

                  <div class="col-sm-10">
                    <div class="col-sm-10">
                      <input type="hidden" name="maestro" id="maestro" class="form-control" required value="<?php echo  $_SESSION['nombreC']; ?>">
                    </div>
                    <div class="col-sm-10">
                      <label> Elige el laboratorio </label>
                      <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio">
                        <option selected disabled>Selecciona un Laboratorio</option>
                        <?php
                        $listaSolicitudes = $solicitud->readLaboratorioS('nombreLaboratorio');
                        while ($row = mysqli_fetch_object($listaSolicitudes)) {
                          $idLaboratorio = $row->idLaboratorio;
                          $nombreLaboratorio = $row->nombreLaboratorio; ?>
                          <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                        <?php } ?>
                      </select>

                      <label for="">Grupo</label>
                      <select class="form-select" aria-label="Default select example" id="idGrupo" name="idGrupo">
                        <option selected disabled>Selecciona un Grupo</option>
                        <?php
                        $listaGrupos = $solicitud->readGrupos('nombreGrupo');
                        while ($row = mysqli_fetch_object($listaGrupos)) {
                          $idGrupo = $row->idGrupo;
                          $nombreGrupo = $row->nombreGrupo; ?>
                          <option value="<?php echo $idGrupo ?>"><?php echo $nombreGrupo ?></option>
                        <?php } ?>
                      </select>

                      <label>Materia</label>
                      <input type="text" name="materia" id="materia" class="form-control" required>

                
                      <label>Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" min=<?php $hoy = date("Y-m-d"); echo $hoy; ?> onblur="obtenerfechafinf1();" required>

                    <label>Fecha de Termino</label>
                    <input type="date" name="fechaSalida" id="fechaSalida" class="form-control" min=<?php $hoy = date("Y-m-d"); echo $hoy; ?> onblur="obtenerfechafinf1();">
                    <h6 style="color:red ;">*Solo llene este si lo utilizara mas de un dia</h6>

                      <label>Hora entrada</label>
                      <input type="time" name="horaEntrada" id="horaEntrada" class="form-control" min="07:30" max="19:00" required>

                      <label>Hora salida</label>
                      <input type="time" name="horaSalida" id="horaSalida" class="form-control" min="07:30" max="19:00" required>

                </center>
              </div>


              <!-- Botón para enviar datos-->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" id="registrarS" class="btn btn-dark" onclick="return alertaRegistrarS()">Registrar</button>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("../public/footer.php"); ?>
<?php } else if ($_SESSION['idTipoUsuario'] != 1 && $_SESSION['idTipoUsuario'] != 2) { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>