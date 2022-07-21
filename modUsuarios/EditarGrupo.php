<?php include("../public/header.php"); ?>

<marquee class="alert alert-p-3 mb-2 bg-light text-dark">
	<h2> Editar información</h2>
</marquee>
<!-- HIPERVÍNCULO -->
<a href="grupos.php">
	<h5> <button type="button" class="btn btn-outline-dark">Regresar</button></h5>
</a>


<?php //obtener id
if (isset($_GET['idGrupo'])) {
	$idGrupo = intval($_GET['idGrupo']);
} else {

	header("location: grupos.php");
}

?>




<?php
include("database.php");  //se incluye el otro archivo
$gruposR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
	$nombreGrupo = $gruposR->sanitize($_POST['nombreGrupo']);  //se va a limpiar y recibir lo del formulario
	$cantidadAlumnos = $gruposR->sanitize($_POST['cantidadAlumnos']);
	$idUsuario = $gruposR->sanitize($_POST['idUsuario']);
	$id_grupo = intval($_POST['id_grupo']); //Se agrega la variable para recibir el id



	$res = $gruposR->editarGrupo($nombreGrupo, $cantidadAlumnos, $idUsuario, $id_grupo); //se cambia la función y se agrega la variable creada arriba

	if ($res) {
		$message = "Datos actualizados con éxito";
		$class = "alert alert-success";
	} else {
		$message = "No se pudieron actualizar los datos...";
		$class = "alert alert-danger";
	}
?>
	<div class="<?php echo $class ?>">
		<?php echo $message; ?>
	</div>
<?php
}

//llamamos a la función
$datos_grupo = $gruposR->single_recordgrupo($idGrupo);
?>

<center>

	<div class="container-fluid">
		<form method="post">
			<div class="row">

				<div class="col-sm-4">
					<label> Nombre del grupo:</label>
					<input type="number" name="id_grupo" id="id_grupo" class="form-control" hidden value="<?php echo $datos_grupo->idGrupo; ?>"> <!-- Escondemos el id-->
					<input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control" value="<?php echo $datos_grupo->nombreGrupo; ?>">
				</div>

				<div class="col-sm-4">
					<label> Cantidad de alumnos: </label>
					<input type="number" name="cantidadAlumnos" id="cantidadAlumnos" class="form-control" value="<?php echo $datos_grupo->cantidadAlumnos; ?>">
				</div>


				<div class="col-sm-4">
					<label for="">Tutor</label>
					<select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario">
						<option selected hidden value="<?php echo  $datos_grupo->idUsuario; ?>">Mantener el mismo tutor </option>
						<?php
						$listaTutores = $gruposR->readMaestro('nombreC');
						while ($row = mysqli_fetch_object($listaTutores)) {
							$idUsuario = $row->idUsuario;
							$nombreC = $row->nombreC; ?>
							<option value="<?php echo $idUsuario ?>"><?php echo $nombreC ?></option>
						<?php } ?>
					</select>
				</div>


			</div>
</center>
<br>



<!-- Botón para enviar datos-->
<br />
<center>

	<button type="submit" class="btn btn-dark" onclick="return alertaEditar()">
		Actualizar datos
	</button>
</center>
<!-- Botón -->

</center>

</form>
</div>


<?php include("public/footer.php"); ?>