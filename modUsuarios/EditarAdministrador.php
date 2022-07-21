<?php //obtener id
if (isset($_GET['idUsuario'])) {
	$idUsuario = intval($_GET['idUsuario']);
} else {
	header("location: ../modUsuarios/usuarioAdministrador.php");
}
?>

<?php
include("../database.php");  //se incluye el otro archivo
$administradoresR = new Database();  //generamos la variable pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
	$numConAdmin = $administradoresR->sanitize($_POST['numConAdmin']);  //se va a limpiar y recibir lo del formulario
	$nombreC = $administradoresR->sanitize($_POST['nombreC']);
	$correo = $administradoresR->sanitize($_POST['correo']);
	$telefono = $administradoresR->sanitize($_POST['telefono']);
	$contrasena = $administradoresR->sanitize($_POST['contrasena']);
	$idUsuario = intval($_POST['idUsuario']); //Se agrega la variable para recibir el id
	$res = $administradoresR->editarAdministrador($nombreC, $correo, $telefono, $contrasena, $numConAdmin, $idUsuario); //se cambia la función y se agrega la variable creada arriba

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