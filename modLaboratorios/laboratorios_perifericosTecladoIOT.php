<?php 
$pagNom = 'LABORATORIO DE IOT';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>
	<div class="container-fluid" styles="position:relative; z-index: -1;">

		<div class="container-fluid">
			<!--REGISTRAR TECLADO-->
			<?php
			include("../database.php");  //se incluye el otro archivo
			$perifericoT = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

			if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
				$numInvEscolar = $perifericoT->sanitize($_POST['escolarteclado']);
				$numSerie = $perifericoT->sanitize($_POST['numSerieteclado']);
				$marca = $perifericoT->sanitize($_POST['marcateclado']);
				$modelo = $perifericoT->sanitize($_POST['modeloteclado']);
				$estado = $perifericoT->sanitize($_POST['estadoteclado']);
				$idTipoPerifericos = $perifericoT->sanitize($_POST['perifteclado']);


				$res = $perifericoT->createPeriferico($numInvEscolar, $numSerie, $marca, $modelo, 1, 2, 1);

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
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoIOT.php">Laboratorio de IoT</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoDesarrollo.php">Laboratorio de desarrollo</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoSoporte.php">Laboratorio de soporte</a></li>
				</ul>
				<abbr title="Detalles de laboratorios"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a></abbr>
			</div>

			<br>
		<div class="dropdown" id="div-inline">
			<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
				Periféricos</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
				<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosIOT.php">Horarios</a></li>
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposIOT.php">Equipos</a></li>
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoIOT.php">Periféricos</a></li>
				<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioIOT.php">Mobiliario</a></li>
			</ul>
		</div>

			<div class="dropdown" id="div-inline">
				<button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					Teclado</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMonitorIOT.php">Monitor</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosTecladoIOT.php">Teclado</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMouseIOT.php">Mouse</a></li>
				</ul>
				<a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#perifericoteclado">Registrar</a>
			</div>

			<div class="container">
				<br>
				<table  class="table table-bordered " cellspacing="0" width="100%"  id="laboratorios_perifericosTecladoIOT" style="background-color: #04aa89;  ">
					<thead>
						<tr>
							<th>N.º de Inv. Escolar</th>
							<th>N.º de serie</th>
							<th>Marca</th>
							<th>Modelo</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$perifericoT = new Database(); //
						$listaTeclado = $perifericoT->readTecladoIOT(); //se crea la variable listaAdministradores
						?>

						<?php
						while ($row = mysqli_fetch_object($listaTeclado)) { //antes del = es la variable del form, después es la de BDD

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
										<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioIOT/updateTecladoIOT.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye-slash"></i></a>

									<?php } else { ?>
										<a type="button" class="btn btn-outline-dark" href="herramientas_laboratorioIOT/updateTecladoIOT.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye"></i></a>
									<?php } ?>
									<abbr title="Editar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarTeclado<?php echo $idPerifericos; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
								</td>
							</tr>

							<!--modal para editar--->
							<div class="modal fade" id="editarTeclado<?php echo $idPerifericos; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>

										<form method="POST" action="herramientas_laboratorioIOT/editarTecladoIOT.php">
											<input type="hidden" name="idPerifericos" value="<?php echo $idPerifericos; ?>">

											<div class="modal-body">

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">N.º de Inv. Escolar: </label>
													<input type="text" name="escolarteclado" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numInvEscolar; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">N.º de serie teclado: </label>
													<input type="text" name="numSerieteclado" class="form-control" min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numSerie; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">Marca: </label>
													<input type="text" name="marcateclado" class="form-control" value="<?php echo $marca; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">Modelo: </label>
													<input type="text" name="modeloteclado" class="form-control" value="<?php echo $modelo; ?>" required="true">
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

		<!--Modal Teclado-->
		<div class="modal fade" id="perifericoteclado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Registro de teclado</h5>
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
											<input type="number" name="perifteclado" id="perifteclado" class="form-control" hidden>
										</div>
										<div class="col-sm-10">
											<label>Número de inventario escolar</label>
											<input type="number" name="escolarteclado" id="escolarteclado" class="form-control" required min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
										</div>
										<div class="col-sm-10">
											<label>Número de serie del periférico</label>
											<input type="text" name="numSerieteclado" id="numSerieteclado" class="form-control" required min="1" onkeypress="return verificaNumInv(event);" maxlength="14" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
										</div>
										<div class="col-sm-10">
											<label>Marca</label>
											<input type="text" name="marcateclado" id="marcateclado" class="form-control" required>
										</div>
										<div class="col-sm-10">
											<label>Modelo</label>
											<input type="text" name="modeloteclado" id="modeloteclado" class="form-control" required>
										</div>
										<div class="col-sm-10">
											<label hidden>estado</label>
											<input type="text" name="estadoteclado" id="estadoteclado" class="form-control" hidden>
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
	</div>

	<?php include("../public/footer.php");
	?><?php } else { ?>
	<?php header("Location: ../index.php"); ?>
<?php } ?>