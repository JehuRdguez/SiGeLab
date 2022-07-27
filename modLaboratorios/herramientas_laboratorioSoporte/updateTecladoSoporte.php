
<?php
if(isset($_GET['idPerifericos'])){ 
include ("../../database.php");
$periferico= new Database();
$idPerifericos=intval($_GET['idPerifericos']);
$res= $periferico->updateEstadoPeriferico($idPerifericos);
if($res){
    header("location: ../../modLaboratorios/laboratorios_perifericosTecladoSoporte.php");
}
else{
    echo "Error al actualizar registro";
}

}

?>