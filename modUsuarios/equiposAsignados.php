<?php 
$pagNom = 'EQUIPOS ASIGNADOS';
?>

<?php include("../public/header.php");?>
<?php if ($idTipoUsuario == 2) { ?>

<!-- Mostrar tabla-->
<div class="container">
  <table  class="table table-bordered " cellspacing="0" width="100%" id="equiposAsignadosTable" style="background-color: #04aa89;  ">
    <thead>
      <!-- Secciones o cabeceros -->
      <tr >
        <!-- filas -->
        <th>Nombre alumno</th> <!-- ENcabezados de las tablas-->
        <th>Grupo</th>
        <th>Equipo asignado IoT</th>
        <th>Equipo asignado desarrollo</th>
        <th>Equipo asignado Soporte</th>
      </tr>
    </thead>

    <tbody>
      <!-- Cuerpo de la tabla, se llena con la BDD-->
      <?php
      include("../database.php");
      $equipos = new Database(); //
      $equiposAsignados = $equipos->equiposA(); //se crea la variable listaAdministradores
      ?>
      <?php
      while ($row = mysqli_fetch_object($equiposAsignados)) { //antes del = es la variable del form, después es la de BDD
        $nombreCAlum= $row->nombreC;
        $grupo = $row->nombreGrupo;
          $idEquipoIOT=$row->equipoIOT;
          $idEquipoDesarrollo=$row->equipoDesarrollo;
          $idEquipoSoporte=$row->equipoSoporte;
      ?>
        <tr >
          <td><?php echo $nombreCAlum ?></td> <!-- Muestra-->
          <td><?php echo $grupo ?></td>
          <td><?php if ($idEquipoIOT==0){ echo 'No aplica'; } else{echo $idEquipoIOT; }?></td>
          <td><?php if ($idEquipoDesarrollo==0){ echo 'No aplica'; } else{echo $idEquipoDesarrollo; }?></td>
          <td><?php if ($idEquipoSoporte==0){ echo 'No aplica'; } else{echo $idEquipoSoporte; }?></td>
        </tr>

        <?php
      }
      ?>
    </tbody>
  </table>
</div>

<?php include("../public/footer.php"); ?>
  <?php } ?>



