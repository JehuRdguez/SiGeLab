<?php //  ISSET PARA VERIFICAR SI EL CAMPO ESTA DEFINIDO
if(isset($_GET['idIncidencia'])) {
    include("../database.php");
    $incidencia = new database();
    $idIncidencia=intval($_GET['idIncidencia']);  //DE TIPO INT INVALL
    $res=$incidencia->deleteI($idIncidencia);

    if ($res){
        header("location: ../modIncidencias/incidencias.php");
    }
    else{
        echo "Error al eliminar registro";
    }

} 