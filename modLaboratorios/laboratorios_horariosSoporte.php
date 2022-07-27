<?php
$pagNom = 'LABORATORIO DE SOPORTE';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>
	<!--Condiciones para tipo usuario -->
	<?php
	$sname = "localhost";
	$uname = "root";
	$password = "";
	$bd_name = "sigelab";

	$conn = mysqli_connect($sname, $uname, $password, $bd_name);
	if (!$conn) {
		echo "Error!";
		exit();
	}
	?>

	<?php
	include("../database.php");
	$horariosR = new Database(); //Instanciar el objeto

	if (isset($_POST) && !empty($_POST)) {
		$idUsuario = $horariosR->sanitize($_POST['nomMae']);
		$materia = $horariosR->sanitize($_POST['materia']);
		$idGrupo = $horariosR->sanitize($_POST['grupo']);
		$dia = $horariosR->sanitize($_POST['dia']);
		$horaEntrada = $horariosR->sanitize($_POST['horaE']);
		$horaSalida = $horariosR->sanitize($_POST['horaS']);
		$idLaboratorio = $horariosR->sanitize($_POST['lab']);
		$horasPorCuatri = $horariosR->sanitize($_POST['horasCuatri']);


		$res = $horariosR->createHorarios($idUsuario, $materia, $idGrupo, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, 1);

		if ($res) {
			$message = "Datos insertados con éxito";
			$class = "alert alert-success";
		} else {
			$message = "No se pudieron insertar los datos..";
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
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Laboratorio de soporte</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" value="1" href="../modLaboratorios/laboratorios_horariosIOT.php">Laboratorio de IoT</a></li>
			<li><a class="dropdown-item" value="2" href="../modLaboratorios/laboratorios_horariosDesarrollo.php">Laboratorio de desarrollo</a></li>
			<li><a class="dropdown-item" value="3" href="../modLaboratorios/laboratorios_horariosSoporte.php">Laboratorio de soporte</a></li>
		</ul>
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a>
	</div>

	<br>
	<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
		<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
		<a class="btn btn-outline-dark" href="laboratoriosSoporte.php" for="btnradio1">Horarios</a>

		<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
		<a class="btn btn-outline-dark" href="laboratorios_equiposSoporte.php" for="btnradio3">Equipos</a>

		<input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
		<a class="btn btn-outline-dark" href="laboratorios_perifericosMonitorSoporte.php" for="btnradio5">Periféricos</a>

		<input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
		<a class="btn btn-outline-dark" href="laboratorios_mobiliarioSoporte.php" for="btnradio4">Mobiliario</a>
	</div>


	<br>
	<br /> <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#horario">Registrar</a>
	<abbr title="Regresar"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratoriosSoporte.php"><i class="fa-solid fa-person-walking-arrow-loop-left"></i></a></abbr>
	<br>




	<div class="container">
		<br>
		<table class="table table-bordered " cellspacing="0" width="100%" id="laboratorios_horariosTableSoporte" style="background-color: #04aa89;">
			<thead>
				<tr>
					<th>Maestro</th>
					<th>Materia</th>
					<th>Grupo</th>
					<th>Día</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<!-- Cuerpo de la tabla, se llena con la BDD-->
				<?php
				$horariosR = new Database(); //
				$listaHorarios = $horariosR->readHorariosSoporte(); //se crea la variable listaAdministradores
				?>

				<?php
				while ($row = mysqli_fetch_object($listaHorarios)) { //antes del = es la variable del form, después es la de BDD

					$idHorarios = $row->idHorarios;
					$idGrupo = $row->idGrupo;
					$nombreC = $row->nombreC;
					$materia = $row->materia;
					$nombreGrupo = $row->nombreGrupo;
					$dia = $row->dia;
					$horaEntrada = $row->horaEntrada;
					$horaSalida = $row->horaSalida;
					$horasPorCuatri = $row->horasPorCuatri;
					$estado = $row->estado;
				?>
					<tr>
						<td><?php echo $nombreC; ?></td>
						<td><?php echo $materia; ?></td>
						<td><?php echo $nombreGrupo; ?></td>
						<td><?php echo $dia; ?></td>
						<td><?php if ($estado == 1) {
								echo 'Activo';
							} else {
								echo 'Inactivo';
							} ?></td>
						<td>
							<?php
							if ($estado == 1) { ?>
								<a type="button" class="btn btn-outline-dark" href="updateHorarios.php?idHorarios=<?php echo $idHorarios; ?>"><i class="fa fa-eye-slash"></i></a>
							<?php } else { ?>
								<a type="button" class="btn btn-outline-dark" href="updateHorarios.php?idHorarios=<?php echo $idHorarios; ?>"><i class="fa fa-eye"></i></a>
							<?php } ?>
							<abbr title="Editar"><button type="button" style="border-color:#0c1a30;" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarHorarios<?php echo $idHorarios; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
							<abbr title="Detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesHorarios<?php echo $idHorarios; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>

						</td>
					</tr>

					<!--modal para editar--->
					<div class="modal fade" id="editarHorarios<?php echo $idHorarios; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<form method="POST" action="editarHorarios.php">
									<input type="hidden" name="idHorarios" value="<?php echo $idHorarios; ?>">

									<div class="modal-body">

										<div class="form-group">
											<label for="">Maestro</label>
											<select class="form-select" aria-label="Default select example" id="nomMae" name="nomMae">
												<?php
												$datos_horarios = $horariosR->single_recordHorarios($idHorarios);
												?>
												<option selected hidden value="<?php echo $datos_horarios->idUsuario; ?>"><?php echo $nombreC; ?></option>
												<?php
												$listaHorariosEdit = $horariosR->readListaTutores('nombreC');
												while ($row = mysqli_fetch_object($listaHorariosEdit)) {
													$idUsuario = $row->idUsuario;
													$nombreC = $row->nombreC; ?>
													<option value="<?php echo $idUsuario; ?>"><?php echo $nombreC; ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group">
											<label>Materia</label>
											<input type="text" name="materia" id="materia" class="form-control" value="<?php echo $materia; ?>" required>
										</div>

										<div class="form-group">
											<label for="">Grupo</label>
											<select class="form-select" aria-label="Default select example" id="grupo" name="grupo">
												<?php
												$datos_horarios = $horariosR->single_recordHorarios($idHorarios);
												?>
												<option selected hidden value="<?php echo $datos_horarios->idGrupo; ?>"><?php echo $nombreGrupo; ?></option>
												<?php
												$listaHorariosEdit = $horariosR->readGrupos('nombreGrupo');
												while ($row = mysqli_fetch_object($listaHorariosEdit)) {
													$idGrupo = $row->idGrupo;
													$nombreGrupo = $row->nombreGrupo; ?>
													<option value="<?php echo $idGrupo; ?>"><?php echo $nombreGrupo; ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group">
											<label>Día</label>
											<select class="form-select" aria-label="Default select example" name="dia" id="dia" required>
												<option selected hidden><?php echo $dia; ?></option>
												<option value="Lunes">Lunes</option>
												<option value="Martes">Martes</option>
												<option value="Miércoles">Miércoles</option>
												<option value="Jueves">Jueves</option>
												<option value="Viernes">Viernes</option>
											</select>
										</div>


										<div class="form-group">
											<label>Hora entrada</label><abbr title="Los horarios son de 7:30am a 2:35pm"><sup>&#128712;</sup></abbr>
											<input type="time" name="horaE" id="horaEntrada" min="07:30" max="19:00" class="form-control" value="<?php echo $horaEntrada; ?>" required>
										</div>

										<div class="form-group">
											<label>Hora salida</label><abbr title="Los horarios son de 7:30am a 2:35pm"><sup>&#128712;</sup></abbr>
											<input type="time" name="horaS" id="horaSalida" min="08:20" max="20:35" class="form-control" value="<?php echo $horaSalida; ?>" required>
										</div>

										<div class="form-group">
											<label hidden for="">Laboratorio</label>
											<select hidden class="form-select" aria-label="Default select example" id="lab" name="lab">
												<?php
												$datos_horarios = $horariosR->single_recordHorarios($idHorarios);
												?>
												<option selected hidden value="<?php echo $datos_horarios->idLaboratorio; ?>"><?php echo $nombreLaboratorio; ?></option>
											</select>
										</div>

										<div class="form-group">
											<label>Horas por cuatrimestre</label>
											<input type="text" name="horasCuatri" id="horasCuatri" class="form-control" value="<?php echo $horasPorCuatri; ?>" required>
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
					<div class="modal fade" id="detallesHorarios<?php echo $idHorarios; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
								</div>

								<div class="modal-body">
									<?php
									$datos_horarios = $horariosR->single_recordHorariosDet($idHorarios);
									?>

									</br><label>Cantidad de alumnos en <?php echo $datos_horarios->nombreGrupo; ?>: <strong><?php
																															$contar = ($conn->query("SELECT COUNT(*)  FROM cantidadAlumnos where idGrupo='$idGrupo'")); //Contar la cantidad de alumnos registrados con ese grupo
																															echo $contar->fetch_column(); ?></strong></label></br>

									</br><label>Hora de entrada: <strong><?php echo $datos_horarios->horaEntrada; ?></strong></label></br>

									</br><label>Hora de salida: <strong><?php echo $datos_horarios->horaSalida; ?></strong></label></br>

									</br><label>Hora por cuatrimestre: <strong><?php echo $datos_horarios->horasPorCuatri; ?></strong></label></br>



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




	<!--Modal horario-->
	<div class="modal fade" id="horario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Registro de horario</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form method="post">
							<div class="row">
								<!--Campos-->
								<center>

									<div class="col-sm-10">
										<label for="">Maestro</label>
										<select class="form-select" aria-label="Default select example" id="nomMae" name="nomMae" required>
											<option selected disabled value="">Selecciona una tutor:</option>
											<?php
											$listaHorarios = $horariosR->readListaTutores('nombreC');
											while ($row = mysqli_fetch_object($listaHorarios)) {
												$idUsuario = $row->idUsuario;
												$nombreC = $row->nombreC; ?>
												<option value="<?php echo $idUsuario ?>"><?php echo $nombreC ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-10">
										<label>Materia</label>
										<input type="text" name="materia" id="materia" class="form-control" required>
									</div>
									<div class="col-sm-10">
										<label for="">Grupo</label>
										<select class="form-select" aria-label="Default select example" id="grupo" name="grupo" required>
											<option selected disabled value="">Seleccionar un grupo:</option>
											<?php
											$listaHorarios = $horariosR->readGrupos('nombreGrupo');
											while ($row = mysqli_fetch_object($listaHorarios)) {
												$idGrupo = $row->idGrupo;
												$nombreGrupo = $row->nombreGrupo;
												$cantidadAlumnos = $row->cantidadAlumnos; ?>
												<option value="<?php echo $idGrupo ?>"><?php echo $nombreGrupo ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="col-sm-10">
										<label>Día</label>
										<select class="form-select" aria-label="Default select example" name="dia" id="dia" required>
											<option selected disabled value="">Selecciona el día:</option>
											<option value="Lunes">Lunes</option>
											<option value="Martes">Martes</option>
											<option value="Miércoles">Miércoles</option>
											<option value="Jueves">Jueves</option>
											<option value="Viernes">Viernes</option>
										</select>
									</div>

									<div class="col-sm-10">
										<label>Hora entrada</label><abbr title="Los horarios son de 7:30am a 2:35pm"><sup>&#128712;</sup></abbr>
										<input type="time" name="horaE" id="horaEntrada" min="07:30" max="19:00" class="form-control" required>
									</div>

									<div class="col-sm-10">
										<label>Hora salida</label><abbr title="Los horarios son de 7:30am a 2:35pm"><sup>&#128712;</sup></abbr>
										<input type="time" name="horaS" id="horaSalida" min="08:20" max="20:35" class="form-control" required>
									</div>


									<div class="col-sm-10">
										<label for="" hidden>Laboratorio</label>
										<select hidden class="form-select" aria-label="Default select example" id="lab" name="lab" requiered>
											<option selected value="3"></option>
										</select>
									</div>
									<div class="col-sm-10">
										<label>Horas por cuatrimestre</label>
										<input type="number" name="horasCuatri" id="horasCuatri" class="form-control" required min="1" onkeypress="return verificaNumeros(event);" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
									</div>
									<div class="col-sm-10">
										<label hidden>Estado</label>
										<select class="form-select" aria-label="Default select example" name="estado" id="estado" hidden>
											<option selected disabled>Selecciona el estado:</option>
											<option value="1">Activo</option>
											<option value="0">Inactivo</option>
										</select>
									</div>

								</center>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-primary">Registrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include("../public/footer.php"); ?>
	<!--Se incluye el footer-->

<?php } else if ($_SESSION['idTipoUsuario'] != 1) { ?>
	<!--Condiciones de acceso-->
	<?php header("Location: ../index.php"); ?>
<?php } ?>