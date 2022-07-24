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
	
    $sname = "localhost";
    $uname = "root";
    $password = "";
    $bd_name = "sigelab";
    
    $conn = mysqli_connect($sname, $uname, $password, $bd_name);
    if(!$conn){
        echo "Error!";
        exit();
    }



$validar="SELECT* FROM vwValidaTutor where  idUsuario='$idUsuario'";
$validando=$conn->query($validar);

if($validando->num_rows>0 ){
  $message = "El tutor ya está asignado a un grupo";
  $class = "alert alert-danger";
}
else{
	$res = $gruposR->editarGrupo($idUsuario, $idGrupo); //Con esto editamos

	if ($res) {
		$message = "Datos actualizados con éxito";
		$class = "alert alert-success";
	} else {
		$message = "No se pudieron actualizar los datos...";
		$class = "alert alert-danger";
	}
}
?>
	<div class="<?php echo $class ?>">
		<?php echo $message; ?>
	</div>
<?php
}

?>