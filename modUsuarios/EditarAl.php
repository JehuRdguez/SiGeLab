<?php include("../public/header.php"); ?>
<h2 ><center>LISTADOS DE USUARIOS ALUMNOS</h2>  
<?php //obtener id
if (isset($_GET['idUsuario'])){
    $idUsuario=intval($_GET['idUsuario']);
}

?>


<?php
include("../database.php");  //se incluye el otro archivo
	$alumnos = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

	if(isset($_POST) && !empty($_POST)){ //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
    $numConAlum = $alumnos->sanitize($_POST['numConAlum']);  //se va a limpiar y recibir lo del formulario
    $nombreC = $alumnos->sanitize($_POST['nombreC']);
    $correo = $alumnos->sanitize($_POST['correo']);
    $telefono = $alumnos->sanitize($_POST['telefono']);
    $numSerieEquipo= $alumnos->sanitize($_POST['numSerieEquipo']);
    $nombreGrupo= $alumnos->sanitize($_POST['nombreGrupo']);
    $contrasena= $alumnos->sanitize($_POST['contrasena']);
$id_usuarioAl=intval($_POST['id_usuarioAl']); //Se agrega la variable para recibir el id

$res = $alumnos->updateusuarioAl( $nombreC,$correo,$telefono,$contrasena,$numConAlum,$nombreGrupo,$numSerieEquipo,$id_usuarioAl); //se cambia la función y se agrega la variable creada arriba

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

      //llamamos a la función
      $datos_usuarioAl= $alumnos->single_recordusuarioAl($idUsuario);
 ?>


<div class="container-fluid">
	<form method="post">
	<div class="row"> 

<center>
    <div class="col-sm-4">
      <label> Número de control:</label>
      <input type="number" name="id_usuarioAl" id="id_usuarioAl" class="form-control" hidden value="<?php echo $datos_usuarioAl->idUsuario;?>"> <!-- Escondemos el id-->
      <input type="number"  name="numConAlum" id="numConAlum"  class="form-control"  value="<?php echo $datos_usuarioAl->numConAlum;?>"> 
      </div>

      <div class="col-sm-4">
      <label> Nombre completo:</label>
      <input type="text" name="nombreC" id="nombreC"class="form-control" value="<?php echo $datos_usuarioAl->nombreC;?>">
      </div>

      <div class="col-sm-4">
      <label> Dirección de correo electrónico:</label>
      <input type="email"name="correo" id="correo" class="form-control"value="<?php echo $datos_usuarioAl->correo;?>">
      </div>

      <div class="col-sm-4">
      <label> Teléfono:</label>
      <input type="number" name="telefono" id="telefono" class="form-control"value="<?php echo $datos_usuarioAl->telefono;?>">
      </div>

      <div class="col-sm-4">
      <label> Equipo asignado:</label>
      <input type="number" name="numSerieEquipo" id="numSerieEquipo" class="form-control"value="<?php echo $datos_usuarioAl->numSerieEquipo;?>">
      </div>

      <div class="col-sm-4">
      <label> Grupo:</label>
      <input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control"value="<?php echo $datos_usuarioAl->nombreGrupo;?>">
      </div>

      <div class="col-sm-4">
      <label> Contraseña:</label>
      <input type="text" name="contrasena" id="contrasena" class="form-control"value="<?php echo $datos_usuarioAl->contrasena;?>">
      </div>
    </center>
      </div>

<br>



<!-- Botón para enviar datos-->
            <br />
            <center>

                <button type="submit" class="btn btn-warning">
                Actualizar datos
                </button>
            </center>
<!-- Botón -->

</center>

</form>
</div>


<?php include("../public/footer.php"); ?>