<?php 
$pagNom = 'LABORATORIOS';
?>


<?php include("../public/header.php"); ?>

<?php if ($idTipoUsuario == 1) { ?>

	<?php
	include("../database.php");
	$laboratoriosR = new Database(); //Instanciar el objeto


	if (isset($_POST) && !empty($_POST)) {
		$nombreLaboratorio = $laboratoriosR->sanitize($_POST['labNom']);
		$idUsuario = $laboratoriosR->sanitize($_POST['idUsuario']);
		$capacidad = $laboratoriosR->sanitize($_POST['labCap']);

		$res = $laboratoriosR->createLab($nombreLaboratorio, $idUsuario, $capacidad, 1);

		if ($res === true) {
			$message = "Datos insertados con éxito";
			$class = "alert alert-success";
		} else if($res == "duplicado") {
			$message = "Datos duplicados, no se pudo completar el registro...";
			$class = "alert alert-danger";
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
		<input type="radio" class="btn-check" name="labHor" id="labHor" autocomplete="off">
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios.php" for="labHor">Horarios</a>

		<input type="radio" class="btn-check" name="labLab" id="labLab" autocomplete="off" checked>
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php" for="labLab">Laboratorios</a>

		<input type="radio" class="btn-check" name="labEqu" id="labEqu" autocomplete="off">
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_equipos.php" for="labEqu">Equipos</a>

		<input type="radio" class="btn-check" name="labMob" id="labMob" autocomplete="off">
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_mobiliario.php" for="labMob">Mobiliario</a>

		<input type="radio" class="btn-check" name="labPer" id="LabPer" autocomplete="off">
		<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_perifericos.php" for="labPer">Periféricos</a>
	</div>

	<br>
	<br /> <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#laboratorio">Realizar registro</a>
	<br>



	<br />
	<div class="container">
		<table class="table table-bordered" cellspacing="0" width="100%"  id="laboratorios_laboratoriosTable" style="background-color: #04aa89;">
			<thead>
				<tr>
					<th>Nombres de laboratorio</th>
					<th>Encargado</th>
					<th>Capacidad</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<!-- Cuerpo de la tabla, se llena con la BDD-->
				<?php
				$laboratoriosR = new Database(); //
				$listaLabs = $laboratoriosR->readLab(); //se crea la variable listaAdministradores
				?>

				<?php
				while ($row = mysqli_fetch_object($listaLabs)) { //antes del = es la variable del form, después es la de BDD

					$idLaboratorio = $row->idLaboratorio;
					$nombreLaboratorio = $row->nombreLaboratorio;
					$nombreC = $row->nombreC;
					$capacidad = $row->capacidad;
					$estado = $row->estado;

				?>
					<tr>
						<td><?php echo $nombreLaboratorio; ?></td> <!-- Muestra-->
						<td><?php echo $nombreC; ?></td>
						<td><?php echo $capacidad; ?></td>
						<td><?php if ($estado == 1) {
								echo 'Activo';
							} else {
								echo 'Inactivo';
							} ?></td>
						<td>
							<abbr title="Editar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarLaboratorio<?php echo $idLaboratorio; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
							<?php
							if ($estado == 1) { ?>
								<abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateLab.php?idLaboratorio=<?php echo $idLaboratorio; ?>"><i class="fa fa-eye-slash"></i></a></abbr>
							<?php } else { ?>
								<abbr title="Habilitar"><a type="button" class="btn btn-outline-dark" href="updateLab.php?idLaboratorio=<?php echo $idLaboratorio; ?>"><i class="fa fa-eye"></i></a></abbr>
							<?php } ?>
						</td>
					</tr>

					<!--modal para editar--->
					<div class="modal fade" id="editarLaboratorio<?php echo $idLaboratorio; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<form method="POST" action="editarLaboratorio.php">
									<input type="hidden" name="idLaboratorio" value="<?php echo $idLaboratorio; ?>">

									<div class="modal-body">

										<div class="form-group">
											<label for="recipient-name" class="col-form-label">Nombre: </label>
											<input type="text" name="labNom" class="form-control" value="<?php echo $nombreLaboratorio; ?>" required="true">
										</div>

										<div class="form-group">
											<label for="" class="col-form-label">Encargado: </label>
											<select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario">
												<?php
												$datos_laboratorio = $laboratoriosR->single_recordLaboratorio($idLaboratorio);
												?>
												<option selected hidden value="<?php echo $datos_laboratorio->idUsuario; ?>"><?php echo $nombreC; ?></option>
												<?php
												$listaEncargadosEdit = $laboratoriosR->readAdministradorAct('nombreC');
												while ($row = mysqli_fetch_object($listaEncargadosEdit)) {
													$idUsuario = $row->idUsuario;
													$nombreC = $row->nombreC; ?>
													<option value="<?php echo $idUsuario; ?>"><?php echo $nombreC; ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group">
											<label for="recipient-name" class="col-form-label">Capacidad: </label>
											<input type="number" name="labCap" class="form-control" value="<?php echo $capacidad; ?>" min="1" onkeypress="return verificaNumeros(event);" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required="true">
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
										<button type="submit" class="btn btn-primary" onclick="return alertaEditar()">Guardar cambios</button>
									</div>
								</form>

							</div>
						</div>
					</div>
					<!---fin modal editar --->



				<?php
				}
				?>
			</tbody>
		</table>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> 



	<!--Modal laboratorio-->
	<div class="modal fade" id="laboratorio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Registro de laboratorio</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<form method="post">
							<div class="row">
								<!--Campos-->
								<center>
									<div class="col-sm-10">
										<label>Nombre de laboratorio</label>
										<input type="text" name="labNom" id="labNom" class="form-control" required>
									</div>
									<div class="col-sm-10">
										<label for="">Nombre encargado</label>
										<select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario">
											<option selected disabled>Selecciona un encargado:</option>
											<?php
											$listaLaboratorios = $laboratoriosR->readAdministradorAct('idUsuario');
											while ($row = mysqli_fetch_object($listaLaboratorios)) {
												$idUsuario = $row->idUsuario;
												$nombreC = $row->nombreC; ?>
												<option value="<?php echo $idUsuario; ?>"><?php echo $nombreC; ?></option>
											<?php } ?>


										</select>
									</div>
									<div class="col-sm-10">
										<label>Capacidad</label>
										<input type="number" name="labCap" id="labCap" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="3" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
									</div>
								</center>
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

	<?php include("../public/footer.php");  ?><?php } else { ?>
	<?php header("Location: ../index.php"); ?>
<?php } ?>