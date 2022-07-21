<?php include("../public/header.php"); ?>

<marquee class="alert alert-p-3 mb-2 bg-light text-dark">
  <h2> Editar información</h2>
</marquee>

<a type="button" href="../modLaboratorios/laboratorios.php" class="btn btn-dark">Regresar</a>
<?php //obtener id
if (isset($_GET['idHorarios'])) {
  $idHorarios = intval($_GET['idHorarios']);
} else {
  header("location: ../modLaboratorios/laboratorios.php");
}
?>
<?php
include("../database.php");  //se incluye el otro archivo
$horariosR = new Database(); //Instanciar el objeto

if (isset($_POST) && !empty($_POST)) {
  $idUsuario = $horariosR->sanitize($_POST['nomMae']);
  $materia = $horariosR->sanitize($_POST['materia']);
  $idGrupo = $horariosR->sanitize($_POST['grupo']);
  $cantidad = $horariosR->sanitize($_POST['canAl']);
  $dia = $horariosR->sanitize($_POST['dia']);
  $horaEntrada = $horariosR->sanitize($_POST['horaE']);
  $horaSalida = $horariosR->sanitize($_POST['horaS']);
  $idLaboratorio = $horariosR->sanitize($_POST['lab']);
  $horasPorCuatri = $horariosR->sanitize($_POST['horasCuatri']);

  $id_horarios = intval($_POST['id_horarios']);

  $res = $horariosR->updateHorarios($idUsuario, $materia, $idGrupo, $cantidad, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, 1, $id_horarios);

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

<center>

  <div class="container-fluid">
    <form method="post">
      <div class="row">
        <div class="col-sm-6">
          <label for="">Laboratorio</label>
          <input type="number" name="id_horarios" id="id_horarios" class="form-control" hidden value="<?php echo $datos_horarios->idHorarios; ?>"> <!-- Escondemos el id-->
          <select class="form-select" aria-label="Default select example" id="nomMae" name="nomMae">
            <option selected hidden value="<?php echo $datos_horarios->idUsuario; ?>">Selecciona una tutor:</option>
            <?php
            $listaHorarios = $horariosR->readListaTutores('nombreC');
            while ($row = mysqli_fetch_object($listaHorarios)) {
              $idUsuario = $row->idUsuario;
              $nombreC = $row->nombreC; ?>
              <option value="<?php echo $idUsuario ?>"><?php echo $nombreC ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-6">
          <label>Materia</label>
          <input type="text" name="materia" id="materia" class="form-control" value="<?php echo $datos_horarios->materia; ?>">
        </div>
        <div class="col-sm-6">
          <label for="">Grupo</label>
          <select class="form-select" aria-label="Default select example" id="grupo" name="grupo">
            <option selected hidden value="<?php echo $datos_horarios->idGrupo; ?>">Seleccionar un grupo:</option>
            <?php
            $listaHorarios = $horariosR->readGrupos('nombreGrupo');
            while ($row = mysqli_fetch_object($listaHorarios)) {
              $idGrupo = $row->idGrupo;
              $nombreGrupo = $row->nombreGrupo; ?>
              <option value="<?php echo $idGrupo ?>"><?php echo $nombreGrupo ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-6">
          <label>Cantidad de alumnos</label>
          <input type="number" name="canAl" id="canAl" class="form-control" value="<?php echo $datos_horarios->cantidad; ?>">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">

          <label>Día</label>
          <input type="text" name="dia" id="dia" class="form-control" value="<?php echo $datos_horarios->dia; ?>">

        </div>
        <div class="col-sm-6">

          <label>Hora entrada</label>
          <input type="time" name="horaE" id="horaE" class="form-control" value="<?php echo $datos_horarios->horaEntrada; ?>">

        </div>
        <div class="col-sm-6">

          <label>Hora salida</label>
          <input type="time" name="horaS" id="horaS" class="form-control" value="<?php echo $datos_horarios->horaSalida; ?>">

        </div>
        <div class="col-sm-6">

          <label for="">Laboratorio</label>
          <select class="form-select" aria-label="Default select example" id="lab" name="lab">
            <option selected hidden value="<?php echo $datos_horarios->idLaboratorio; ?>">Selecciona un laboratorio:</option>
            <?php
            $listaHorarios = $horariosR->readLabAct('idLaboratorio');
            while ($row = mysqli_fetch_object($listaHorarios)) {
              $idLaboratorio = $row->idLaboratorio;
              $nombreLaboratorio = $row->nombreLaboratorio; ?>
              <option value="<?php echo $idLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <label>Horas por cuatrimestre</label>
          <input type="number" name="horasCuatri" id="horasCuatri" class="form-control" value="<?php echo $datos_horarios->horasPorCuatri; ?>">
        </div>
      </div>

  </div>
</center>
<br>

<!-- Botón para enviar datos-->
<br />
<center>
  <button type="submit" class="btn btn-dark" onclick="return alertaEditar()">
    Actualizar datos
  </button>
</center>
<!-- Botón -->

</center>

</form>
</div>


<?php include("../public/footer.php"); ?>