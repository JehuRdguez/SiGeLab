<?php //obtener id
if (isset($_GET['idPerifericos'])) {
  $idPerifericos = intval($_GET['idPerifericos']);
} else {
  header("location: ../modLaboratorios/laboratorios_perifericosM.php");
}
?>

<?php
include("../database.php");  //se incluye el otro archivo
$perifericoMo = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
  $numInvEscolar = $perifericoMo->sanitize($_POST['escolarmouse']);
  $numSerieMouse = $perifericoMo->sanitize($_POST['numSeriemouse']);
  $marca = $perifericoMo->sanitize($_POST['marcamouse']);
  $modelo = $perifericoMo->sanitize($_POST['modelomouse']);

  $idPerifericos = intval($_POST['idPerifericos']);

  $res = $perifericoMo->editarMouse($numInvEscolar, $numSerieMouse, $marca, $modelo, $idPerifericos);

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
$datos_perifericosMo = $perifericoMo->single_recordperiferico($idPerifericos);
?>