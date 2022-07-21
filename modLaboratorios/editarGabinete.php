<?php //obtener id
if (isset($_GET['idPerifericos'])) {
  $idPerifericos = intval($_GET['idPerifericos']);
} else {
  header("location: ../modLaboratorios/laboratorios_perifericosG.php");
}
?>

<?php
include("../database.php");  //se incluye el otro archivo
$perifericoG = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  $numInvEscolar = $perifericoG->sanitize($_POST['escolargabinete']);
  $numSerieGabinete = $perifericoG->sanitize($_POST['numSeriegabinete']);
  $marca = $perifericoG->sanitize($_POST['marcagabinete']);
  $modelo = $perifericoG->sanitize($_POST['modelogabinete']);

  $idPerifericos = intval($_POST['idPerifericos']);

  $res = $perifericoG->editarGabinete($numInvEscolar, $numSerieGabinete, $marca, $modelo, $idPerifericos);

  if ($res) {
    $message = "Datos actualizados con éxito";
    $class = "alert alert-success";
  } else {
    $message = "No se pudieron actualizar los datos..";
    $class = "alert alert-danger";
  }
?>
  <div class="<?php echo $class ?>">
    <?php echo $message; ?>
  </div>
<?php
}

//llamamos a la función
$datos_perifericosG = $perifericoG->single_recordperiferico($idPerifericos);
?>