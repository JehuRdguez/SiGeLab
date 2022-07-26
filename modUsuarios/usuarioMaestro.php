<?php 
$pagNom = 'USUARIOS';
?>

<?php include("../public/header.php"); ?>
<?php if ($_SESSION['idTipoUsuario'] == 1) { ?>

      <?php
      include("../database.php");  //se incluye el otro archivo
      $maestros = new Database();  //generamos la variable pq eso es lo que vamos a generar, con esto instanciamos

      if (isset($_POST) && !empty($_POST)) { //con esto valido dos cosas isset es para verificar si la acción post está declarado y para saber si se encuentra vacio
        $numConMaes = $maestros->sanitize($_POST['numConMaes']);  //se va a limpiar y recibir lo del formulario
        $nombreC = $maestros->sanitize($_POST['nombreCM']);
        $correo = $maestros->sanitize($_POST['correoM']);
        $telefono = $maestros->sanitize($_POST['telefonoM']);
        $contrasena = $maestros->sanitize($_POST['contrasenaM']);

        $res = $maestros->createMaestro($nombreC, $correo, $telefono, $contrasena, 2, 1, $numConMaes);//Para crear un nuevo maestro

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
          Maestros</button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="../modUsuarios/usuarioAdministrador.php">Administradores</a></li>
          <li><a class="dropdown-item" href="../modUsuarios/usuarioMaestro.php">Maestros</a></li>
          <li><a class="dropdown-item" href="../modUsuarios/usuarioAlumno.php">Alumnos</a></li>
          <li><a class="dropdown-item" href="../modUsuarios/grupos.php">Grupos</a></li>
        </ul>
        <!--Botón de registro -->
        <a class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#RegistroUsuarioM">Registrar</a><br>
        <br />




        <!-- Mostrar tabla-->
        <div class="container">
          <table  class="table table-bordered " cellspacing="0" width="100%"  id="maestroTable" style="background-color: #04aa89;">
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
              $listaMaestros = $maestros->readMaestro(); //se crea la variable listaAdministradores
              ?>

              <?php
              while ($row = mysqli_fetch_object($listaMaestros)) { //antes del = es la variable del form, después es la de BDD
                $idUsuario = $row->idUsuario;
                $numConMaes = $row->numConMaes;
                $nombreC = $row->nombreC;
                $correo = $row->correo;
                $telefono = $row->telefono;
                $contrasena = $row->contrasena;
                $tipoUsuario = $row->tipoUsuario;
                $uActivo = $row->uActivo;
              ?>
                <tr>
                  <td><?php echo $numConMaes; ?></td> <!-- Muestra-->
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
                        <abbr title="Deshabilitar"><a type="button" class="btn btn-outline-dark" href="updateUM.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye-slash" onclick="return cambiarColor()"></i></a></abbr>
                      <?php } else { ?>
                        <abbr title="Habilitar"><a type="button" class="btn btn-outline-dark" href="updateUM.php?idUsuario=<?php echo $idUsuario; ?>"><i class="fa fa-eye"></i></a></abbr>
                      <?php } ?>
                      <abbr title="Actualizar"><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editarMaestros<?php echo $idUsuario; ?>"><i class="fa-solid fa-pen-to-square"></i></button></abbr>
                      <!--Botón para detalles-->
                      <abbr title="Ver detalles"><a type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detallesMaestro<?php echo $idUsuario; ?>"><i class="fa-solid fa-ellipsis"></i></a></abbr>
                    </center>
                  </td>
                </tr>
                <!--ventana para Update--->
                <div class="modal fade" id="editarMaestros<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar usuario maestro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>


                      <form method="POST" action="EditarMaestro.php">
                        <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">

                        <div class="modal-body" id="cont_modal">

                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Número de trabajador:</label>
                            <input type="number" name="numConMaes" id="numConMaes" class="form-control" value="<?php echo $numConMaes; ?>" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                          </div>

                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nombre completo:</label>
                            <input type="text" name="nombreCM" id="nombreCM" class="form-control" minlength="15" onkeypress="return ValidarLestrasC(event)" value="<?php echo $nombreC; ?>" required="true">
                          </div>

                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Dirección de correo electrónico:</label>
                            <input type="email" name="correoM" id="correoM" class="form-control" minlength="15" value="<?php echo $correo; ?>" required="true">
                          </div>

                          <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Teléfono: </label>
                            <input type="number" name="telefonoM" id="telefonoM" class="form-control" value="<?php echo $telefono; ?>" min="1111111111" onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->
                          </div>

                          <div class="form-group">
                          <?php
                        $datos_maes = $maestros->single_recordmaestro($idUsuario);
                        ?>
                            <label for="recipient-name" class="col-form-label">Contraseña:</label>
                            <input type="text" name="contrasenaM" id="contrasenaM" class="form-control" minlength="8" onkeypress="return ValidarContrasena(event)"  value="<?php echo $datos_maes->contrasena; ?>" required="true">
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
                <div class="modal fade" id="detallesMaestro<?php echo $idUsuario; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                      </div>

                      <div class="modal-body">
                        <?php
                        $datos_maes = $maestros->single_recordmaestro($idUsuario);
                        ?>
                        <label>Contraseña: <strong><?php echo $datos_maes->contrasena; ?></strong></label></br>

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


        <!--Modal-Hoja de registro de usuarios Maestros-->

        <div class="modal fade" id="RegistroUsuarioM" tabindex="-1" aria-labelledby="RegistroUsuarioMLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <center>
                  <h5 class="modal-title" id="RegistroUsuarioM">Hoja de registro de maestro</h5>
                </center>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="container-fluid">
                  <form method="post">
                    <div class="row">
                      <center>
                        <label> Número de trabajador:</label>
                        <input type="number" name="numConMaes" id="numConMaes" class="form-control" min="1" onkeypress="return verificaNumeros(event);" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                        <label> Nombre completo:</label>
                        <input type="text" name="nombreCM" id="nombreCM" class="form-control"  minlength="15" onkeypress="return ValidarLestrasC(event)" required>

                        <label> Dirección de correo electrónico:</label>
                        <input type="email" name="correoM" id="correoM" class="form-control" minlength="15" required>

                        <label> Teléfono:</label>
                        <input type="number" name="telefonoM" id="telefonoM" class="form-control" min="1111111111" onkeypress="return verificaNumeros(event);" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required> <!-- Devuelve una cadena vacia si no se cumple con ser mayor a 0-->

                        <label> Contraseña:</label>
                        <input type="text" name="contrasenaM" id="contrasenaM" class="form-control" minlength="8" onkeypress="return ValidarContrasena(event)"  required>
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

        <?php include("../public/footer.php"); ?><!--Se incluye el footer-->
        
        <?php } else if ($_SESSION['idTipoUsuario'] != 1 ) { ?><!--Condiciones de acceso-->
          <?php header("Location: ../index.php"); ?>
      <?php } ?>