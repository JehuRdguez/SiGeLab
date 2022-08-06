

<?php
$pagNom = 'LABORATORIO DE IOT';
?>

<?php 
include("../public/header.php"); 
?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'sigelab');
?>

<?php
include "conn.php";
include "../database.php";

?>

<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>

	<div class="dropdown">
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Laboratorio de IoT</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosIOT.php">Laboratorio de IoT</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosDesarrollo.php">Laboratorio de desarrollo</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosSoporte.php">Laboratorio de soporte</a></li>
		</ul>
		<abbr title="Detalles de laboratorios"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a></abbr>
	</div>

	<br>
	<div class="dropdown">
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Horarios</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" href="../modLaboratorios/laboratoriosIOT.php">Horarios</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_equiposIOT.php">Equipos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_perifericosMonitorIOT.php">Periféricos</a></li>
			<li><a class="dropdown-item" href="../modLaboratorios/laboratorios_mobiliarioIOT.php">Mobiliario</a></li>
		</ul>
		<button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#archivos">Subir horario</button>
		<abbr title="Detalles de horarios"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_horariosIOT.php"><i class="fa-solid fa-list"></i></a></abbr>
	</div>
	
	<div class="container">
		<br>
		<table class="table table-bordered " cellspacing="0" width="100%" id="laboratorios_TableIOT" style="background-color: #04aa89;">
			<thead>
				<tr>
					<th><center>Horarios</center></th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$horariospdf = new Database(); //
				$listaHorariospdf = $horariospdf->PDFReadIOT(); 
				?>

				<?php
				while ($row = mysqli_fetch_object($listaHorariospdf)) { 

					$idHorariospdf = $row->idHorariospdf;
					$url = $row->url;
				?>
					<tr>
						<td>
							<center><iframe src="<?php echo $url ?>" height="400px" width="950px"></iframe></center>
						</td>
						<td>
							<center>
								<abbr title="Borrar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="herramientas_laboratorioIOT/eliminarPDFIOT.php?idHorariospdf=<?php echo $idHorariospdf ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>
							</center>
						</td>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	
<?php } else if ($_SESSION['idTipoUsuario'] == 2 || $_SESSION['idTipoUsuario'] == 3) { ?>

	<div class="dropdown">
		<button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			Laboratorio de IoT</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" value="1" href="../modLaboratorios/laboratoriosIOT.php">Laboratorio de IoT</a></li>
			<li><a class="dropdown-item" value="2" href="../modLaboratorios/laboratoriosDesarrollo.php">Laboratorio de desarrollo</a></li>
			<li><a class="dropdown-item" value="3" href="../modLaboratorios/laboratoriosSoporte.php">Laboratorio de soporte</a></li>
		</ul>
	</div>


	<div class="container">
		<br>
		<table class="table table-bordered" id="laboratorios_TableIOTUsuario" style="background-color: #04aa89;">
			<thead>
				<tr>
					<th></th>
			</thead>
			<tbody>
				<!-- Cuerpo de la tabla, se llena con la BDD-->
				<?php
				$horariospdf = new Database(); //
				$listaHorariospdf = $horariospdf->PDFReadIOT(); //se crea la variable listaAdministradores
				?>

				<?php
				while ($row = mysqli_fetch_object($listaHorariospdf)) { //antes del = es la variable del form, después es la de BDD

					$idHorariospdf = $row->idHorariospdf;
					$url = $row->url;
				?>
					<tr>
						<td><center><iframe src="<?php echo $url ?>" height="500px" width="1100px"></iframe></center></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>

<?php } else { ?>
	<?php header("Location: ../index.php"); ?>
<?php } ?>

<!-- Modal pdf-->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form method="post">
						<div class="row">
							<!--Campos-->
							<center>
								<div class="modal-body">
									<iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
								</div>
							</center>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal pdf-->
<div class="modal fade" id="archivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" height="400px" width="600px">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Nuevo PDF</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form method="post" id="form1">
						<div class="row">
							<!--Campos-->
							<center>

								<div class="col-sm-20">
									<label for="" hidden>Laboratorio</label>
									<select hidden class="form-select" aria-label="Default select example" id="nombrepdf" name="nombrepdf" required>
										<option selected value="Laboratorio de IoT"></option>
									</select>
								</div>

								<div class="col-sm-20">
									<label>Archivo PDF</label><abbr title="No pueden haber dos archivos PDF de un mismo laboratorio, elimine el anterior archivo PDF antes de insertar uno nuevo."><sup>&#128712;</sup></abbr>
									<input type="file" name="file" id="file" class="form-control">
								</div>
							</center>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-primary" onclick="onSubmitForm()">Registrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<?php include("../public/footer.php"); ?>