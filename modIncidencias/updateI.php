<?php
if(isset($_GET['idIncidencia'])){ 
    include ("../database.php");
    $incidencia= new Database();
    $idIncidencia=intval($_GET['idIncidencia']);
    $res = $incidencia->updateI($idIncidencia);
    if($res){
        header("location: ../modIncidencias/incidencias.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>