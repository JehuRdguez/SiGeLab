<?php 
//Asignar nivel de acceso
//Variables y atributos no se mandan a llamar igual
$sname = "localhost";
$uname = "root";
$password = "";
$bd_name = "sigelab";

$conn = mysqli_connect($sname, $uname, $password, $bd_name);
if(!$conn){
    echo "Error!";
    exit();
}

//cuida que tu archivo no tenga caracteres especiales ni espacios en blanco, usar una convocatoria en especial
//Al dar de alta/implementar, generar una carpeta para cada documento 
function file_name($string){
    $string = strtolower($string);//transforma una cadena de caracteres en minuscula
    $find = array('á','é','í','ó','ú','ñ');
    $repl = array('a','e','i','o','u','n');
    $find = array(' ','&', '\r\n','\n','+');
    $string = str_replace($find, '-', $string);
    return $string;

    $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
    $repl = array('', '-', '');
    $string = preg_replace($find, $repl, $string);
    return $string;
}
