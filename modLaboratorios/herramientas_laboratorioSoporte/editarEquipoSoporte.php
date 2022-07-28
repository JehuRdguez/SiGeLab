<?php //obtener id
if (isset($_GET['idEquipo'])) {
  $idEquipo = intval($_GET['idEquipo']);
} else {
  header("location: ../../modLaboratorios/laboratorios_equiposSoporte.php");
}
?>

<?php
include("../../database.php");  //se incluye el otro archivo
$equiposR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) {
  $nombreLaboratorio = $equiposR->sanitize($_POST['lab']);
  $numInvEscolar = $equiposR->sanitize($_POST['numInvEscolar']);
  $numSerieEquipo = $equiposR->sanitize($_POST['numSerieEquipo']);
  $numMonitor = $equiposR->sanitize($_POST['numMon']);
  $numTeclado = $equiposR->sanitize($_POST['numTec']);
  $numMouse = $equiposR->sanitize($_POST['numMou']);
  $ubicacionEnMesa = $equiposR->sanitize($_POST['ubiMesa']);
  $procesador = $equiposR->sanitize($_POST['procesador']);
  $discoDuro = $equiposR->sanitize($_POST['discoDuro']);
  $ram = $equiposR->sanitize($_POST['ram']);

  $idEquipo = intval($_POST['idEquipo']);

  $res = $equiposR->updateEquipo($nombreLaboratorio, $numInvEscolar, $numSerieEquipo, $numMonitor, $numTeclado, $numMouse, $ubicacionEnMesa, $procesador, $discoDuro, $ram, $idEquipo);

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
$datos_equipos = $equiposR->single_recordequipo($idEquipo);
?>