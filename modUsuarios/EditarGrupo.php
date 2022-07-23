<?php //obtener id
if (isset($_GET['idGrupo'])) {
	$idGrupo = intval($_GET['idGrupo']);
} else {

	header("location: grupos.php");
}

?>

<?php
include("../database.php"); 
$gruposR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
	$idUsuario = $gruposR->sanitize($_POST['idUsuario']);
	$idGrupo = intval($_POST['idGrupo']); //Se agrega la variable para recibir el id
	$res = $gruposR->editarGrupo($idUsuario, $idGrupo); //Con esto editamos

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

?>