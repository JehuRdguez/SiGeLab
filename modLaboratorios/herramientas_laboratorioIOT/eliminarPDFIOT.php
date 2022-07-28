<?php //  ISSET PARA VERIFICAR SI EL CAMPO ESTA DEFINIDO
if(isset($_GET['idHorariospdf'])) {
    include("../../database.php");
    $horariopdf = new database();
    $idHorariospdf=intval($_GET['idHorariospdf']);  //DE TIPO INT INVALL
    $res=$horariopdf->deletePDF($idHorariospdf);

    if ($res){
        header("location: ../../modLaboratorios/laboratoriosIOT.php");
    }
    else{
        echo "Error al eliminar registro";
    }

} 