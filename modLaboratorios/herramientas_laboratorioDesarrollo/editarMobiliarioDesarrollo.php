<?php
if (isset($_GET['idMobiliario'])) {
    $idMobiliario = intval($_GET['idMobiliario']);
} else {
    header("location: ../../modLaboratorios/laboratorios_mobiliarioDesarrollo.php");
}
?>

<?php
include("../../database.php");
$mobiliarioR = new Database(); //Instanciar el objeto

if (isset($_POST) && !empty($_POST)) {
    $numInvMobiliario = $mobiliarioR->sanitize($_POST['numInvMobiliario']);
    $seccionesDeMesa = $mobiliarioR->sanitize($_POST['seccionesDeMesa']);
    $descripcion = $mobiliarioR->sanitize($_POST['descripcion']);
    $idLaboratorio = $mobiliarioR->sanitize($_POST['idLaboratorio']);

    $idMobiliario = intval($_POST['idMobiliario']);

    $res = $mobiliarioR->editarMobiliario($numInvMobiliario, $seccionesDeMesa, $descripcion, $idLaboratorio, $idMobiliario);

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
$datos_Mobiliario = $mobiliarioR->single_recordMobiliario($idMobiliario);
?>