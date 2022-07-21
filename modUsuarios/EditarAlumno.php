
<?php //obtener id
if (isset($_GET['idUsuario'])){
    $idUsuario=intval($_GET['idUsuario']);
}
else{
   header("location: ../modUsuarios/usuarioAlumno.php"); 
}
?>

  <?php
  include("../database.php");  //se incluye el otro archivo
  $alumnos= new Database();  //generamos la variable pq eso es lo que vamos a generar, con esto instanciamos
if(isset($_POST) && !empty($_POST)){ //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  //se va a limpiar y recibir lo del formulario
$nombreC = $alumnos->sanitize($_POST['nombreCAl']);
$correo = $alumnos->sanitize($_POST['correoAl']);
$telefono = $alumnos->sanitize($_POST['telefonoAl']);
$contrasena= $alumnos->sanitize($_POST['contrasenaAl']);
$numConAlum = $alumnos->sanitize($_POST['numConAlum']);
$idGrupo = $alumnos->sanitize($_POST['idGrupo']);
$idEquipoIOT= $alumnos->sanitize($_POST['idEquipoIOT']);
$idEquipoDesarrollo= $alumnos->sanitize($_POST['idEquipoDesarrollo']);
$idEquipoSoporte= $alumnos->sanitize($_POST['idEquipoSoporte']);
$idUsuario=intval($_POST['idUsuario']); //Se agrega la variable para recibir el id
$res = $alumnos->editarUAlumno($nombreC,$correo,$telefono,$contrasena,$numConAlum,$idGrupo,$idEquipoIOT,$idEquipoDesarrollo,$idEquipoSoporte,$idUsuario);
		if($res){
			$message = "Datos actualizados con éxito";
			$class ="alert alert-success";
		}else{
			$message = "No se pudieron actualizar los datos...";
			$class = "alert alert-danger";
		}
		?>
      <div class="<?php echo $class ?>"> 
 		<?php echo $message;?>
	  </div>
	  <?php
	  }

 ?>