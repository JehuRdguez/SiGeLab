<?php 
$pagNom = 'LABORATORIOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>

<?php
include("../database.php");
$horariosR = new Database(); //Instanciar el objeto

if (isset($_POST) && !empty($_POST)) {
	$idUsuario = $horariosR->sanitize($_POST['nomMae']);
	$materia = $horariosR->sanitize($_POST['materia']);
	$idGrupo = $horariosR->sanitize($_POST['grupo']);
	$cantidad = $horariosR->sanitize($_POST['canAl']);
	$dia = $horariosR->sanitize($_POST['dia']);
	$horaEntrada = $horariosR->sanitize($_POST['horaE']);
	$horaSalida = $horariosR->sanitize($_POST['horaS']);
	$idLaboratorio = $horariosR->sanitize($_POST['lab']);
	$horasPorCuatri = $horariosR->sanitize($_POST['horasCuatri']);


	$res = $horariosR->createHorarios($idUsuario, $materia, $idGrupo, $cantidad, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, 1);

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

<br>
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
	<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
	<a class="btn btn-outline-dark" href="laboratorios.php" for="btnradio1">Horarios</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
	<a class="btn btn-outline-dark" href="laboratorios_laboratorios.php" for="btnradio2">Laboratorios</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
	<a class="btn btn-outline-dark" href="laboratorios_equipos.php" for="btnradio3">Equipos</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
	<a class="btn btn-outline-dark" href="laboratorios_mobiliario.php" for="btnradio4">Mobiliario</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
	<a class="btn btn-outline-dark" href="laboratorios_perifericos.php" for="btnradio5">Periféricos</a>
</div>


<br>
<br /> <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#horario">Registrar</a>
<abbr title="Regresar"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios.php"><i class="fa-solid fa-person-walking-arrow-loop-left"></i></a></abbr>
<br>




<div class="container">
	<br>
	<table class="table table-bordered " cellspacing="0" width="100%"  id="laboratoriosTable" style="background-color: #04aa89;">
		<thead>
			<tr>
				<th>Maestro</th>
				<th>Materia</th>
				<th>Grupo</th>
				<th>Día</th>
				<th>Laboratorio</th>
				<th>Estado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<!-- Cuerpo de la tabla, se llena con la BDD-->
			<?php
			$horariosR = new Database(); //
			$listaHorarios = $horariosR->readHorarios(); //se crea la variable listaAdministradores
			?>

			<?php
			while ($row = mysqli_fetch_object($listaHorarios)) { //antes del = es la variable del form, después es la de BDD

				$idHorarios = $row->idHorarios;
				$nombreC = $row->nombreC;
				$materia = $row->materia;
				$nombreGrupo = $row->nombreGrupo;
				$cantidad = $row->cantidad;
				$dia = $row->dia;
				$horaEntrada = $row->horaEntrada;
				$horaSalida = $row->horaSalida;
				$nombreLaboratorio = $row->nombreLaboratorio;
				$horasPorCuatri = $row->horasPorCuatri;
				$estado = $row->estado;
			?>
				<tr>
					<td><?php echo $nombreC; ?></td>
					<td><?php echo $materia; ?></td>
					<td><?php echo $nombreGrupo; ?></td>
					<td><?php echo $dia; ?></td>
					<td><?php echo $nombreLaboratorio; ?></td>
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
						<a type="button" class="btn btn-outline-dark" href="editarHorarios.php?idHorarios=<?php echo $idHorarios; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
						<abbr title="Detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesHorarios<?php echo $idHorarios; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>

					</td>
				</tr>


				<!-- modal para detalles -->
				<div class="modal fade" id="detallesHorarios<?php echo $idHorarios; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
							</div>

							<div class="modal-body">
								<?php
								$datos_horarios = $horariosR->single_recordHorarios($idHorarios);
								?>

								</br><label>Cantidad de alumnos: <strong><?php echo $datos_horarios->cantidad; ?></strong></label></br>

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
									<select class="form-select" aria-label="Default select example" id="nomMae" name="nomMae">
										<option selected disabled>Selecciona una tutor:</option>
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
									<input type="text" name="materia" id="materia" class="form-control">
								</div>
								<div class="col-sm-10">
									<label for="">Grupo</label>
									<select class="form-select" aria-label="Default select example" id="grupo" name="grupo">
										<option selected disabled>Seleccionar un grupo:</option>
										<?php
										$listaHorarios = $horariosR->readGrupos('nombreGrupo');
										while ($row = mysqli_fetch_object($listaHorarios)) {
											$idGrupo = $row->idGrupo;
											$nombreGrupo = $row->nombreGrupo; ?>
											<option value="<?php echo $idGrupo ?>"><?php echo $nombreGrupo ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-sm-10">
									<label>Cantidad de alumnos</label>
									<input type="number" name="canAl" id="canAl" class="form-control" min="1" max="50" onkeypress="return verificaNumeros(event);" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-sm-10">
									<label>Día</label>
									<select class="form-select" aria-label="Default select example" name="dia" id="dia" required>
									<option selected disabled>Selecciona el día:</option>
										<option value="Lunes">Lunes</option>
										<option value="Martes">Martes</option>
										<option value="Miércoles">Miércoles</option>
										<option value="Jueves">Jueves</option>
										<option value="Viernes">Viernes</option>								</div>
										</select>
												</div>
								<div class="col-sm-10">
									<label>Hora entrada</label>
									<input type="time" name="horaE" id="horaE" class="form-control">
								</div>
								<div class="col-sm-10">
									<label>Hora salida</label>
									<input type="time" name="horaS" id="horaS" class="form-control">
								</div>
								<div class="col-sm-10">
									<label for="">Laboratorio</label>
									<select class="form-select" aria-label="Default select example" id="lab" name="lab">
										<option selected disabled>Selecciona un laboratorio:</option>
										<?php
										$listaHorarios = $horariosR->readLabAct('idLaboratorio');
										while ($row = mysqli_fetch_object($listaHorarios)) {
											$idLaboratorio = $row->idLaboratorio;
											$nombreLaboratorio = $row->nombreLaboratorio; ?>
											<option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
										<?php } ?>
									</select>



								</div>
								<div class="col-sm-10">
									<label>Horas por cuatrimestre</label>
									<input type="number" name="horasCuatri" id="horasCuatri" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
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


	<?php include("../public/footer.php"); 
	 ?><?php } else { ?>
	<?php header("Location: ../index.php"); ?>
	  <?php } ?>