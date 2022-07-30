<?php
$pagNom = 'GRUPOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>
  <!--Condiciones para tipo usuario -->
  <?php
  $sname = "localhost";
  $uname = "root";
  $password = "";
  $bd_name = "sigelab";

  $conn = mysqli_connect($sname, $uname, $password, $bd_name);
  if (!$conn) {
    echo "Error!";
    exit();
  }


  ?>
  <?php
  include("../database.php");  //se incluye el otro archivo con la conexión a la bdd
  $gruposR = new Database();  //generamos la variable cliente pq eso es lo que vamos a generar, con esto instanciamos

  if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
    $nombreGrupo = $gruposR->sanitize($_POST['nombreGrupo']);  //se va a limpiar y recibir lo del formulario
    $idUsuario = $gruposR->sanitize($_POST['idUsuario']);

    $validar = "SELECT* FROM vwValidaTutor where  idUsuario='$idUsuario'";
    $validando = $conn->query($validar);

    if ($validando->num_rows > 0) {
      $message = "El tutor ya está asignado a un grupo";
      $class = "alert alert-danger";
    } else {

      $res = $gruposR->createGrupo($nombreGrupo, $idUsuario, 1); //Función para crear un nuevo grupo
      if ($res === true) {
        $message = "Datos insertados con éxito";
        $class = "alert alert-success";
      } else if ($res == "duplicado") {
        $message = "Datos duplicados, no se pudo completar el registro...";
        $class = "alert alert-danger";
      } else {
        $message = "No se pudieron insertar los datos...";
        $class = "alert alert-danger";
      }
    }
  ?>
    <div class="<?php echo $class ?>">
      <?php echo $message; ?>
    </div>
  <?php
  }
  ?>

  <!--opciones desplegable -->
  <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Grupos</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="usuarioAdministrador.php">Administradores</a></li>
      <li><a class="dropdown-item" href="usuarioMaestro.php">Maestros</a></li>
      <li><a class="dropdown-item" href="usuarioAlumno.php">Alumnos</a></li>
      <li><a class="dropdown-item" href="grupos.php">Grupos</a></li>
    </ul>

    <!--Botón de registro -->
    <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#RegistroGrupo">Registrar</a><br>
    <br />

    <!-- Mostrar tabla-->
    <div class="container">
      <table class="table table-bordered " cellspacing="0" width="100%" id="gruposTable" style="background-color: #04aa89;  ">
        <thead>
          <tr>
            <!-- Secciones o cabeceros -->
            <th>Nombre grupo</th> <!-- filas -->
            <!-- ENcabezados de las tablas-->
            <th>Cantidad alumnos</th>
            <th>Tutor</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <!-- Cuerpo de la tabla, se llena con la BDD-->
          <?php
          $listaGrupos = $gruposR->readGrupo(); //se crea la variable listaAdministradores
          ?>

          <?php
          while ($row = mysqli_fetch_object($listaGrupos)) {
            $idGrupo = $row->idGrupo;
            $nombreGrupo = $row->nombreGrupo;
            $nombreM = $row->nombreC;
            $uActivo = $row->uActivo;
            $estado = $row->estado;
          ?>

            <tr>
              <td><?php echo $nombreGrupo; ?></td> <!-- Muestra los datos-->
              <td>
                <?php
                $contar = ($conn->query("SELECT COUNT(*)  FROM cantidadAlumnos where idGrupo='$idGrupo'")); //Contar la cantidad de alumnos registrados con ese grupo
                echo $contar->fetch_column();

                ?>
              </td>
             
              <td><?php if ($uActivo == 1) { //Condicionamos el tutor, si está incactivo se pondrá "pendiente", en caso contrario se muestra el nombre
                    echo $nombreM;
                  } else {
                    echo 'Pendiente';
                  } ?></td>

              <td><?php if ($estado == 1) { //Condicionamos el estado del grupo, 0=inactivo 1=activo
                    echo 'Activo';
                  } else {
                    echo 'Inactivo';
                  } ?></td>
              <td>
                <!--Botones de "Acciones"-->
                <?php
                if ($estado == 1) { ?>
                  <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateGrupo.php?idGrupo=<?php echo $idGrupo; ?>"><i class="fa fa-eye-slash"></i></a></abbr>
                <?php } else { ?>
                  <abbr title="Habilitar"> <a type="button" class="btn btn-outline-dark" href="updateGrupo.php?idGrupo=<?php echo $idGrupo; ?>"><i class="fa fa-eye"></i></a></abbr>
                <?php } ?>

                <abbr title="Cambiar tutor"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarTutor<?php echo $idGrupo; ?>"><i class="fa-solid fa-chalkboard-user"></i></button></abbr>
                <abbr title="Ver detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesGrupo<?php echo $idGrupo; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>


              </td>
            </tr>



            <!--ventana para mostrar alumnos que pertenecen a ese grupo (modal de detalles)--->
            <div class="modal fade" id="detallesGrupo<?php echo $idGrupo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form method="POST">
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">

                    <div class="modal-body" id="cont_modal">
                      <h5>Alumnos del grupo: <?php echo $nombreGrupo; ?> </h5>
                      <!--Imprimimos el nombre del grupo-->
                      <?php
                      $gruposALumnos = new Database();
                      $listaAlumnos = $gruposALumnos->listaAl(); //se crea la variable listaAdministradores
                      while ($row = mysqli_fetch_object($listaAlumnos)) {
                        $nombreC = $row->nombreC;
                        $grupo = $row->idGrupo;
                        if ($idGrupo == $grupo) { ?>
                          <!-- Condicionamos para que sólo muestre los alumnos de ese grupo-->
                          <label><strong><?php echo $nombreC; ?></strong></label></br>
                      <?php }
                      } ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!---fin ventana detalles--->


            <!--ventana para cambiar el tutor de un grupo--->
            <div class="modal fade" id="editarTutor<?php echo $idGrupo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar tutor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <form method="POST" action="EditarGrupo.php">
                    <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">

                    <div class="modal-body">

                      <div class="form-group">
                        <label for="" class="col-form-label">Tutor:</label>
                        <select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario">
                          <?php
                          $datos_grupo = $gruposR->single_recordgrupo($idGrupo);
                          ?>
                          <option selected hidden value="<?php echo $datos_grupo->idUsuario; ?>"><?php echo $nombreM; ?></option>
                          <?php
                          $listaTutores = $gruposR->readListaTutores('nombreC');
                          while ($row = mysqli_fetch_object($listaTutores)) {
                            $idUsuario = $row->idUsuario;
                            $nombreC = $row->nombreC; ?>
                            <option value="<?php echo $idUsuario ?>"><?php echo $nombreC ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary" onclick="return alertaEditar()">Actualizar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

                    <label for="">Tutor:</label>
                    <select class="form-select" aria-label="Default select example" id="idUsuario" name="idUsuario" required>
                      <option value="" selected disabled>Selecciona un tutor:</option>
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
    <!--Se incluye el footer-->

  <?php } else if ($_SESSION['idTipoUsuario'] != 1) { ?>
    <!--Condiciones de acceso-->
    <?php header("Location: ../index.php"); ?>
  <?php } ?>