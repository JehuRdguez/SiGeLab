<?php //obtener id
if (isset($_GET['idHorarios'])) {
  $idHorarios = intval($_GET['idHorarios']);
} else {
  header("location: ../../modLaboratorios/laboratorios_horariosDesarrollo.php");
}
?>
<?php
include("../../database.php");  //se incluye el otro archivo
$horariosR = new Database(); //Instanciar el objeto

if (isset($_POST) && !empty($_POST)) {
  $idUsuario = $horariosR->sanitize($_POST['nomMae']);
  $materia = $horariosR->sanitize($_POST['materia']);
  $idGrupo = $horariosR->sanitize($_POST['grupo']);
  $dia = $horariosR->sanitize($_POST['dia']);
  $horaEntrada = $horariosR->sanitize($_POST['horaE']);
  $horaSalida = $horariosR->sanitize($_POST['horaS']);
  $idLaboratorio = $horariosR->sanitize($_POST['lab']);
  $horasPorCuatri = $horariosR->sanitize($_POST['horasCuatri']);

  $idHorarios = intval($_POST['idHorarios']);

  $res = $horariosR->editarHorarios($idUsuario, $materia, $idGrupo, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, $idHorarios);

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
$datos_horarios = $horariosR->single_recordHorarios($idHorarios);
?>