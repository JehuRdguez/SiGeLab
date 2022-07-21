<?php //  ISSET PARA VERIFICAR SI EL CAMPO ESTA DEFINIDO
if(isset($_GET['idsolicitudCambioE'])) {
    include("../database.php");
    $solicitudAL = new database();
    $idsolicitudCambioE=intval($_GET['idsolicitudCambioE']);  //DE TIPO INT INVALL
    $res=$solicitudAL->deleteSE($idsolicitudCambioE);

    if ($res){
        header("location: ../modSolicitudes/solicitudEquipo.php");
    }
    else{
        echo "Error al eliminar registro";
    }

} 