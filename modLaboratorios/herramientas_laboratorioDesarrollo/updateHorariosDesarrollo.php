<?php
if(isset($_GET['idHorarios'])){ 
    include ("../../database.php");
    $horarios= new Database();
    $idHorarios=intval($_GET['idHorarios']);
    $res= $horarios->updateHorarios($idHorarios);
    if($res){
        header("location: ../../modLaboratorios/laboratorios_horariosDesarrollo.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>