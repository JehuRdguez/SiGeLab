<?php 
$pagNom = 'LABORATORIOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>
	<div class="container-fluid" styles="position:relative; z-index: -1;">

		<div class="container-fluid">
			<!--REGISTRAR GABINETE-->
			<?php
			include("../database.php");  //se incluye el otro archivo
			$perifericoG = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

			if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
				$numInvEscolar = $perifericoG->sanitize($_POST['escolargabinete']);
				$numSerieGabinete = $perifericoG->sanitize($_POST['numSeriegabinete']);
				$marca = $perifericoG->sanitize($_POST['marcagabinete']);
				$modelo = $perifericoG->sanitize($_POST['modelogabinete']);
				$estado = $perifericoG->sanitize($_POST['estadogabinete']);
				$idTipoPerifericos = $perifericoG->sanitize($_POST['perifgabinete']);


				$res = $perifericoG->createGabinete($numInvEscolar, $numSerieGabinete, $marca, $modelo, 1, 3);

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


		<!--BOTONES DE SECCIONES-->
		<br>
		<div class="container-fluid">
			<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
				<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
				<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios.php" for="btnradio1">Horarios</a>

				<input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
				<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php" for="btnradio2">Laboratorios</a>

				<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
				<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_equipos.php" for="btnradio3">Equipos</a>

				<input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
				<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_mobiliario.php" for="btnradio4">Mobiliario</a>

				<input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off" checked>
				<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_perifericos.php" for="btnradio5">Periféricos</a>
			</div>
		</div>


		<!--LISTA DE GABINETE-->
		<div id="vistagabinete" class="container-fluid">
			<br>
			<div class="dropdown">
				<button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					Gabinete</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericos.php">Monitor</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosT.php">Teclado</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosG.php">Gabinete</a></li>
					<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosM.php">Mouse</a></li>
				</ul>
				<a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#perifericogabinete">Registrar</a>
			</div>

			<div class="container">
				<br>
				<table  class="table table-bordered " cellspacing="0" width="100%"  id="laboratorios_perifericosgabinete" style="background-color: #04aa89;  ">
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
						$perifericoG = new Database(); //
						$listaGabinete = $perifericoG->readGabinete(); //se crea la variable listaAdministradores
						?>

						<?php
						while ($row = mysqli_fetch_object($listaGabinete)) { //antes del = es la variable del form, después es la de BDD

							$idPerifericos = $row->idPerifericos;
							$numInvEscolar = $row->numInvEscolar;
							$numSerieGabinete = $row->numSerieGabinete;
							$marca = $row->marca;
							$modelo = $row->modelo;
							$estado = $row->estado;
						?>
							<tr>
								<td><?php echo $numInvEscolar; ?></td>
								<td><?php echo $numSerieGabinete; ?></td>
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
										<a type="button" class="btn btn-outline-dark" href="updateGabinete.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye-slash"></i></a>

									<?php } else { ?>
										<a type="button" class="btn btn-outline-dark" href="updateGabinete.php?idPerifericos=<?php echo $idPerifericos; ?>"><i class="fa fa-eye"></i></a>
									<?php } ?>
									<abbr title="Editar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarGabinete<?php echo $idPerifericos; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
								</td>
							</tr>

							<!--modal para editar--->
							<div class="modal fade" id="editarGabinete<?php echo $idPerifericos; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Editar</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>

										<form method="POST" action="editarGabinete.php">
											<input type="hidden" name="idPerifericos" value="<?php echo $idPerifericos; ?>">

											<div class="modal-body">

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">N.º de Inv. Escolar: </label>
													<input type="text" name="escolargabinete" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numInvEscolar; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">N.º de serie gabinete: </label>
													<input type="text" name="numSeriegabinete" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="<?php echo $numSerieGabinete; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">Marca: </label>
													<input type="text" name="marcagabinete" class="form-control" value="<?php echo $marca; ?>" required="true">
												</div>

												<div class="form-group">
													<label for="recipient-name" class="col-form-label">Modelo: </label>
													<input type="text" name="modelogabinete" class="form-control" value="<?php echo $modelo; ?>" required="true">
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


		<!--Modal Gabinete-->
		<div class="modal fade" id="perifericogabinete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Registro de gabinete</h5>
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
											<input type="number" name="perifgabinete" id="perifgabinete" class="form-control" hidden>
										</div>
										<div class="col-sm-10">
											<label>Número de inventario escolar</label>
											<input type="number" name="escolargabinete" id="escolargabinete" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
										</div>
										<div class="col-sm-10">
											<label>Número de serie del periférico</label>
											<input type="text" name="numSeriegabinete" id="numSeriegabinete" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
										</div>
										<div class="col-sm-10">
											<label>Marca</label>
											<input type="text" name="marcagabinete" id="marcagabinete" class="form-control">
										</div>
										<div class="col-sm-10">
											<label>Modelo</label>
											<input type="text" name="modelogabinete" id="modelogabinete" class="form-control">
										</div>
										<div class="col-sm-10">
											<label hidden>estado</label>
											<input type="text" name="estadogabinete" id="estadogabinete" class="form-control" hidden>
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


		<?php include("../public/footer.php"); ?>
	<?php } else { ?>
		<?php header("Location: ../index.php"); ?>
	<?php } ?>