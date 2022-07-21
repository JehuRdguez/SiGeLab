<?php //  ISSET PARA VERIFICAR SI EL CAMPO ESTA DEFINIDO
if(isset($_GET['idSolicitudAcceso'])) {
    include("../database.php");
    $solicitud = new database();
    $idSolicitudAcceso=intval($_GET['idSolicitudAcceso']);  //DE TIPO INT INVALL
    $res=$solicitud->deleteS($idSolicitudAcceso);

    if ($res){
        header("location: ../modSolicitudes/solicitudes.php");
    }
    else{
        echo "Error al eliminar registro";
    }

} 
