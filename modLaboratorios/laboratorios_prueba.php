<?php
$pagNom = 'LABORATORIOS';
?>


<?php
include "conn.php";
include "../database.php";
?>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'sigelab');
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>

    <div class="dropdown">
        <button class="btn btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" onclick="cambiarNombre()">
            Laboratorios</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" value="1" href="#">Laboratorio de IoT</a></li>
            <li><a class="dropdown-item" value="2" href="#">Laboratorio de desarrollo</a></li>
            <li><a class="dropdown-item" value="3" href="#">Laboratorio de soporte</a></li>
        </ul>
        <a class="btn btn-outline-dark" href="../modLaboratorios/laboratorios_laboratoriosprueba.php"><i class="fa-solid fa-list"></i></a>
    </div>

    <br>
    <!--PRUEBA-->

    <?php
    $labs = new Database(); //Instanciar el objeto

    if (isset($_POST) && !empty($_POST)) {
        $nombreLaboratorio = $labs->sanitize($_POST['nombreLaboratorio']);
    ?>
        <div class="<?php echo $class ?>">
            <?php echo $message; ?>
        </div>
    <?php
    }
    ?>

    <select aria-label="Default select example" id="list" class="btn btn-outline-dark" onchange="getSelectedValue();">
        <?php
        $listaEquiposEdit = $labs->readLabAct('nombreLaboratorio');
        while ($row = mysqli_fetch_object($listaEquiposEdit)) {
            $idLaboratorio = $row->idLaboratorio;
            $nombreLaboratorio = $row->nombreLaboratorio; ?>
            <option value="<?php echo $idLaboratorio; ?>"><?php echo $nombreLaboratorio; ?></option>
        <?php } ?>
    </select>

    <script>
        function getSelectedValue() {
            var selectedValue = document.getElementById("list").value;
            document.getElementById("horarios").href="laboratorios.php?id="+ selectedValue;
            alert( document.getElementById("horarios").href);
        }
    </script>
    <!--PRUEBA-->

    <br>
    </br>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="labHor" id="labHor" autocomplete="off" checked>
        <a class="btn btn-outline-dark" href="" for="labHor" id="horarios">Horarios</a>

        <input type="radio" class="btn-check" name="labEqu" id="labEqu" autocomplete="off">
        <a class="btn btn-outline-dark" href="laboratorios_equipos.php" for="labEqu">Equipos</a>

        <input type="radio" class="btn-check" name="labMob" id="labMob" autocomplete="off">
        <a class="btn btn-outline-dark" href="laboratorios_mobiliario.php" for="labMob">Mobiliario</a>

        <input type="radio" class="btn-check" name="labPer" id="LabPer" autocomplete="off">
        <a class="btn btn-outline-dark" href="laboratorios_perifericos.php" for="labPer">Periféricos</a>
    </div>

    <br>
    <br />
    <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#archivos">Subir horario</button>
    <a class="btn btn-outline-dark" href="laboratorios_horarios.php"><i class="fa-solid fa-list"></i></a>
    <br>

    <div class="container">
        <br>
        <table class="table table-bordered " cellspacing="0" width="100%" id="tabla1" style="background-color: #04aa89;">
            <thead>
                <tr>
                    <th>Laboratorio</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cuerpo de la tabla, se llena con la BDD-->
                <?php
                $horariospdf = new Database(); //
                $listaHorariospdf = $horariospdf->PDFRead(); //se crea la variable listaAdministradores
                ?>

                <?php
                while ($row = mysqli_fetch_object($listaHorariospdf)) { //antes del = es la variable del form, después es la de BDD

                    $idHorariospdf = $row->idHorariospdf;
                    $nombrepdf = $row->nombrepdf;
                    $url = $row->url;
                ?>
                    <tr>
                        <td><?php echo $nombrepdf; ?></td>
                        <td><iframe src="<?php echo $url ?>" height="400px" width="800px"></iframe></td>
                        <td><a onclick="openModelPDF('<?php echo $url ?>')" type="button" class="btn btn-outline-dark" title="Ver PDF"><i class="fa-regular fa-file"></i></a>
                            <abbr title="Borrar"><a class="btn btn-outline-dark" onclick="return eliminar()" href="eliminarPDF.php?idHorariospdf=<?php echo $idHorariospdf ?>"><i class="fa-solid fa-trash-can"></i></a></abbr>
                        </td>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php } else if ($idTipoUsuario == 2 || $idTipoUsuario == 3) { ?>


    <div class="container">
        <br>
        <table class="table table-bordered" id="tabla1" style="background-color: #04aa89;">
            <thead>
                <tr>
                    <th>Laboratorio</th>
                    <th>Horario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cuerpo de la tabla, se llena con la BDD-->
                <?php
                $horariospdf = new Database(); //
                $listaHorariospdf = $horariospdf->PDFRead(); //se crea la variable listaAdministradores
                ?>

                <?php
                while ($row = mysqli_fetch_object($listaHorariospdf)) { //antes del = es la variable del form, después es la de BDD

                    $idHorariospdf = $row->idHorariospdf;
                    $nombrepdf = $row->nombrepdf;
                    $url = $row->url;
                ?>
                    <tr>
                        <td><?php echo $nombrepdf; ?></td>
                        <td><iframe src="<?php echo $url ?>" height="400px" width="800px"></iframe></td>
                        <td><a onclick="openModelPDF('<?php echo $url ?>')" type="button" class="btn btn-outline-dark" title="Ver PDF"><i class="fa-solid fa-magnifying-glass-plus"></i></a>
                        </td>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

<?php } else { ?>
    <?php header("Location: ../index.php"); ?>
<?php } ?>



<!-- Modal pdf-->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" height="400px" width="600px">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post">
                        <div class="row">
                            <!--Campos-->
                            <center>
                                <div class="modal-body">
                                    <iframe id="iframePDF" frameborder="0" scrolling="no" width="100%" height="500px"></iframe>
                                </div>
                            </center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal pdf-->
<div class="modal fade" id="archivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" height="400px" width="600px">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post" id="form1">
                        <div class="row">
                            <!--Campos-->
                            <center>

                                <div class="col-sm-20">
                                    <label for="">Laboratorio</label>
                                    <select class="form-select" aria-label="Default select example" id="nombrepdf" name="nombrepdf" required>
                                        <option selected disabled>Selecciona un laboratorio:</option>
                                        <?php
                                        $listalabs = $horariospdf->readLabAct('nombreLaboratorio');
                                        while ($row = mysqli_fetch_object($listalabs)) {
                                            $idLaboratorio = $row->idLaboratorio;
                                            $nombreLaboratorio = $row->nombreLaboratorio; ?>
                                            <option value="<?php echo $nombreLaboratorio ?>"><?php echo $nombreLaboratorio ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-20">
                                    <label>Archivo PDF</label>
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                            </center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" onclick="onSubmitForm()">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../public/footer.php"); ?>