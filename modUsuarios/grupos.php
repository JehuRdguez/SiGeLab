<?php 
$pagNom = 'GRUPOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($idTipoUsuario == 1) { ?>



  <?php
  include("../database.php");  //se incluye el otro archivo 
  $gruposR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

  if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
    $nombreGrupo = $gruposR->sanitize($_POST['nombreGrupo']);  //se va a limpiar y recibir lo del formulario
    $cantidadAlumnos = $gruposR->sanitize($_POST['cantidadAlumnos']);
    $idUsuario = $gruposR->sanitize($_POST['idUsuario']);
    $res = $gruposR->createGrupo($nombreGrupo, $cantidadAlumnos, $idUsuario, 1);

    if ($res === true) {
      $message = "Datos insertados con éxito";
      $class = "alert alert-success";
    } else if($res == "duplicado") {
      $message = "Datos duplicados, no se pudo completar el registro...";
      $class = "alert alert-danger";
    } else {
      $message = "No se pudieron insertar los datos...";
      $class = "alert alert-danger";
    }
  ?>
    <div class="<?php echo $class ?>">
      <?php echo $message; ?>
    </div>
  <?php
  }
  ?>

  <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Grupos</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="../modUsuarios/usuarioAdministrador.php">Administradores</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/usuarioMaestro.php">Maestros</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/usuarioAlumno.php">Alumnos</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/grupos.php">Grupos</a></li>
    </ul>
    <!--Botón de registro -->
    <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#RegistroGrupo">Registrar</a><br>
    <br />


    <!-- Mostrar tabla-->
    <div class="container">
      <table  class="table table-bordered " cellspacing="0" width="100%"  id="gruposTable" style="background-color: #04aa89;  ">
        <thead>
          <!-- Secciones o cabeceros -->
          <tr>
            <!-- filas -->
            <th>Nombre grupo</th> <!-- ENcabezados de las tablas-->
            <th>Cantidad alumnos</th>
            <th>Tutor</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <!-- Cuerpo de la tabla, se llena con la BDD-->
          <?php
          $gruposR = new Database(); //
          $listaGrupos = $gruposR->readGrupo(); //se crea la variable listaAdministradores
          ?>
          <?php
          while ($row = mysqli_fetch_object($listaGrupos)) { //antes del = es la variable del form, después es la de BDD
            $idGrupo = $row->idGrupo;
            $nombreGrupo = $row->nombreGrupo;
            $cantidadAlumnos = $row->cantidadAlumnos;
            $nombreM = $row->nombreC;
            $estado = $row->estado;
          ?>
            <tr>
              <td><?php echo $nombreGrupo; ?></td> <!-- Muestra-->
              <td><?php echo $cantidadAlumnos; ?></td>
              <td><?php echo $nombreM; ?></td>
              <td><?php if ($estado == 1) {
                    echo 'Activo';
                  } else {
                    echo 'Inactivo';
                  } ?></td>
              <td>
                <?php
                if ($estado == 1) { ?>
                  <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateGrupo.php?idGrupo=<?php echo $idGrupo; ?>"><i class="fa fa-eye-slash"></i></a></abbr>
                <?php } else { ?>
                  <abbr title="Habilitar"> <a type="button" class="btn btn-outline-dark" href="updateGrupo.php?idGrupo=<?php echo $idGrupo; ?>"><i class="fa fa-eye"></i></a></abbr>
                <?php } ?>
                <abbr title="Ver detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesGrupo<?php echo $idGrupo; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
                <!--<a class="btn btn-outline-primary" href="EditarGrupo.php?idGrupo=<?php echo $idGrupo; ?>"><i class="fa-regular fa-pen-to-square"></i></a><br>
-->
              </td>
            </tr>
            <?php
            include("modGrupo.php");
            ?>



          <?php
          }
          ?>
        </tbody>
      </table>
    </div>

    <!--Modal-Hoja de registro de grupo-->

    <div class="modal fade" id="RegistroGrupo" tabindex="-1" aria-labelledby="RegistroGrupo" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Hoja de grupos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="container-fluid">
              <form method="post">
                <div class="row">
                  <center>
                    <label> Nombre del grupo:</label>
                    <input type="text" name="nombreGrupo" id="nombreGrupo" class="form-control" required>

                    <label> Cantidad de alumnos: </label>
                    <input type="number" name="cantidadAlumnos" id="cantidadAlumnos" class="form-control" min="1" max="60" onkeypress="return verificaNumeros(event);" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>

                    <label for="">Tutor</label>
                    <select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario" required>
                      <option value="">Selecciona un tutor:</option>
                      <?php
                      $listaTutores = $gruposR->readListaTutores('nombreC');
                      while ($row = mysqli_fetch_object($listaTutores)) {
                        $idUsuario = $row->idUsuario;
                        $nombreC = $row->nombreC; ?>
                        <option value="<?php echo $idUsuario; ?>"><?php echo $nombreC; ?></option>
                      <?php } ?>
                    </select>
                  </center>
                </div>
                <!-- Botón para enviar datos-->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-dark" onclick="return alertaRegistrar()">Registrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php include("../public/footer.php"); ?>
    <?php } else { ?>
    <?php header("Location: ../index.php"); ?>
  <?php } ?>