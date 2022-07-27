<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header('location: login.php');
}
else{
    header("Location: modLaboratorios/laboratoriosIOT.php"); 
}
?>

