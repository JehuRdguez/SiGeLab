<?php
$pagNom = 'LABORATORIO DE DESARROLLO';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>

  <?php
  include("../database.php");
  $equiposR = new Database(); //Instanciar el objeto

  if (isset($_POST) && !empty($_POST)) {
    $nombreLaboratorio = $equiposR->sanitize($_POST['lab']);
    $numInvEscolar = $equiposR->sanitize($_POST['numInvEscolar']);
    $numSerieEquipo = $equiposR->sanitize($_POST['numSerieEquipo']);
    $numMonitor = $equiposR->sanitize($_POST['numMon']);
    $numTeclado = $equiposR->sanitize($_POST['numTec']);
    $numMouse = $equiposR->sanitize($_POST['numMou']);
    $ubicacionEnMesa = $equiposR->sanitize($_POST['ubiMesa']);
    $procesador = $equiposR->sanitize($_POST['procesador']);
    $discoDuro = $equiposR->sanitize($_POST['discoDuro']);
    $ram = $equiposR->sanitize($_POST['ram']);


    $sname = "localhost";
    $uname = "root";
    $password = "";
    $bd_name = "sigelab";
    
    $conn = mysqli_connect($sname, $uname, $password, $bd_name);
    if(!$conn){
        echo "Error!";
        exit();
    }

$validar="SELECT* FROM equipo where numMonitor>1 and numMonitor='$numMonitor' and estado=1 and idEquipo!='$idEquipo'";
$validando=$conn->query($validar);
$validar2="SELECT* FROM equipo where numTeclado>1 and numTeclado='$numTeclado' and estado=1 and idEquipo!='$idEquipo'";
$validando2=$conn->query($validar2);
$validar3="SELECT* FROM equipo where numMouse>1 and numMouse='$numMouse' and estado=1 and idEquipo!='$idEquipo'";
$validando3=$conn->query($validar3);

if($validando->num_rows>0 || $validando2->num_rows>0 || $validando3->num_rows>0 ){
  $message = "El periférico o periféricos ya fueron asignados";
  $class = "alert alert-danger";
}
else{

  $res = $equiposR->createEquipo($nombreLaboratorio, $numInvEscolar, $numSerieEquipo, $numMonitor, $numTeclado, $numMouse, $ubicacionEnMesa, $procesador, $discoDuro, $ram, 1);


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
  }
  ?>
    <div class="<?php echo $class ?>">
      <?php echo $message; ?>
    </div>
  <?php
  }
  ?>

<div class="dropdown">
        <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Laboratorio de desarrollo</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposIOT.php">Laboratorio de IoT</a></li>
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposDesarrollo.php">Laboratorio de desarrollo</a></li>
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposSoporte.php">Laboratorio de soporte</a></li>
        </ul>
        <abbr title="Detalles de laboratorios"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a></abbr>
    </div>

  	<br>
	<div class="dropdown">
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Equipos</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosDesarrollo.php">Horarios</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposDesarrollo.php">Equipos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMonitorDesarrollo.php">Periféricos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioDesarrollo.php">Mobiliario</a></li>
		</ul>
    <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#equipo">Realizar registro</a>
  <a href="herramientas_laboratorioDesarrollo/ReporteEquipos_Desarrollo.php" target="_blank" class="btn btn-outline-dark">Reporte PDF</a>
	</div>

  <div class="container">
    <br>
    <table class="table table-bordered " cellspacing="0" width="100%" id="laboratorios_equiposTableDesarrollo" style="background-color: #04aa89;  ">
      <thead>
        <tr>
          <th>N.º de Inv. Escolar</th>
          <th>N.º de serie equipo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!-- Cuerpo de la tabla, se llena con la BDD-->
        <?php
        $equiposR = new Database(); //
        $listaEquipos = $equiposR->readEquipoDesarrollo(); //se crea la variable listaAdministradores
        ?>

        <?php
        while ($row = mysqli_fetch_object($listaEquipos)) { //antes del = es la variable del form, después es la de BDD

          $idEquipo = $row->idEquipo;
          $nombreLaboratorio = $row->nombreLaboratorio;
          $numInvEscolar = $row->numInvEscolar;
          $numSerieEquipo = $row->numSerieEquipo;
          $numInvEscMon = $row->numInvEscMon;
          $numInvEscTec = $row->numInvEscTec;
          $numInvEscMou = $row->numInvEscMou;
          $ubicacionEnMesa = $row->ubicacionEnMesa;
          $procesador = $row->procesador;
          $discoDuro = $row->discoDuro;
          $ram = $row->ram;
          $estado = $row->estado;

        ?>
          <tr>
            <td><?php echo $numInvEscolar; ?></td>
            <td><?php echo $numSerieEquipo; ?></td>
            <td><?php if ($estado == 1) {
                  echo 'Activo';
                } else {
                  echo 'Inactivo';
                } ?></td>
            <td>
              <center>
                <?php
                if ($estado == 1) { ?>
                  <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioDesarrollo/updateEquipoDesarrollo.php?idEquipo=<?php echo $idEquipo; ?>"><i class="fa fa-eye-slash"></i></a></abbr>
                <?php } else { ?>
                  <abbr title="Habilitar"><a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioDesarrollo/updateEquipoDesarrollo.php?idEquipo=<?php echo $idEquipo; ?>"><i class="fa fa-eye"></i></a></abbr>
                <?php } ?>
                <abbr title="Editar"><button type="button" style="border-color:#0c1a30;" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarEquipos<?php echo $idEquipo; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
                <!--Botón para detalles-->
                <abbr title="Detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesEquipos<?php echo $idEquipo; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
              </center>
            </td>
          </tr>

          <!--modal para editar--->
          <div class="modal fade" id="editarEquipos<?php echo $idEquipo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="herramientas_laboratorioDesarrollo/editarEquipoDesarrollo.php">
                  <input type="hidden" name="idEquipo" value="<?php echo $idEquipo; ?>">

                  <div class="modal-body">

                  <div class="form-group">
                      <label for="" class="col-form-label">Laboratorio: </label>
                      <select class="form-select" aria-label="Default select example" id="lab" name="lab">
                        <?php
                        $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                        ?>
                        <option selected hidden value="<?php echo $datos_equipos->idLaboratorio; ?>"><?php echo $nombreLaboratorio; ?></option>
                        <?php
                        $listaEquiposEdit = $equiposR->readLabAct('nombreLaboratorio');
                        while ($row = mysqli_fetch_object($listaEquiposEdit)) {
                          $idLaboratorio = $row->idLaboratorio;
                          $nombreLaboratorio = $row->nombreLaboratorio; ?>
                          <option value="<?php echo $idLaboratorio; ?>"><?php echo $nombreLaboratorio; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">N.º de Inv. Escolar: </label>
                      <input type="number" name="numInvEscolar" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numInvEscolar; ?>" required="true">
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">N.º de serie equipo: </label>
                      <input type="number" name="numSerieEquipo" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numSerieEquipo; ?>" required="true">
                    </div>

                    <div class="form-group">
                      <label for="" class="col-form-label">N.º de serie monitor: </label>
                      <select class="form-select" aria-label="Default select example" id="numMon" name="numMon">
                        <option value="1">Pendiente</option>
                        <?php
                        $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                        ?>
                        <option selected hidden value="<?php echo $datos_equipos->numMonitor; ?>"><?php echo $numInvEscMon; ?></option>
                        <?php
                        $listaMonitorEdit = $equiposR->readMonitorAct('numInvEscolar');
                        while ($row = mysqli_fetch_object($listaMonitorEdit)) {
                          $idPerifericos = $row->idPerifericos;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idPerifericos; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-form-label">N.º de serie teclado: </label>
                      <select class="form-select" aria-label="Default select example" id="numTec" name="numTec">
                        <option value="1">Pendiente</option>
                        <?php
                        $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                        ?>
                        <option selected hidden value="<?php echo $datos_equipos->numTeclado; ?>"><?php echo $numInvEscTec; ?></option>
                        <?php
                        $listaTecladoEdit = $equiposR->readTecladoAct('numInvEscolar');
                        while ($row = mysqli_fetch_object($listaTecladoEdit)) {
                          $idPerifericos = $row->idPerifericos;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idPerifericos; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="" class="col-form-label">N.º de serie mouse: </label>
                      <select class="form-select" aria-label="Default select example" id="numMou" name="numMou">
                        <option value="1">Pendiente</option>
                        <?php
                        $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                        ?>
                        <option selected hidden value="<?php echo $datos_equipos->numMouse; ?>"><?php echo $numInvEscMou; ?></option>
                        <?php
                        $listaMouseEdit = $equiposR->readMouseAct('numInvEscolar');
                        while ($row = mysqli_fetch_object($listaMouseEdit)) {
                          $idPerifericos = $row->idPerifericos;
                          $numInvEscolar = $row->numInvEscolar; ?>
                          <option value="<?php echo $idPerifericos; ?>"><?php echo $numInvEscolar; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Procesador: </label>
                      <input type="text" name="procesador" class="form-control" value="<?php echo $procesador; ?>" min="1" maxlength="25" required="true">
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Ubicación en mesa: </label>
                      <?php
                      $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                      ?>
                      <select class="form-select" aria-label="Default select example" name="ubiMesa" value="<?php echo $ubicacionEnMesa; ?>" required>
                        <option selected hidden value="<?php echo $datos_equipos->ubicacionEnMesa; ?>"><?php echo $ubicacionEnMesa; ?></option>
                        <option value="Sección derecha">Sección derecha</option>
                        <option value="Sección central">Sección central</option>
                        <option value="Sección izquierda">Sección izquierda</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Disco duro: </label>
                      <?php
                      $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                      ?>
                      <select class="form-select" aria-label="Default select example" name="discoDuro" id="discoDuro" required>
                      <option selected hidden value="<?php echo $datos_equipos->discoDuro; ?>"><?php echo $discoDuro; ?></option>
                      <option value="64 GB">64 GB</option>
                      <option value="90 GB">90 GB</option>
                      <option value="128 GB">128 GB</option>
                      <option value="256 GB">256 GB</option>
                      <option value="512 GB">512 GB</option>
                      <option value="1 TB">1 TB</option>
                      <option value="2 TB">2 TB</option>
                      <option value="3 TB">3 TB</option>
                    </select>
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">RAM: </label>
                      <?php
                      $datos_equipos = $equiposR->single_recordequipo($idEquipo);
                      ?>
                      <select class="form-select" aria-label="Default select example" name="ram" id="ram" required>
                      <option selected hidden value="<?php echo $datos_equipos->ram; ?>"><?php echo $ram; ?></option>
                      <option value="512 MB">512 MB</option>
                      <option value="1 GB">1 GB</option>
                      <option value="2 GB">2 GB</option>
                      <option value="4 GB">4 GB</option>
                      <option value="8 GB">8 GB</option>
                      <option value="16 GB">16 GB</option>
                      <option value="32 GB">32 GB</option>
                      <option value="64 GB">64 GB</option>
                    </select>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" onclick="return alertaRegistrar()">Guardar cambios</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!---fin modal editar --->

          <!-- modal para detalles -->
          <div class="modal fade" id="detallesEquipos<?php echo $idEquipo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                </div>

                <div class="modal-body">
                  <?php
                  $datos_equipos = $equiposR->single_recordequipoDet($idEquipo);
                  ?>
                  <label>N.º Inv. Escolar de monitor: <strong><?php echo $datos_equipos->numInvEscMon;
                                                              ?></strong></label></br>

                  </br><label>N.º Inv. Escolar de teclado: <strong><?php echo $datos_equipos->numInvEscTec;
                                                                    ?></strong></label></br>

                  </br><label>N.º Inv. Escolar de mouse: <strong><?php echo $datos_equipos->numInvEscMou;
                                                                  ?></strong></label></br>

                  </br><label>Ubicación en mesa: <strong><?php echo $datos_equipos->ubicacionEnMesa; ?></strong></label></br>

                  </br><label>Procesador: <strong><?php echo $datos_equipos->procesador; ?></strong></label></br>

                  </br><label>Disco duro: <strong><?php echo $datos_equipos->discoDuro; ?></strong></label></br>

                  </br><label>RAM: <strong><?php echo $datos_equipos->ram; ?></strong></label></br>

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

  <!--Modal registrar equipo-->
  <div class="modal fade" id="equipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registro de equipo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <form method="post">
              <div class="row">
                <!--Campos-->
                <center>
                  <div class="col-sm-10">
                    <label for="" hidden>Laboratorio</label>
                    <select hidden class="form-select" aria-label="Default select example" id="lab" name="lab" required>
                      <option selected value="2"></option>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label>N.º de Inv. Escolar</label>
                    <input type="text" name="numInvEscolar" id="numInvEscolar" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                  </div>
                  <div class="col-sm-10">
                    <label>N.º de serie equipo</label>
                    <input type="text" name="numSerieEquipo" id="numSerieEquipo" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="30" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                  </div>
                  <div class="col-sm-10">
                    <label for="">N.º de serie monitor</label>
                    <select class="form-select" aria-label="Default select example" id="numMon" name="numMon" required>
                      <option value="" selected disabled hidden>Selecciona un monitor:</option>
                      <option value="1">Pendiente</option>
                      <?php
                      $listaEquipos = $equiposR->readMonitorAct('numInvEscolar');
                      while ($row = mysqli_fetch_object($listaEquipos)) {
                        $idPerifericos = $row->idPerifericos;
                        $numInvEscolar = $row->numInvEscolar; ?>
                        <option value="<?php echo $idPerifericos ?>"><?php echo $numInvEscolar ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label for="">N.º de serie teclado</label>
                    <select class="form-select" aria-label="Default select example" id="numTec" name="numTec" required>
                      <option value="" selected disabled hidden>Selecciona un teclado:</option>
                      <option value="1">Pendiente</option>
                      <?php
                      $listaEquipos = $equiposR->readTecladoAct('numInvEscolar');
                      while ($row = mysqli_fetch_object($listaEquipos)) {
                        $idPerifericos = $row->idPerifericos;
                        $numInvEscolar = $row->numInvEscolar; ?>
                        <option value="<?php echo $idPerifericos ?>"><?php echo $numInvEscolar ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label for="">N.º de serie mouse</label>
                    <select class="form-select" aria-label="Default select example" id="numMou" name="numMou" required>
                      <option value="" selected disabled hidden>Selecciona un mouse:</option>
                      <option value="1">Pendiente</option>
                      <?php
                      $listaEquipos = $equiposR->readMouseAct('numInvEscolar');
                      while ($row = mysqli_fetch_object($listaEquipos)) {
                        $idPerifericos = $row->idPerifericos;
                        $numInvEscolar = $row->numInvEscolar; ?>
                        <option value="<?php echo $idPerifericos ?>"><?php echo $numInvEscolar ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label>Procesador</label>
                    <input type="text" name="procesador" id="procesador" class="form-control" min="1" maxlength="25" required>
                  </div>
                  <div class="col-sm-10">
                    <label>Ubicación en mesa</label>
                    <select class="form-select" aria-label="Default select example" name="ubiMesa" id="ubiMesa" required>
                      <option selected disabled hidden value="">Selecciona la ubicación:</option>
                      <option value="Sección derecha">Sección derecha</option>
                      <option value="Sección central">Sección central</option>
                      <option value="Sección izquierda">Sección izquierda</option>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label>Disco duro</label>
                    <select class="form-select" aria-label="Default select example" name="discoDuro" id="discoDuro" required>
                    <option selected disabled hidden value="">Selecciona la cantidad:</option>
                      <option value="64 GB">64 GB</option>
                      <option value="90 GB">90 GB</option>
                      <option value="128 GB">128 GB</option>
                      <option value="256 GB">256 GB</option>
                      <option value="512 GB">512 GB</option>
                      <option value="1 TB">1 TB</option>
                      <option value="2 TB">2 TB</option>
                      <option value="3 TB">3 TB</option>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label>RAM</label>
                    <select class="form-select" aria-label="Default select example" name="ram" id="ram" required>
                    <option selected disabled hidden value="">Selecciona la cantidad:</option>
                      <option value="512 MB">512 MB</option>
                      <option value="1 GB">1 GB</option>
                      <option value="2 GB">2 GB</option>
                      <option value="4 GB">4 GB</option>
                      <option value="8 GB">8 GB</option>
                      <option value="16 GB">16 GB</option>
                      <option value="32 GB">32 GB</option>
                      <option value="64 GB">64 GB</option>
                    </select>
                  </div>
                  <div class="col-sm-10">
                    <label hidden>Estado</label>
                    <select class="form-select" aria-label="Default select example" name="estado" id="estado" hidden>
                      <option selected hidden disabled>Selecciona el estado:</option>
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                </center>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="return alertaRegistrar()">Registrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



  <?php include("../public/footer.php");
  ?><?php } else { ?>
  <?php header("Location: ../index.php"); ?>
<?php } ?>