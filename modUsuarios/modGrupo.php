


<!--ventana para Update--->
<div class="modal fade" id="detallesGrupo<?php echo $idGrupo; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" >
            <h5 class="modal-title" id="exampleModalLabel">Detalles grupo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
 

            <form method="POST" >
                <input type="hidden" name="idGrupo" value="<?php echo $idGrupo; ?>">

                <div class="modal-body" id="cont_modal">
                <h5>Alumnos del grupo: <?php echo $nombreGrupo; ?> </h5>
                <?php
                    $gruposALumnos = new Database(); //
                    $listaAlumnos = $gruposALumnos->listaAl(); //se crea la variable listaAdministradores
                    while($row = mysqli_fetch_object($listaAlumnos)) {
                        $nombreC = $row->nombreC;
                        $grupo = $row->idGrupo;
                        if($idGrupo == $grupo){ ?>
               <label><strong><?php echo $nombreC; ?></strong></label></br>
                <?php } } ?>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!---fin ventana Update --->