<?php 
$pagNom = 'USUARIOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>


  <?php
  include("../database.php");  //se incluye el otro archivo
  $alumnos = new Database();  //generamos la variable  pq eso es lo que vamos a generar, con esto instanciamos

  if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
    $numConAlum = $alumnos->sanitize($_POST['numConAlum']);  //se va a limpiar y recibir lo del formulario
    $idGrupo = $alumnos->sanitize($_POST['idGrupo']);
    $nombreC = $alumnos->sanitize($_POST['nombreCAl']);
    $correo = $alumnos->sanitize($_POST['correoAl']);
    $telefono = $alumnos->sanitize($_POST['telefonoAl']);
    $idEquipoIOT = $alumnos->sanitize($_POST['idEquipoIOT']);
    $idEquipoDesarrollo = $alumnos->sanitize($_POST['idEquipoDesarrollo']);
    $idEquipoSoporte = $alumnos->sanitize($_POST['idEquipoSoporte']);
    $contrasena = $alumnos->sanitize($_POST['contrasenaAl']);
    $res = $alumnos->createAlumno($nombreC, $correo, $telefono, $contrasena, 3, 1, $numConAlum, $idGrupo, $idEquipoIOT, $idEquipoDesarrollo, $idEquipoSoporte);


    if ($res === true) {
      $message = "Datos insertados con éxito";
      $class = "alert alert-success";
    } else if ($res == "duplicado") {
      $message = "Datos duplicados, no se pudo completar el registro...";
      $class = "alert alert-danger";
    } else {
      $message = "No se pudieron insertar los datos...";
      $class = "alert alert-danger";
    }
  ?>
    <div class="<?php echo $class ?>">
      <?php echo $message; ?>
    </div>
  <?php
  }
  ?>

  <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Alumnos</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="usuarioAdministrador.php">Administradores</a></li>
      <li><a class="dropdown-item" href="usuarioMaestro.php">Maestros</a></li>
      <li><a class="dropdown-item" href="usuarioAlumno.php">Alumnos</a></li>
      <li><a class="dropdown-item" href="grupos.php">Grupos</a></li>
    </ul>

    <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#RegistroUsuarioAl">Registrar</a><br>
    <br />


    <!-- Mostrar tabla-->
    <div class="container">

      <table class="table table-bordered " cellspacing="0" width="100%" id="alumnoTable" style="background-color: #04aa89;  ">
        <thead>
          <!-- Secciones o cabeceros -->
          <tr>
            <!-- filas -->
            <th>Número de control</th> <!-- ENcabezados de las tablas-->
            <th>Nombre completo</th>
            <th>Correo</th>
            <th>Grupo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>


        <tbody>
          <!-- Cuerpo de la tabla, se llena con la BDD-->
          <?php
          $alumnos = new Database(); //
          $listaAlumnos = $alumnos->readAlumno(); //se crea la variable listaAdministradores
          ?>

          <?php
          while ($row = mysqli_fetch_object($listaAlumnos)) { //antes del = es la variable del form, después es la de BDD
            $idUsuario = $row->idUsuario;
            $numConAlum = $row->numConAlum;
            $nombreC = $row->nombreC;
            $correo = $row->correo;
            $telefono = $row->telefono;
            $idGrupo = $row->nombreGrupo;
            $contrasena = $row->contrasena;
            $idEquipoIOT = $row->equipoIOT;
            $idEquipoDesarrollo = $row->equipoDesarrollo;
            $idEquipoSoporte = $row->equipoSoporte;
            $tipoUsuario = $row->tipoUsuario;
            $uActivo = $row->uActivo;
            $estadoIOT = $row->estadoIOT;
            $estadoDesarrollo = $row->estadoDesarrollo;
            $estadoSoporte = $row->estadoSoporte;
            $estadoGrupo = $row->estadoGrupo;
          ?>
            <tr>
              <td><?php echo $numConAlum; ?></td> <!-- Muestra-->
              <td><?php echo $nombreC; ?></td>
              <td><?php echo $correo; ?></td>
              <td><?php if ($estadoGrupo == 1) {
                    echo $idGrupo;
                  } else {
                    echo 'Pendiente';
                  } ?></td>

              <td><?php if ($uActivo == 1) {
                    echo 'Activo';
                  } else {
                    echo 'Inactivo';
                  } ?></td>

              <td>
                <center>
                  <?php
                  if ($uActivo == 1) { ?>
                    <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateUAl.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye-slash"></i></a></abbr>
                  <?php } else { ?>
                    <abbr title="Habilitar"><a type="button" class="btn btn-outline-dark" href="updateUAl.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye"></i></a></abbr>
                  <?php } ?>
                  <abbr title="Actualizar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarAlumnos<?php echo $idUsuario; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
                  <!--Botón para detalles-->
                  <abbr title="Ver detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesAlumno<?php echo $idUsuario; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
                </center>
              </td>
            </tr>

            <!--ventana para Update--->
            <div class="modal fade" id="editarAlumnos<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario alumno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form method="POST" action="EditarAlumno.php">
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                    <div class="modal-body">

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Número de control:</label>
                        <input type="number" name="numConAlum" id="numConAlum" class="form-control" value="<?php echo $numConAlum; ?>" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                        <input type="text" name="nombreCAl" id="nombreCAl" class="form-control" onkeypress="return ValidarLestrasC(event)" value="<?php echo $nombreC; ?>" required="true">
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Dirección de correo electrónico:</label>
                        <input type="email" name="correoAl" id="correoAl" class="form-control" value="<?php echo $correo; ?>" required="true">
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Teléfono: </label>
                        <input type="number" name="telefonoAl" id="telefonoAl" class="form-control" value="<?php echo $telefono; ?>" min="1111111111" onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>

                      <div class="form-group">
                        <?php
                        $datos_alumno = $alumnos->single_recordusuarioContraAl($idUsuario);
                        ?>
                        <label for="recipient-name" class="col-form-label">Contraseña:</label>
                        <input type="text" name="contrasenaAl" id="contrasenaAl" class="form-control" onkeypress="return ValidarContrasena(event)" value="<?php echo $datos_alumno->contrasena; ?>" required="true">
                      </div>

                      <div class="form-group">
                        <label for="" class="col-form-label">Grupo</label>
                        <select class="form-select" aria-label="Default select example" id="idGrupo" name="idGrupo">
                          <?php
                          $datos_alumno = $alumnos->single_recordusuarioAl($idUsuario);
                          ?>
                          <option selected value="<?php echo $datos_alumno->idGrupo; ?>"><?php echo $idGrupo; ?></option>
                          <?php
                          $listaEGrupos = $alumnos->readListaGrupo('nombreGrupo');
                          while ($row = mysqli_fetch_object($listaEGrupos)) {
                            $idGrupo = $row->idGrupo;
                            $nombreGrupo = $row->nombreGrupo; ?>
                            <option value="<?php echo $idGrupo; ?>"><?php echo $nombreGrupo; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="" class="col-form-label">Equipo lab IoT: </label>
                        <select class="form-select" aria-label="Default select example" id="idEquipoIOT" name="idEquipoIOT">
                          <?php
                          $datos_alumno = $alumnos->single_recordusuarioAl($idUsuario);
                          ?>
                          <option selected value="<?php echo $datos_alumno->idEquipoIOT; ?>"><?php if ($idEquipoIOT == 0) {
                                                                                                echo 'No aplica';
                                                                                              } else {
                                                                                                echo $idEquipoIOT;
                                                                                              } ?></option>
                          <option value="1">No aplica</option>
                          <?php
                          $listaEIOTEdit = $alumnos->equiposIOT('numSerieEquipo');
                          while ($row = mysqli_fetch_object($listaEIOTEdit)) {
                            $idEquipo = $row->idEquipo;
                            $numSerieEquipo = $row->numSerieEquipo; ?>
                            <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="" class="col-form-label">Equipo lab desarrollo: </label>
                        <select class="form-select" aria-label="Default select example" id="idEquipoDesarrollo" name="idEquipoDesarrollo">
                          <?php
                          $datos_alumno = $alumnos->single_recordusuarioAl($idUsuario);
                          ?>
                          <option selected value="<?php echo $datos_alumno->idEquipoDesarrollo; ?>"><?php if ($idEquipoDesarrollo == 0) {
                                                                                                      echo 'No aplica';
                                                                                                    } else {
                                                                                                      echo $idEquipoDesarrollo;
                                                                                                    } ?></option>
                          <option value="1">No aplica</option>
                          <?php
                          $listaEDitarED = $alumnos->equiposDESARROLLO('numSerieEquipo');
                          while ($row = mysqli_fetch_object($listaEDitarED)) {
                            $idEquipo = $row->idEquipo;
                            $numSerieEquipo = $row->numSerieEquipo; ?>
                            <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
                          <?php } ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="" class="col-form-label">Equipo lab soporte: </label>
                        <select class="form-select" aria-label="Default select example" id="idEquipoSoporte" name="idEquipoSoporte">
                          <?php
                          $datos_alumno = $alumnos->single_recordusuarioAl($idUsuario);
                          ?>
                          <option selected value="<?php echo $datos_alumno->idEquipoSoporte; ?>"><?php if ($idEquipoSoporte == 0) {
                                                                                                    echo 'No aplica';
                                                                                                  } else {
                                                                                                    echo $idEquipoSoporte;
                                                                                                  } ?></option>
                          <option value="1">No aplica</option>
                          <?php
                          $listaESEdit = $alumnos->equiposSOPORTE('numSerieEquipo');
                          while ($row = mysqli_fetch_object($listaESEdit)) {
                            $idEquipo = $row->idEquipo;
                            $numSerieEquipo = $row->numSerieEquipo; ?>
                            <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
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
            <!---fin ventana actualizar alumno--->

            <!-- modal para detalles -->
            <div class="modal fade" id="detallesAlumno<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                  </div>

                  <div class="modal-body">
                    <?php
                    $datos_alumnos = $alumnos->single_recordusuarioContraAl($idUsuario);
                    ?>
                    <label>Contraseña: <strong><?php echo $datos_alumnos->contrasena;  ?></strong></label></br>

                    </br><label>Teléfono: <strong><?php echo $telefono; ?></strong></label></br>

                    </br><label>Equipo asignado IoT: <strong><?php if ($idEquipoIOT == 0) {
                                                                echo 'No aplica';
                                                              } else if ($estadoIOT == 1 && $idEquipoIOT > 0) {
                                                                echo $idEquipoIOT;
                                                              } else {
                                                                echo 'Pendiente';
                                                              } ?></strong></label></br>

                    </br><label>Equipo asignado Desarrollo: <strong><?php if ($idEquipoDesarrollo == 0) {
                                                                      echo 'No aplica';
                                                                    } else if ($estadoDesarrollo == 1 && $idEquipoDesarrollo > 0) {
                                                                      echo $idEquipoDesarrollo;
                                                                    } else {
                                                                      echo 'Pendiente';
                                                                    } ?></strong></label></br>

                    </br><label>Equipo asignado soporte: <strong><?php if ($idEquipoSoporte == 0) {
                                                                    echo 'No aplica';
                                                                  } else if ($estadoSoporte == 1 && $idEquipoSoporte > 0) {
                                                                    echo $idEquipoSoporte;
                                                                  } else {
                                                                    echo 'Pendiente';
                                                                  } ?></strong></label></br>



                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
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
  <!-- Fin tabla-->


  <!--Modal-Hoja de registro de usuarios al-->
  <div class="modal fade" id="RegistroUsuarioAl" tabindex="-1" aria-labelledby="RegistroUsuarioAlLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <center>
            <h5 class="modal-title" id="RegistroUsuarioAl">Hoja de registro de alumno</h5>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <center>

                  <label> Número de control:</label>
                  <input type="number" name="numConAlum" id="numConAlum" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                  <label> Nombre completo:</label>
                  <input type="text" name="nombreCAl" id="nombreCAl" class="form-control" onkeypress="return ValidarLestrasC(event)" required>

                  <label> Dirección de correo electrónico:</label>
                  <input type="email" name="correoAl" id="correoAl" class="form-control" required>

                  <label> Teléfono:</label>
                  <input type="number" name="telefonoAl" id="telefonoAl" class="form-control" min="1111111111" onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                  <label for="">Equipo asignado IOT:</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipoIOT" name="idEquipoIOT" required>
                    <option value="">Selecciona un equipo</option>
                    <option value="1">No aplica</option>
                    <?php
                    $listaEIOT = $alumnos->equiposIOT('numSerieEquipo');
                    while ($row = mysqli_fetch_object($listaEIOT)) {
                      $idEquipo = $row->idEquipo;
                      $numSerieEquipo = $row->numSerieEquipo; ?>
                      <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
                    <?php } ?>
                  </select>

                  <label for="">Equipo asignado desarrollo:</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipoDesarrollo" name="idEquipoDesarrollo" required>
                    <option value="">Selecciona un equipo</option>
                    <option value="1">No aplica</option>
                    <?php
                    $listaED = $alumnos->equiposDESARROLLO('numSerieEquipo');
                    while ($row = mysqli_fetch_object($listaED)) {
                      $idEquipo = $row->idEquipo;
                      $numSerieEquipo = $row->numSerieEquipo; ?>
                      <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
                    <?php } ?>
                  </select>

                  <label for="">Equipo asignado soporte:</label>
                  <select class="form-select" aria-label="Default select example" id="idEquipoSoporte" name="idEquipoSoporte" required>
                    <option value="">Selecciona un equipo</option>
                    <option value="1">No aplica</option>
                    <?php
                    $listaES = $alumnos->equiposSOPORTE('numSerieEquipo');
                    while ($row = mysqli_fetch_object($listaES)) {
                      $idEquipo = $row->idEquipo;
                      $numSerieEquipo = $row->numSerieEquipo; ?>
                      <option value="<?php echo $idEquipo; ?>"><?php echo $numSerieEquipo; ?></option>
                    <?php } ?>
                  </select>

                  <label for="" class="col-form-label">Grupo</label>
                  <select class="form-select" aria-label="Default select example" id="idGrupo" name="idGrupo" required>
                    <option value="">Selecciona un grupo</option>
                    <?php
                    $listaEGrupos = $alumnos->readListaGrupo('nombreGrupo');
                    while ($row = mysqli_fetch_object($listaEGrupos)) {
                      $idGrupo = $row->idGrupo;
                      $nombreGrupo = $row->nombreGrupo; ?>
                      <option value="<?php echo $idGrupo; ?>"><?php echo $nombreGrupo; ?></option>
                    <?php } ?>
                  </select>

                  <label> Contraseña:</label>
                  <input type="text" name="contrasenaAl" id="contrasenaAl" class="form-control" onkeypress="return ValidarContrasena(event)" required>

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

  <?php include("../public/footer.php");?><!--Se incluye el footer-->

  <?php } else if ($_SESSION['idTipoUsuario'] != 1) { ?> <!--Condiciones de acceso-->
  <?php header("Location: ../index.php"); ?>
<?php } ?>