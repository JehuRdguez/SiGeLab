
<?php
if(isset($_GET['idUsuario'])){ 
include ("../database.php");
$usuario= new Database();
$idUsuario=intval($_GET['idUsuario']);
$res= $usuario->updateusuarioAdministrador($idUsuario);
if($res){
    header("location: ../modUsuarios/usuarioAdministrador.php");
}
else{
    echo "Error al actualizar registro";
}

}

?>







