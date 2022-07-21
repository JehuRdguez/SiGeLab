<?php
if(isset($_GET['idGrupo'])){ 
include ("../database.php");
$grupos= new Database();
$idGrupo=intval($_GET['idGrupo']);
$res=$grupos->updategrupo($idGrupo);
if($res){
    header("location: ../modUsuarios/grupos.php");
}
else{
    echo "Error al actualizar registro";
}

}
?>
   