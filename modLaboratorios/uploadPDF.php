<?php

include('conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombrepdf = $conn->real_escape_string(htmlentities($_POST['nombrepdf']));
    
    $file_name = $_FILES['file']['name'];

    $new_name_file = null;

    if ($file_name != '' || $file_name != null) {
        $file_type = $_FILES['file']['type'];
        list($type, $extension) = explode('/', $file_type);
        if ($extension == 'pdf') {
            $dir = 'PDFs/';
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file_tmp_name = $_FILES['file']['tmp_name'];
            //$new_name_file = 'files/' . date('Ymdhis') . '.' . $extension;
            $new_name_file = $dir . file_name($file_name) . '.' . $extension;
            if (copy($file_tmp_name, $new_name_file)) {

            }
        }
    }
    try {
        $ins = $conn->query("INSERT INTO horariospdf(nombrepdf,url) VALUES ('$nombrepdf','$new_name_file')");
    } catch (\Throwable) {
        return 'duplicado';
    }

    if ($ins) {
        echo 'Registrado Correctamente';
    } else {
        echo 'Fallo al Registrarse';
    }
} else {
    echo 'fail';
}
?>