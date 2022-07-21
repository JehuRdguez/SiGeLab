<?php
if (isset($_GET['idLaboratorio'])) {
    $idLaboratorio = intval($_GET['idLaboratorio']);
} else {
    header("location: ../modLaboratorios/laboratorios_laboratorios.php");
}
?>

<?php
include("../database.php");
$laboratoriosR = new Database(); //Instanciar el objeto

if (isset($_POST) && !empty($_POST)) {
    $nombreLaboratorio = $laboratoriosR->sanitize($_POST['labNom']);
    $idUsuario = $laboratoriosR->sanitize($_POST['idUsuario']);
    $capacidad = $laboratoriosR->sanitize($_POST['labCap']);

    $idLaboratorio = intval($_POST['idLaboratorio']);

    $res = $laboratoriosR->editarLaboratorio($nombreLaboratorio, $idUsuario, $capacidad, $idLaboratorio);

    if ($res) {
        $message = "Datos actualizados con éxito";
        $class = "alert alert-success";
    } else {
        $message = "No se pudieron actualizar los datos..";
        $class = "alert alert-danger";
    }
?>
    <div class="<?php echo $class ?>">
        <?php echo $message; ?>
    </div>
<?php
}
$datos_laboratorio = $laboratoriosR->single_recordLaboratorio($idLaboratorio);
?>