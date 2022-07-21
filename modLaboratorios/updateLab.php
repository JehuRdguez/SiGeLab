<?php
if(isset($_GET['idLaboratorio'])){ 
    include ("../database.php");
    $laboratorio= new Database();
    $idLaboratorio=intval($_GET['idLaboratorio']);
    $res= $laboratorio->updateLaboratorio($idLaboratorio);
    if($res){
        header("location: ../modLaboratorios/laboratorios_laboratorios.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>