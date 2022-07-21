<?php //obtener id
if (isset($_GET['idIncidencia'])) {
  $idIncidencia = intval($_GET['idIncidencia']);
} else {
  header("location: ../modIncidencias/incidencias.php");
}
?>
<?php
include("../database.php");
$reportes = new Database();
//se incluye el otro archivo
//generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos
if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  $nombreC = $reportes->sanitize($_POST['nombreC']);  //se va a limpiar y recibir lo del formulario
  $descripcionIncidencia = $reportes->sanitize($_POST['descripcionIncidencia']); //Se agrega la variable para recibir el id

  $idIncidencia = intval($_POST['idIncidencia']);

  $res = $reportes->editarIncidencia($nombreC, $descripcionIncidencia, $idIncidencia); //se cambia la función y se agrega la variable creada arriba

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
$datos_Incidencia = $reportes->single_recordIncidencia($idIncidencia);
?>