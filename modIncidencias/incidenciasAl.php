<?php 
$pagNom = 'INCIDENCIAS';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 3) { ?>

  <?php
  include("../database.php");  //se incluye el otro archivo
  $reportes = new Database();   //instanciar el objeto

  if (isset($_POST) && !empty($_POST)) { //verifica si esta declarado el campo la && (y) EMpty si se encuentra o no vacio
    $usuarioRegistra = $reportes->sanitize($_POST['usuarioRegistra']);
    $idLaboratorio = $reportes->sanitize($_POST['idLaboratorio']);
    $idTipoIncidencia =  $reportes->sanitize($_POST['idTipoIncidencia']);
    $idEquipo = $reportes->sanitize($_POST['idEquipo']);

    $descripcion = $reportes->sanitize($_POST['descripcion']);


    $res = $reportes->createIncidencia($usuarioRegistra, $idLaboratorio, $idTipoIncidencia, $idEquipo, $descripcion, 0, 0, '');


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
  <a type="button" class="btn btn-outline-dark" href="#RegistroReporte" data-bs-toggle="modal">Registrar incidencia</a> <br />
  <br>
  <!-- Mostrar tabla-->
  <div class="container">

    <table  class="table table-bordered " cellspacing="0" width="100%"  id="incidenciasTable" style="background-color: #04aa89;  ">
      <thead>
        <!-- Secciones o cabeceros -->
        <tr>
          <!-- filas -->
          <th>Nombre completo</th> <!-- Encabezados de las tablas-->
          <th>Laboratorio</th>
          <th>Tipo de reporte</th>
          <th>Número de serie de equipo</th>
          <th>Fecha</th>
          <th>Descripción</th>
          <th>Encargado de resolver</th>
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
          $numSerieEquipo = $row->numSerieEquipo;
          $fecha = $row->fecha;
          $descripcion = $row->descripcion;
          $nombreC = $row->nombreC;
          $estado = $row->estado;


        ?>
          <tr>
            <!-- Muestra-->
            <?php
            if ($_SESSION['nombreC'] == $usuarioRegistra) { ?>
              <td><?php echo $usuarioRegistra; ?></td>
              <td><?php echo $nombreLaboratorio; ?></td>
              <td><?php echo $tipoIncidencia; ?></td>
              <td><?php echo $numSerieEquipo; ?></td>
              <td><?php echo date($fecha); ?></td>
              <td><?php echo $descripcion; ?></td>
              <td><?php echo $nombreC; ?></td>
              <td><?php if ($nombreC != "Pendiente") {
                    echo 'En proceso';
                  } else if ($estado == 0 || $nombreC == "Pendiente") {
                    echo 'Pendiente';
                  } else {
                    echo 'Concluida';
                  } ?></td>
              <td>
                <abbr title="Ver mas"><a type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#verMas<?php echo $idIncidencia; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
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
                  ?>
                  <br><label>Descripción de la incidencia: <strong><?php echo $datos_Incidencia->descripcionIncidencia;
                                                                    if ($datos_Incidencia->descripcionIncidencia == '') {
                                                                      echo 'Sin respuesta';
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
            <h5 class="modal-title" id="RegistroReporte">Hoja de registro de reporte</h5>
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
                  <select class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio">
                    <option selected disabled>Selecciona una Laboratorio</option>
                    <?php
                    $listaIncidencias = $reportes->readLaboratorioS('nombreLaboratorio');
                    while ($row = mysqli_fetch_object($listaIncidencias)) {
                      $idLaboratorio = $row->idLaboratorio;
                      $nombreLaboratorio = $row->nombreLaboratorio; ?>
                      <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                    <?php } ?>
                  </select>

                  <label>Elige el tipo de reporte </label>
                  <select class="form-select" aria-label="Default select example" id="idTipoIncidencia" name="idTipoIncidencia">
                    <option value="1">Actualización</option>
                    <option value="2">Falla</option>
                    <option value="3">Otro</option>
                  </select>

                  <label>Número de serie de equipo</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipo" name="idEquipo">
                    <option selected disabled>Selecciona un numero de serie:</option>
                    <?php
                    $listaEquipos = $reportes->readEquipos('numSerieEquipo');
                    while ($row = mysqli_fetch_object($listaEquipos)) {
                      $idEquipo = $row->idEquipo;
                      $numSerieEquipo = $row->numSerieEquipo; ?>
                      <option value="<?php echo $idEquipo ?>"><?php echo $numSerieEquipo ?></option>
                    <?php } ?>
                  </select>

                  <label>Descripcion</label>
                  <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
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









  
  ?><?php } else { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>
