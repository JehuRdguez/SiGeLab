<?php
if(isset($_GET['idMobiliario'])){ 
    include ("../database.php");
    $mobiliario= new Database();
    $idMobiliario=intval($_GET['idMobiliario']);
    $res= $mobiliario->updateMobiliario($idMobiliario);
    if($res){
        header("location: ../modLaboratorios/laboratorios_mobiliario.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>