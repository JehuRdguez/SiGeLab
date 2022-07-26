<?php
$pagNom = 'INCIDENCIAS';
?>

<?php include("../public/header.php"); ?>

<?php
include("../database.php");  //se incluye el otro archivo
$reportes = new Database();   //instanciar el objeto
?>

<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>
  <?php
  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $usuarioRegistra = $reportes->sanitize($_POST['usuarioRegistra']);
    $idLaboratorio = $reportes->sanitize($_POST['idLaboratorio']);
    $idTipoIncidencia =  $reportes->sanitize($_POST['idTipoIncidencia']);
    $idEquipo = $reportes->sanitize($_POST['idEquipo']);
    $descripcion = $reportes->sanitize($_POST['descripcion']);
    $res = $reportes->createIncidencia($usuarioRegistra, $idLaboratorio, $idTipoIncidencia, $idEquipo, $descripcion, 0, ''); //CAMBIO


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

  <!-- Botón de registro-->
  <div class="dropdown">
    <a type="button" class="btn btn-outline-dark" href="#RegistroReporte" data-bs-toggle="modal">Registrar incidencia</a>
    <a href="reportesInc.php" target="_blank" class="btn btn-outline-dark">Reporte PDF</a>
    <br>
  </div>
  <!-- Mostrar tabla-->
  <div class="container">

    <table class="table table-bordered " cellspacing="0" width="100%" id="incidenciasTableAdmin" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre completo</th> <!-- Encabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Tipo de incidencia</th>
          <th>N.º de Inv. Escolar del equipo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $reportes = new Database(); //
        $listaReportes = $reportes->readIncidencia(); //se crea la variable listaReportes
        ?>

        <?php
        while ($row = mysqli_fetch_object($listaReportes)) { //antes del = es la variable del form, después es la de BDD
          $idIncidencia = $row->idIncidencia;
          $usuarioRegistra = $row->usuarioRegistra;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $tipoIncidencia = $row->tipoIncidencia;
          $numInvEscolar = $row->numInvEscolar;
          $fecha = $row->fecha;
          $descripcion = $row->descripcion;
          $nombreC = $row->nombreC;
          $estado = $row->estado;

        ?>
          <tr>
            <!-- Muestra-->
            <td><?php echo $usuarioRegistra; ?></td>
            <td><?php echo $nombreLaboratorio; ?></td>
            <td><?php echo $tipoIncidencia; ?></td>
            <td><?php if ($numInvEscolar == 0) {
                  echo "Todos los equipos";
                } else {
                  echo $numInvEscolar;
                } ?></td>
            <td><?php echo date($fecha); ?></td>
            <td><?php if ($estado == 1) {
                  echo 'Concluida';
                } else if (is_null($nombreC)) {
                  echo 'Pendiente';
                } else {
                  echo 'En proceso';
                } ?></td>
            <td>


              <?php

              if ($estado == 1) { ?>
                <a type="button" class="btn btn-outline-dark" href="updateI.php?idIncidencia=<?php echo $idIncidencia; ?>"><i class="fa-solid fa-check"></i></a>

              <?php } else if (is_null($nombreC)) { ?>
                <a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modEditIncidencia<?php echo $idIncidencia; ?>"><i class="fa-regular fa-pen-to-square"></i></a>

              <?php } else if ($estado == 0 && is_null($nombreC)) { ?>
                <a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modEditIncidencia<?php echo $idIncidencia; ?>"><i class="fa-regular fa-pen-to-square"></i></a>

              <?php } else { ?>
                <a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modEditIncidencia<?php echo $idIncidencia; ?>"><i class="fa-regular fa-pen-to-square"></i></a>

                <abbr title="Concluir incidencia"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modResIncidencia<?php echo $idIncidencia; ?>" ><i class="fa-solid fa-clock"></i></a></abbr>
              <?php }   ?>
              <abbr title="Borrar"><a type="button" class="btn btn-outline-dark" onclick="return eliminar()" href="deleteI.php?idIncidencia=<?php echo $idIncidencia ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>
              <abbr title="Ver más"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#verMas<?php echo $idIncidencia; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>

            </td>

          </tr>
          <!-- MODAL DE EDICION DEL ENCARGADO A RESOLVER Y DETALLES -->
          <div class="modal fade" id="modEditIncidencia<?php echo $idIncidencia; ?>" tabindex="-1" aria-labelledby="modEditIncidenciaAlLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <center>
                    <h5 class="modal-title" id="exampleModalLabel">Editar incidencia</h5>
                  </center>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="editarIncidencia.php">
                  <input type="hidden" name="idIncidencia" value="<?php echo $idIncidencia; ?>">

                  <div class="modal-body" id="cont_modal">
                    <div class="form-group">
                      <label for="recipient-name">Nombre del encargado a Resolver:</label>
                      <select class="form-select" aria-label="Default select example" id="nombreC" name="nombreC">
                        <?php
                        $datos_Incidencia = $reportes->single_recordIncidencia($idIncidencia);
                        ?>
                        <option selected hidden value="<?php echo $datos_Incidencia->idUsuario; ?>"><?php echo $nombreC; ?></option>
                        <?php
                        $listaAdministradores = $reportes->readAdministradoresI('nombreC');
                        while ($row = mysqli_fetch_object($listaAdministradores)) {
                          $idUsuario = $row->idUsuario;
                          $nombreC = $row->nombreC; ?>
                          <option value="<?php echo $idUsuario ?>"><?php echo $nombreC ?></option>
                        <?php } ?>
                      </select>
                    </div>


                    
                  </div>
                  <div class="modal-footer">
                    <!-- Botón para enviar datos-->
                    <center>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" onclick="alertaEditar();">Guardar cambios</button>
                    </center>
                    <!-- Botón -->
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- FINN MODAL EDITAR  -->

           <!-- MODAL DE EDICION DE DETALLES -->
           <div class="modal fade" id="modResIncidencia<?php echo $idIncidencia; ?>" tabindex="-1" aria-labelledby="modResIncidenciaAlLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <center>
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                  </center>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="editarIncidencia2.php">
                  <input type="hidden" name="idIncidencia" value="<?php echo $idIncidencia; ?>">

                  <div class="modal-body" id="cont_modal">
                  <?php
                        $datos_Incidencia = $reportes->single_recordIncidencia($idIncidencia);
                        ?>
                  
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">¿Qué se resolvió?</label>
                      <textarea name="descripcionIncidencia" type="text" class="form-control" required><?php echo $datos_Incidencia->descripcionIncidencia; ?></textarea>

                    </div>
                  </div>
                  <div class="modal-footer">
                    <!-- Botón para enviar datos-->
                    <center>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" onclick="alertaEditar();">Guardar cambios</button>
                    </center>
                    <!-- Botón -->
                  </div>

                </form>
              </div>
            </div>
          </div>

          <!-- FINN MODAL EDITAR  -->

          <!-- modal para detalles -->
          <div class="modal fade" id="verMas<?php echo $idIncidencia; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_Incidencia = $reportes->single_recordIncidencia($idIncidencia);
                  $datos_IncidenciaN = $reportes->single_recordIncidenciaN($idIncidencia);
                  ?>
                  <br><label for="">Descripción de incidencia: </label><strong>
                    <?php echo $datos_Incidencia->descripcion; ?></strong>
                  <br><label for="">Encargado a resolver: </label><strong>
                    <?php if (is_null($datos_IncidenciaN->nombreC)) {
                      echo "Pendiente";
                    } else {
                      echo $datos_IncidenciaN->nombreC;
                    }

                    ?></strong>
                  <br><label>Detalles que se resolvieron: <strong><?php
                                                                  if ($datos_Incidencia->descripcionIncidencia == '') {
                                                                    echo 'Sin respuesta';
                                                                  } else {
                                                                    echo $datos_Incidencia->descripcionIncidencia;
                                                                  } ?></strong></label></br>

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


  <!-- ----------------------->



  <!--Modal-Hoja de registro de reportes-->

  <div class="modal fade" id="RegistroReporte" tabindex="-1" aria-labelledby="RegistroReporteAlLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


          <center>
            <h5 class="modal-title" id="RegistroReporte">Hoja de registro de incidencia</h5>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>


                  <input type="hidden" name="usuarioRegistra" id="usuarioRegistra" class="form-control" required value="<?php echo  $_SESSION['nombreC']; ?>">

                  <label> Elige el laboratorio </label>
                  <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio" required>
                    <option value="" selected disabled>Selecciona una Laboratorio</option>
                    <?php
                    $listaIncidencias = $reportes->readLaboratorioS('nombreLaboratorio');
                    while ($row = mysqli_fetch_object($listaIncidencias)) {
                      $idLaboratorio = $row->idLaboratorio;
                      $nombreLaboratorio = $row->nombreLaboratorio; ?>
                      <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                    <?php } ?>
                  </select>
                  <label>Tipo de incidencia</label>
                  <select class="form-select" aria-label="Default select example" id="idTipoIncidencia" name="idTipoIncidencia" required>
                    <option value="" selected disabled>Selecciona el tipo de incidencia</option>
                    <option value="1">Actualización</option>
                    <option value="2">Falla</option>
                    <option value="3">Otro</option>
                  </select>

                  <label>N.º de Inv. Escolar del equipo</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipo" name="idEquipo" required>
                    <option value="" selected disabled>Selecciona el No. de inventario del equipo:</option>
                    <option value="1"> Todos los equipos</option>
                    <?php
                    $listaEquipos = $reportes->readEquipos('numInvEscolar');
                    while ($row = mysqli_fetch_object($listaEquipos)) {
                      $idEquipo = $row->idEquipo;
                      $numInvEscolar = $row->numInvEscolar; ?>
                      <option value="<?php echo $idEquipo ?>"><?php echo $numInvEscolar ?></option>
                    <?php } ?>
                  </select>

                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
                </center>
              </div>


              <!-- Botón para enviar datos-->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" id="registrar" onclick="return alertaRegistrar()" class="btn btn-dark">Registrar</button>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php }
if ($_SESSION['idTipoUsuario'] == 2 || $_SESSION['idTipoUsuario'] == 3) { ?>
  <?php
  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $usuarioRegistra = $reportes->sanitize($_POST['usuarioRegistra']);
    $idLaboratorio = $reportes->sanitize($_POST['idLaboratorio']);
    $idTipoIncidencia =  $reportes->sanitize($_POST['idTipoIncidencia']);
    $idEquipo = $reportes->sanitize($_POST['idEquipo']);
    $descripcion = $reportes->sanitize($_POST['descripcion']);
    $res = $reportes->createIncidencia($usuarioRegistra, $idLaboratorio, $idTipoIncidencia, $idEquipo, $descripcion, 0, ''); //CAMBIO

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

  <!-- Botón de registro-->
  <a type="button" class="btn btn-outline-dark" href="#RegistroReporte" data-bs-toggle="modal">Registrar incidencia</a>
  <br></br>
  <!-- Mostrar tabla-->
  <div class="container">


    <table class="table table-bordered " cellspacing="0" width="100%" id="incidenciasTable" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre completo</th> <!-- Encabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Tipo de incidencia</th>
          <th>N.º de Inv. Escolar del equipo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php

        $reportes = new Database(); //
        $listaReportes = $reportes->readIncidencia(); //se crea la variable listaReportes
        ?>

        <?php

        while ($row = mysqli_fetch_object($listaReportes)) { //antes del = es la variable del form, después es la de BDD
          $idIncidencia = $row->idIncidencia;
          $usuarioRegistra = $row->usuarioRegistra;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $tipoIncidencia = $row->tipoIncidencia;
          $numInvEscolar = $row->numInvEscolar;
          $fecha = $row->fecha;
          $descripcion = $row->descripcion;
          $nombreC = $row->nombreC;
          $estado = $row->estado;


        ?>
          <?php
          if ($_SESSION['nombreC'] == $usuarioRegistra) { ?>
            <tr>
              <!-- Muestra-->
              <td><?php echo $usuarioRegistra; ?></td>
              <td><?php echo $nombreLaboratorio; ?></td>
              <td><?php echo $tipoIncidencia; ?></td>
              <td><?php if ($numInvEscolar == 0) {
                    echo "Todos los equipos";
                  } else {
                    echo $numInvEscolar;
                  } ?></td>
              <td><?php echo date($fecha); ?></td>
              <td><?php if ($estado == 1) {
                    echo 'Concluida';
                  } else if (is_null($nombreC)) {
                    echo 'Pendiente';
                  } else {
                    echo 'En proceso';
                  } ?></td>
              <td>
                <abbr title="Ver más"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#verMas<?php echo $idIncidencia; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
              </td>

            </tr>

            <!-- modal para detalles -->
            <div class="modal fade" id="verMas<?php echo $idIncidencia; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                  </div>

                  <div class="modal-body">
                    <?php
                    $datos_Incidencia = $reportes->single_recordIncidencia($idIncidencia);
                    $datos_IncidenciaN = $reportes->single_recordIncidenciaN($idIncidencia);
                    ?>
                    <br><label for="">Descripcion de incidencia: </label>
                    <?php echo $datos_Incidencia->descripcion; ?>
                    <br><label for="">Encargado a resolver: </label>
                    <?php
                    echo $datos_IncidenciaN->nombreC;
                    ?>
                    <br><label>Detalles que se resolvieron: <strong><?php
                                                                    if ($datos_Incidencia->descripcionIncidencia == '') {
                                                                      echo 'Sin respuesta';
                                                                    } else {
                                                                      echo $datos_Incidencia->descripcionIncidencia;
                                                                    } ?></strong></label></br>

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




  <!--Modal-Hoja de registro de reportes-->

  <div class="modal fade" id="RegistroReporte" tabindex="-1" aria-labelledby="RegistroReporteAlLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">


          <center>
            <h5 class="modal-title" id="RegistroReporte">Hoja de registro de incidencia</h5>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>

                  <input type="hidden" name="usuarioRegistra" id="usuarioRegistra" class="form-control" required value="<?php echo  $_SESSION['nombreC']; ?>">

                  <label> Laboratorio </label>
                  <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio" required>
                    <option value="" selected disabled>Selecciona una Laboratorio</option>
                    <?php
                    $listaIncidencias = $reportes->readLaboratorioS('nombreLaboratorio');
                    while ($row = mysqli_fetch_object($listaIncidencias)) {
                      $idLaboratorio = $row->idLaboratorio;
                      $nombreLaboratorio = $row->nombreLaboratorio; ?>
                      <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                    <?php } ?>
                  </select>

                  <label>Tipo de incidencia </label>
                  <select class="form-select" aria-label="Default select example" id="idTipoIncidencia" name="idTipoIncidencia" required>
                    <option value="" selected disabled>Elige el tipo de incidencia</option>
                    <option value="1">Actualización</option>
                    <option value="2">Falla</option>
                    <option value="3">Otro</option>
                  </select>

                  <label>Número de Inventario Escolar</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipo" name="idEquipo" required>
                    <option value="" selected disabled>Selecciona el No. de inventario del equipo:</option>
                    <option value="1"> Todos los equipos</option>
                    <?php
                    $listaEquipos = $reportes->readEquipos('numInvEscolar');
                    while ($row = mysqli_fetch_object($listaEquipos)) {
                      $idEquipo = $row->idEquipo;
                      $numInvEscolar = $row->numInvEscolar; ?>
                      <option value="<?php echo $idEquipo ?>"><?php echo $numInvEscolar ?></option>
                    <?php } ?>
                  </select>

                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
                </center>
              </div>


              <!-- Botón para enviar datos-->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" id="registrar" onclick="return alertaRegistrar()" class="btn btn-dark">Registrar</button>
              </div>


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<?php include("../public/footer.php");
?>

<?php if ($_SESSION['idTipoUsuario'] != 1 && $_SESSION['idTipoUsuario'] != 2  && $_SESSION['idTipoUsuario'] != 3) { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>