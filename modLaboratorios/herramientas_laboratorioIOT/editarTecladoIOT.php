<?php //obtener id
if (isset($_GET['idPerifericos'])){
    $idPerifericos=intval($_GET['idPerifericos']);
} else{
   header("location: ../../modLaboratorios/laboratorios_perifericosTecladoIOT.php"); 
}
?>

<?php
	include("../../database.php");  //se incluye el otro archivo
    $perifericoT = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

    if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
        $numInvEscolar = $perifericoT->sanitize($_POST['escolarteclado']);
        $numSerie = $perifericoT->sanitize($_POST['numSerieteclado']);
        $marca = $perifericoT->sanitize($_POST['marcateclado']);
        $modelo = $perifericoT->sanitize($_POST['modeloteclado']);      

        $idPerifericos = intval($_POST['idPerifericos']);

        $res = $perifericoT->editarPerifericos($numInvEscolar, $numSerie, $marca, $modelo, $idPerifericos);
      
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
      $datos_perifericosT= $perifericoT->single_recordperiferico($idPerifericos);
 ?>