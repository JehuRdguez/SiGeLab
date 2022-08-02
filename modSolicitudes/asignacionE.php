
<?php //obtener id
if (isset($_GET['idUsuario'])){
    $idUsuario=intval($_GET['idUsuario']);
}
else{
   header("location: ../modSolicitudes/solicitudEquipo.php"); 
}
?>

  <?php
  include("../database.php");  //se incluye el otro archivo
  $solicitudAL= new Database();  //generamos la variable pq eso es lo que vamos a generar, con esto instanciamos
if(isset($_POST) && !empty($_POST)){ //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  //se va a limpiar y recibir lo del formulario

$idEquipoIOT= $solicitudAL->sanitize($_POST['idEquipoIOT']);
$idEquipoDesarrollo= $solicitudAL->sanitize($_POST['idEquipoDesarrollo']);
$idEquipoSoporte= $solicitudAL->sanitize($_POST['idEquipoSoporte']);
$idUsuario=intval($_POST['idUsuario']); //Se agrega la variable para recibir el id

$sname = "localhost";
$uname = "root";
$password = "";
$bd_name = "sigelab";

$conn = mysqli_connect($sname, $uname, $password, $bd_name);
if(!$conn){
	echo "Error!";
	exit();
}



$validar="SELECT* FROM vwValidaEquipos where idEquipoIOT>1 and idEquipoIOT='$idEquipoIOT' and idGrupo='$idGrupo' and idUsuario!='$idUsuario'";
$validando=$conn->query($validar);
$validar2="SELECT* FROM vwValidaEquipos where idEquipoDesarrollo>1 and idEquipoDesarrollo='$idEquipoDesarrollo' and idGrupo='$idGrupo' and idUsuario!='$idUsuario'";
$validando2=$conn->query($validar2);
$validar3="SELECT* FROM vwValidaEquipos where idEquipoSoporte>1 and idEquipoSoporte='$idEquipoSoporte' and idGrupo='$idGrupo' and idUsuario!='$idUsuario'";
$validando3=$conn->query($validar3);

if($validando->num_rows>0 || $validando2->num_rows>0 || $validando3->num_rows>0 ){
$message = "El equipo o equipos ya fueron asignados";
$class = "alert alert-danger";
}
else{

$res = $solicitudAL->editarUAlumnoE($idEquipoIOT,$idEquipoDesarrollo,$idEquipoSoporte,$idUsuario);
		if($res){
			$message = "Datos actualizados con éxito";
			$class ="alert alert-success";
		}else{
			$message = "No se pudieron actualizar los datos...";
			$class = "alert alert-danger";
		}}
		?>
      <div class="<?php echo $class ?>"> 
 		<?php echo $message;?>
	  </div>
	  <?php
	  }
	
	 
	  
	  $datos_solicitudAL = $solicitudAL->single_recordusuarioAl($idUsuario);
	 

 ?>