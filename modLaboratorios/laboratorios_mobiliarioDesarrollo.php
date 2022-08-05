<?php
$pagNom = 'LABORATORIO DE DESARROLLO';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>

	<?php
	include("../database.php");  //se incluye el otro archivo
	$mobiliarioR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

	if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
		$numInvMobiliario = $mobiliarioR->sanitize($_POST['numInvMobiliario']);  //se va a limpiar y recibir lo del formulario
		$seccionesDeMesa = $mobiliarioR->sanitize($_POST['seccionesDeMesa']);
		$descripcion = $mobiliarioR->sanitize($_POST['descripcion']);
		$idLaboratorio = $mobiliarioR->sanitize($_POST['idLaboratorio']);

		$res = $mobiliarioR->createMobiliario($numInvMobiliario, $seccionesDeMesa, $descripcion, $idLaboratorio, 1);

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
        <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Laboratorio de desarrollo</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioIOT.php">Laboratorio de IoT</a></li>
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioDesarrollo.php">Laboratorio de desarrollo</a></li>
            <li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioSoporte.php">Laboratorio de soporte</a></li>
        </ul>
        <abbr title="Detalles de laboratorios"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a></abbr>
    </div>

	<br>
	<div class="dropdown">
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Mobiliario</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosDesarrollo.php">Horarios</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposDesarrollo.php">Equipos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMonitorDesarrollo.php">Periféricos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioDesarrollo.php">Mobiliario</a></li>
		</ul>
		<a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#mobiliario">Realizar registro</a>
		<a href="herramientas_laboratorioDesarrollo/ReporteMobiliario_Desarrollo.php" target="_blank" class="btn btn-outline-dark">Reporte PDF</a>
	</div>

	<div class="container">
		<br>
		<table class="table table-bordered " cellspacing="0" width="100%" id="laboratorios_mobiliarioTableDesarrollo" style="background-color: #04aa89;  ">
			<thead>
				<tr>
					<th>N.º de Inv. Escolar</th>
					<th>N.º de secciones</th>
					<th>Descripción</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$mobiliarioR = new Database(); //
				$listaMobiliario = $mobiliarioR->readMobiliarioDesarrollo(); //se crea la variable listaAdministradores
				?>

				<?php
				while ($row = mysqli_fetch_object($listaMobiliario)) { //antes del = es la variable del form, después es la de BDD

					$idMobiliario = $row->idMobiliario;
					$numInvMobiliario = $row->numInvMobiliario;
					$seccionesDeMesa = $row->seccionesDeMesa;
					$descripcion = $row->descripcion;
					$estado = $row->estado;

				?>
					<tr>
						<td><?php echo $numInvMobiliario; ?></td> <!-- Muestra-->
						<td><?php echo $seccionesDeMesa; ?></td>
						<td><?php echo $descripcion; ?></td>
						<td><?php if ($estado == 1) {
								echo 'Activo';
							} else {
								echo 'Inactivo';
							} ?></td>
						<td>
							<?php if ($estado == 1) { ?>
								<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioDesarrollo/updateMobDesarrollo.php?idMobiliario=<?php echo $idMobiliario; ?>"><i class="fa fa-eye-slash"></i></a>

							<?php } else { ?>
								<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioDesarrollo/updateMobDesarrollo.php?idMobiliario=<?php echo $idMobiliario; ?>"><i class="fa fa-eye"></i></a>
							<?php } ?>
							<a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarMobiliario<?php echo $idMobiliario; ?>"><i class="fa-solid fa-pen-to-square"></i></a>

						</td>
					</tr>

					<!--modal para editar--->
					<div class="modal fade" id="editarMobiliario<?php echo $idMobiliario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<form method="POST" action="herramientas_laboratorioDesarrollo/editarMobiliarioDesarrollo.php">
									<input type="hidden" name="idMobiliario" value="<?php echo $idMobiliario; ?>">

									<div class="modal-body">

										<div class="form-group">
											<label for="recipient-name" class="col-form-label">N.º de Inv. Escolar </label>
											<input type="text" name="numInvMobiliario" id="numInvMobiliario" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numInvMobiliario; ?>" required="true">
										</div>

										<div class="form-group">
											<label for="" hidden>Laboratorio</label>
											<select hidden class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio">
												<?php
												$datos_Mobiliario = $mobiliarioR->single_recordMobiliario($idMobiliario);
												?>
												<option selected hidden value="<?php echo $datos_Mobiliario->idLaboratorio; ?>"></option>
											</select>
										</div>

										<div class="form-group">
											<label>N.º de secciones</label>
											<select class="form-select" aria-label="Default select example" name="seccionesDeMesa" id="seccionesDeMesa" required>
												<option selected hidden value="<?php echo $seccionesDeMesa; ?>"><?php echo $seccionesDeMesa; ?></option>
												<option value="Una sección">Una sección</option>
												<option value="Dos secciones">Dos secciones</option>
												<option value="Tres secciones">Tres secciones</option>
											</select>
										</div>

										<div class="form-group">
											<label>Descripcion</label>
											<textarea class="form-control" name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
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






	<!--Modal mobiliario-->


	<div class="modal fade" id="mobiliario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<h5 class="modal-title" id="exampleModalLabel">Registro de mobiliario</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<!--Campos-->

					<div class="container-fluid">
						<form method="post">
							<div class="row">

								<center>
									<div class="col-sm-10">
										<label>N.º de Inv. Escolar</label>
										<input type="number" name="numInvMobiliario" id="numInvMobiliario" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
									</div>
									<div class="col-sm-10">
										<label for="" hidden >Laboratorio</label>
										<select hidden class="form-select" aria-label="Default select example" id="idLaboratorio" name="idLaboratorio">
											<option selected value="2"></option>
										</select>
									</div>
									<div class="col-sm-10">
											<label>N.º de secciones</label>
											<select class="form-select" aria-label="Default select example" name="seccionesDeMesa" id="seccionesDeMesa" required>
												<option selected hidden value="">Selecciona el N.º de secciones</option>
												<option value="Una sección">Una sección</option>
												<option value="Dos secciones">Dos secciones</option>
												<option value="Tres secciones">Tres secciones</option>
											</select>
										</div>
									<div class="col-sm-10">
										<label>Descripción</label>
										<textarea class="form-control" name="descripcion" id="descripcion" required></textarea>
									</div>
								</center>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-primary" onclick="return alertaRegistrar()">Registrar</button>
							</div>
					</div>
				</div>
			</div>


			<?php include("../public/footer.php");
			?><?php } else { ?>
			<?php header("Location: ../index.php"); ?>
		<?php } ?>