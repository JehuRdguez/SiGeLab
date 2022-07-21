<?php
if(isset($_GET['idUsuario'])){ 
    include ("../database.php");
    $usuario= new Database();
    $idUsuario=intval($_GET['idUsuario']);
    $res= $usuario->updateusuarioAlumno($idUsuario);
    if($res){
        header("location: ../modUsuarios/usuarioAlumno.php");
    }
    else{
        echo "Error al actualizar registro";
    }
    
    }

    ?>