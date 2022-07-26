<?php 
$pagNom = 'LABORATORIO DE DESARROLLO';
?>

<?php include("../public/header.php"); ?>

<?php
include "conn.php";
include "../database.php";
?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'sigelab');
?>


<?php if ($idTipoUsuario == 1) { ?>

    <div class="dropdown">
        <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Laboratorio de desarrollo</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" value="1" href="../modLaboratorios/laboratorios.php">Laboratorio de IoT</a></li>
            <li><a class="dropdown-item" value="2" href="../modLaboratorios/laboratoriosD.php">Laboratorio de desarrollo</a></li>
            <li><a class="dropdown-item" value="3" href="../modLaboratorios/laboratoriosS.php">Laboratorio de soporte</a></li>
        </ul>
        <a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratorios.php"><i class="fa-solid fa-list"></i></a>
    </div>

<br>
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
	<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
	<a class="btn btn-outline-dark" href="../modLaboratorios/laboratoriosD.php" for="btnradio1">Horarios</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
	<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_equiposD.php" for="btnradio3">Equipos</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
	<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_perifericosD.php" for="btnradio5">Periféricos</a>

	<input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
	<a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_mobiliarioD.php" for="btnradio4">Mobiliario</a>
</div>

<br>
<br />
<button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#archivos">Subir horario</button>
<abbr title="Detalles"><a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_horariosD.php"><i class="fa-solid fa-list"></i></a></abbr>
<br>

<div class="container">
	<br>
	<table  class="table table-bordered " cellspacing="0" width="100%"  id="tabla1" style="background-color: #04aa89;">
		<thead>
			<tr>
				<th><center>Horario</center></th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<!-- Cuerpo de la tabla, se llena con la BDD-->
			<?php
			$horariospdf = new Database(); //
			$listaHorariospdf = $horariospdf->PDFReadDesarrollo(); //se crea la variable listaAdministradores
			?>

			<?php
			while ($row = mysqli_fetch_object($listaHorariospdf)) { //antes del = es la variable del form, después es la de BDD

				$idHorariospdf = $row->idHorariospdf;
				$url = $row->url;
			?>
				<tr>
					<td><center><iframe src="<?php echo $url ?>" height="400px" width="950px"></iframe></center></td>
					<td><center><a onclick="openModelPDF('<?php echo $url ?>')" type="button" class="btn btn-outline-dark" title="Ver PDF"><i class="fa-solid fa-magnifying-glass-plus"></i></a>
						<abbr title="Borrar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="eliminarPDF.php?idHorariospdf=<?php echo $idHorariospdf ?>"><i class="fa-solid fa-trash-can"></i></a></abbr></center>
					</td>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<?php } else if ($idTipoUsuario == 2 || $idTipoUsuario == 3) { ?>


	<div class="container">
	<br>
	<table class="table table-bordered" id="tabla1" style="background-color: #04aa89;">
		<thead>
			<tr>
				<th>Horario</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<!-- Cuerpo de la tabla, se llena con la BDD-->
			<?php
			$horariospdf = new Database(); //
			$listaHorariospdf = $horariospdf->PDFReadDesarrollo(); //se crea la variable listaAdministradores
			?>

			<?php
			while ($row = mysqli_fetch_object($listaHorariospdf)) { //antes del = es la variable del form, después es la de BDD

				$idHorariospdf = $row->idHorariospdf;
				$url = $row->url;
			?>
				<tr>
					<td><iframe src="<?php echo $url ?>" height="400px" width="800px"></iframe></td>
					<td><a onclick="openModelPDF('<?php echo $url ?>')" type="button" class="btn btn-outline-dark" title="Ver PDF"><i class="fa-solid fa-magnifying-glass-plus"></i></a>
					</td>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>

<?php } else {?>
  	<?php header("Location: ../index.php"); ?>
<?php } ?>

<!-- Modal pdf-->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
										<option selected value="Laboratorio de desarrollo"></option>
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