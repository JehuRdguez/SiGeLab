<?php
if(isset($_GET['idUsuario'])){ 
include ("../database.php");
$usuario= new Database();
$idUsuario=intval($_GET['idUsuario']);
$res= $usuario-> updateusuarioMaestro($idUsuario);
if($res){
    header("location: ../modUsuarios/usuarioMaestro.php");
}
else{
    echo "Error al actualizar registro";
}

}
?>
