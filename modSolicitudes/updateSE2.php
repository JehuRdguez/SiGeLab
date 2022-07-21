<?php
if(isset($_GET['idsolicitudCambioE'])){ 
    include ("../database.php");
    $solicitudAL= new Database();
    $idsolicitudCambioE=intval($_GET['idsolicitudCambioE']);
    $res = $solicitudAL->updateSE2($idsolicitudCambioE);
    if($res){
        header("location: ../modSolicitudes/solicitudEquipo.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>