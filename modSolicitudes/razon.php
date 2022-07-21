<?php //obtener id
if (isset($_GET['idSolicitudAcceso'])) {
  $idSolicitudAcceso = intval($_GET['idSolicitudAcceso']);
} else {
  header("location: ../modSolicitudes/solicitudes.php");
}
?>
<?php
include("../database.php");
$solicitud = new Database();
//se incluye el otro archivo
//generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos
if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  $razon = $solicitud->sanitize($_POST['razon']);  //se va a limpiar y recibir lo del formulario
  //Se agrega la variable para recibir el id

  $idSolicitudAcceso = intval($_POST['idSolicitudAcceso']);

  $res = $solicitud->editarRazon($razon,$idSolicitudAcceso); //se cambia la función y se agrega la variable creada arriba

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
$datos_Solicitud = $solicitud->single_recordSolicitud($idSolicitudAcceso);
?>