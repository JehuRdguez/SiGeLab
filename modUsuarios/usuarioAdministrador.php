<?php 
$pagNom = 'USUARIOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>
  <?php
  include("../database.php");  //se incluye el  archivo
  $administradoresR = new Database();  //generamos la variable pq eso es lo que vamos a generar, con esto instanciamos
  if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
    $numConAdmin = $administradoresR->sanitize($_POST['numConAdmin']);  //se va a limpiar y recibir lo del formulario
    $nombreC = $administradoresR->sanitize($_POST['nombreC']);
    $correo = $administradoresR->sanitize($_POST['correo']);
    $telefono = $administradoresR->sanitize($_POST['telefono']);
    $contrasena = $administradoresR->sanitize($_POST['contrasena']);
    $res = $administradoresR->createAdministrador($nombreC, $correo, $telefono, $contrasena, 1, 1, $numConAdmin);

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


  <!--Opciones del botón-->
  <div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      Administradores</button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="../modUsuarios/usuarioAdministrador.php">Administradores</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/usuarioMaestro.php">Maestros</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/usuarioAlumno.php">Alumnos</a></li>
      <li><a class="dropdown-item" href="../modUsuarios/grupos.php">Grupos</a></li>
    </ul>
    <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#RegistroUsuarioAd">Registrar</a><br>
    </br>


    <!-- Mostrar tabla-->
    <div class="container">
      <table  id="administradorTable" style="background-color: #04aa89; "  class="table table-bordered " cellspacing="0" width="100%">
        <thead>
          <!-- Secciones o cabeceros -->
          <tr>
            <!-- filas -->
            <th>Número de trabajador</th> <!-- ENcabezados de las tablas-->
            <th>Nombre completo</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <!-- Cuerpo de la tabla, se llena con la BDD-->
          <?php
          $administradoresR = new Database(); //
          $listaAdministradores = $administradoresR->readAdministrador(); //se crea la variable listaAdministradores
          ?>
          <?php
          while ($row = mysqli_fetch_object($listaAdministradores)) { //antes del = es la variable del form, después es la de BDD
            $idUsuario = $row->idUsuario;
            $numConAdmin = $row->numConAdmin;
            $nombreC = $row->nombreC;
            $correo = $row->correo;
            $telefono = $row->telefono;
            $contrasena = $row->contrasena;
            $tipoUsuario = $row->tipoUsuario;
            $uActivo = $row->uActivo;
          ?>
            <tr>
              <td><?php echo $numConAdmin; ?></td> <!-- Muestra-->
              <td><?php echo $nombreC; ?></td>
              <td><?php echo $correo; ?></td>
              <td><?php if ($uActivo == 1) {
                    echo 'Activo';
                  } else {
                    echo 'Inactivo';
                  } ?></td>
              <td>
                <center>
                  <?php
                  if ($uActivo == 1) { ?>
                    <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateUA.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye-slash"></i></a></abbr>

                  <?php } else { ?>
                    <abbr title="Habilitar"><a type="button" class="btn btn-outline-dark" href="updateUA.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye"></i></a></abbr>
                  <?php } ?>
                  <abbr title="Actualizar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarAdministradores<?php echo $idUsuario; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
                  <!--Botón para detalles-->
                  <abbr title="Ver detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesAdministrador<?php echo $idUsuario; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
                </center>
              </td>
            </tr>
            <!--ventana para Update--->
            <div class="modal fade" id="editarAdministradores<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>


                  <form method="POST" action="EditarAdministrador.php">
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                    <div class="modal-body" id="cont_modal">

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Número de trabajador:</label>
                        <input type="number" name="numConAdmin" id="numConAdmin"  class="form-control" min="1" value="<?php echo $numConAdmin; ?>"  onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>


                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                        <input type="text" name="nombreC" id="nombreC" class="form-control" minlength="12" onkeypress="return ValidarLestrasC(event)" value="<?php echo $nombreC; ?>" maxlength="70" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>


                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Dirección de correo electrónico:</label>
                        <input type="email" name="correo" id="correo" class="form-control" minlength="15"  value="<?php echo $correo; ?>" maxlength="50" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Teléfono: </label>
                        <input type="number" name="telefono" id="telefono" class="form-control" min="1111111111" value="<?php echo $telefono; ?>"  onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                      </div>


                      <div class="form-group">
                      <?php
                    $datos_admin = $administradoresR->single_recordadministrador($idUsuario);
                    ?>
                        <label for="recipient-name" class="col-form-label">Contraseña:</label>
                        <input type="text" name="contrasena" id="contrasena" class="form-control" minlength="8" onkeypress="return ValidarContrasena(event)" value="<?php echo $datos_admin->contrasena; ?>" maxlength="20" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
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
            <!---fin ventana actualizar admin--->

            <!-- modal para detalles -->
            <div class="modal fade" id="detallesAdministrador<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                  </div>

                  <div class="modal-body">
                    <?php
                    $datos_admin = $administradoresR->single_recordadministrador($idUsuario);
                    ?>
                    <label>Contraseña: <strong><?php echo $datos_admin->contrasena; ?></strong></label></br>

                    </br><label>Teléfono: <strong><?php echo $telefono; ?></strong></label></br>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            <!---fin modal detalles--->
          <?php
          }
          ?>
        </tbody>

      </table>
    </div>

    <!--Modal-Hoja de registro de usuariosadministrador-->
    <div class="modal fade" id="RegistroUsuarioAd" tabindex="-1" aria-labelledby="RegistroUsuarioAdLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">


            <center>
              <h5 class="modal-title" id="RegistroUsuarioAd">Hoja de registro de administrador</h5>
            </center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <form method="post">
                <div class="row">
                  <center>
                    <label> Número de trabajador:</label>
                    <input type="number" name="numConAdmin" id="numConAdmin" class="form-control"  min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                    <label> Nombre completo:</label>
                    <input type="text" name="nombreC" id="nombreC" class="form-control" minlength="12" onkeypress="return ValidarLestrasC(event)"  maxlength="70"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  required>

                    <label> Dirección de correo electrónico:</label>
                    <input type="email" name="correo" id="correo" class="form-control" minlength="15" maxlength="50"   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"  required>

                    <label> Teléfono:</label>
                    <input type="number" name="telefono" id="telefono" class="form-control" min="1111111111" onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                    <label> Contraseña:</label>
                    <input type="text" name="contrasena" id="contrasena" class="form-control" minlength="8"  maxlength="20" onkeypress="return ValidarContrasena(event)"  oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                  </center>
                </div>

                <!-- Botón para enviar datos-->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  <button type="submit" id="registrar" class="btn btn-dark" onclick="return alertaRegistrar()">Registrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include("../public/footer.php"); ?>  <!--Se incluye el footer-->
    
    <?php } else if ($_SESSION['idTipoUsuario'] != 1 ) { ?> <!--Condiciones de acceso-->
    <?php header("Location: ../index.php"); ?>
  <?php } ?>