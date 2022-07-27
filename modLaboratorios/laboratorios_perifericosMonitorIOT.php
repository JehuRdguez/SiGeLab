<?php
$pagNom = 'LABORATORIO DE IOT';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>
	<div class="container-fluid" styles="position:relative; z-index: -1;">

		<div class="container-fluid">
			<!--REGISTRAR MONITOR-->
			<?php
			include("../database.php");  //se incluye el otro archivo
			$perifericoM = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

			if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
				$numInvEscolar = $perifericoM->sanitize($_POST['escolarmonitor']);
				$numSerie = $perifericoM->sanitize($_POST['numSerieMonitor']);
				$marca = $perifericoM->sanitize($_POST['marcamonitor']);
				$modelo = $perifericoM->sanitize($_POST['modelomonitor']);
				$estado = $perifericoM->sanitize($_POST['estadomonitor']);
				$idTipoPerifericos = $perifericoM->sanitize($_POST['perifmonitor']);

				$res = $perifericoM->createPeriferico($numInvEscolar, $numSerie, $marca, $modelo, 1, 1, 1);

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
		</div>

		<div class="dropdown">
			<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				Laboratorio de IoT</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				<li><a class="dropdown-item" value="1" href="../modLaboratorios/laboratorios_perifericosMonitorIOT.php">Laboratorio de IoT</a></li>
				<li><a class="dropdown-item" value="2" href="../modLaboratorios/laboratorios_perifericosMonitorDesarrollo.php">Laboratorio de desarrollo</a></li>
				<li><a class="dropdown-item" value="3" href="../modLaboratorios/laboratorios_perifericosMonitorSoporte.php">Laboratorio de soporte</a></li>
			</ul>
			<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a>
		</div>

		<!--BOTONES DE SECCIONES-->
		<br>
		<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
			<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
			<a class="btn btn-outline-dark" href="../modLaboratorios/laboratoriosIOT.php" for="btnradio1">Horarios</a>

			<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
			<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_equiposIOT.php" for="btnradio3">Equipos</a>

			<input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off" checked>
			<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_perifericosMonitorIOT.php" for="btnradio5">Periféricos</a>

			<input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
			<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_mobiliarioIOT.php" for="btnradio4">Mobiliario</a>
		</div>
		<!--BOTONES DE PERIFERICOS-->

		<!--LISTA DE MONITORES-->
		<br></br>
		<div class="dropdown">
			<button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				Monitor</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMonitorIOT.php">Monitor</a></li>
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoIOT.php">Teclado</a></li>
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMouseIOT.php">Mouse</a></li>
			</ul>
			<a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#perifericomonitor">Registrar</a>
		</div>

		<div class="container">
			<br>
			<table class="table table-bordered " cellspacing="0" width="100%" id="laboratorios_perifericosMonitorIOT" style="background-color: #04aa89;  ">
				<thead>
					<tr>
						<th>N.º de Inv. Escolar</th>
						<th>N.º de serie monitor</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$perifericoM = new Database(); //
					$listaMonitor = $perifericoM->readMonitorIOT(); //se crea la variable listaAdministradores
					?>

					<?php
					while ($row = mysqli_fetch_object($listaMonitor)) { //antes del = es la variable del form, después es la de BDD

						$idPerifericos = $row->idPerifericos;
						$numInvEscolar = $row->numInvEscolar;
						$numSerie = $row->numSerie;
						$marca = $row->marca;
						$modelo = $row->modelo;
						$estado = $row->estado;
					?>
						<tr>
							<td><?php echo $numInvEscolar; ?></td>
							<td><?php echo $numSerie; ?></td>
							<td><?php echo $marca; ?></td>
							<td><?php echo $modelo; ?></td>
							<td><?php if ($estado == 1) {
									echo 'Activo';
								} else {
									echo 'Inactivo';
								} ?></td>
							<td>
								<?php
								if ($estado == 1) { ?>
									<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioIOT/updateMonitorIOT.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye-slash"></i></a>

								<?php } else { ?>
									<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioIOT/updateMonitorIOT.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye"></i></a>
								<?php } ?>
								<abbr title="Editar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarMonitor<?php echo $idPerifericos; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>

							</td>
						</tr>

						<!--modal para editar--->
						<div class="modal fade" id="editarMonitor<?php echo $idPerifericos; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>

									<form method="POST" action="herramientas_laboratorioIOT/editarMonitorIOT.php">
										<input type="hidden" name="idPerifericos" value="<?php echo $idPerifericos; ?>">

										<div class="modal-body">

											<div class="form-group">
												<label for="recipient-name" class="col-form-label">N.º de Inv. Escolar: </label>
												<input type="text" name="escolarmonitor" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numInvEscolar; ?>" required="true">
											</div>

											<div class="form-group">
												<label for="recipient-name" class="col-form-label">N.º de serie monitor: </label>
												<input type="text" name="numSerieMonitor" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numSerie; ?>" required="true">
											</div>

											<div class="form-group">
												<label for="recipient-name" class="col-form-label">Marca: </label>
												<input type="text" name="marcamonitor" class="form-control" value="<?php echo $marca; ?>" required="true">
											</div>

											<div class="form-group">
												<label for="recipient-name" class="col-form-label">Modelo: </label>
												<input type="text" name="modelomonitor" class="form-control" value="<?php echo $modelo; ?>" required="true">
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
	</div>

	<!--Modal Monitor-->
	<div class="modal fade" id="perifericomonitor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Registro de monitor</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">

					<!--Campos-->

					<div class="container-fluid">
						<form method="post">
							<div class="row">

								<center>
									<div class="col-sm-10">
										<label hidden>Tipo de periférico</label>
										<input type="number" name="perifmonitor" id="perifmonitor" class="form-control" hidden>
									</div>
									<div class="col-sm-10">
										<label>Número de inventario escolar</label>
										<input type="number" name="escolarmonitor" id="escolarmonitor" required class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
									</div>
									<div class="col-sm-10">
										<label>Número de serie del periférico</label>
										<input type="number" name="numSerieMonitor" id="numSerieMonitor" required class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
									</div>
									<div class="col-sm-10">
										<label>Marca</label>
										<input type="text" name="marcamonitor" id="marcamonitor" class="form-control" required>
									</div>
									<div class="col-sm-10">
										<label>Modelo</label>
										<input type="text" name="modelomonitor" id="modelomonitor" class="form-control" required>
									</div>
									<div class="col-sm-10">
										<label hidden>estado</label>
										<input type="text" name="estadomonitor" id="estadomonitor" class="form-control" hidden>
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









	<!--REVISAR-->
	<script type="text/javascript">
		function funcionMonitor() {
			var x = document.getElementById("vistamonitor");
			var y = document.getElementById("vistateclado");
			var z = document.getElementById("vistagabinete");
			var m = document.getElementById("vistamouse");


			if (x.style.display == "none" || y.style.display == "block" || z.style.display == "none" || m.style.display == "none") {
				y.style.display = "none";
				x.style.display = "block";
				z.style.display = "none";
				m.style.display = "none";
			}
		}

		function funcionTeclado() {
			var x = document.getElementById("vistamonitor");
			var y = document.getElementById("vistateclado");
			var z = document.getElementById("vistagabinete");
			var m = document.getElementById("vistamouse");

			if (x.style.display == "block" || y.style.display == "none" || z.style.display == "none" || m.style.display == "none") {
				y.style.display = "block";
				x.style.display = "none";
				z.style.display = "none";
				m.style.display = "none";
			}
		}

		function funcionGabinete() {
			var x = document.getElementById("vistamonitor");
			var y = document.getElementById("vistateclado");
			var z = document.getElementById("vistagabinete");
			var m = document.getElementById("vistamouse");

			if (x.style.display == "none" || y.style.display == "none" || z.style.display == "block" || m.style.display == "none") {
				y.style.display = "none";
				x.style.display = "none";
				z.style.display = "block";
				m.style.display = "none";
			}
		}

		function funcionMouse() {
			var x = document.getElementById("vistamonitor");
			var y = document.getElementById("vistateclado");
			var z = document.getElementById("vistagabinete");
			var m = document.getElementById("vistamouse");

			if (x.style.display == "none" || y.style.display == "none" || z.style.display == "none" || m.style.display == "block") {
				y.style.display = "none";
				x.style.display = "none";
				z.style.display = "none";
				m.style.display = "block";
			}
		}


		element = document.getElementById("vistamonitor");
		element2 = document.getElementById("vistateclado");
		element3 = document.getElementById("vistagabinete");
		element4 = document.getElementById("vistamouse");

		element.style.display = 'block';
		element2.style.display = 'none';
		element3.style.display = 'none';
		element4.style.display = 'none';
	</script>

	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>


	<?php include("../public/footer.php"); ?>
<?php } else { ?>
	<?php header("Location: ../index.php"); ?>
<?php } ?>