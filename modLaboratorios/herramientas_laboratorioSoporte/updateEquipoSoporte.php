
<?php
if(isset($_GET['idEquipo'])){ 
include ("../../database.php");
$equipo= new Database();
$idEquipo=intval($_GET['idEquipo']);
$res= $equipo->updateEstadoEquipo($idEquipo);
if($res){
    header("location: ../../modLaboratorios/laboratorios_equiposSoporte.php");
}
else{
    echo "Error al actualizar registro";
}

}

?>