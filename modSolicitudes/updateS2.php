<?php
if(isset($_GET['idSolicitudAcceso'])){ 
    include ("../database.php");
    $solicitud= new Database();
    $idSolicitudAcceso=intval($_GET['idSolicitudAcceso']);
    $res = $solicitud->updateS2($idSolicitudAcceso);
    if($res){
        header("location: ../modSolicitudes/solicitudes.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>