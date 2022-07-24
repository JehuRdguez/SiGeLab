</body>
<!--///////////////////////////////////// Funciones de Diana///////////////////////////////////////////////-->

<!-- Para las tablas -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />



<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script><!-- Para hacerlas responsivas-->
<!-- Para el calendario daterangepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="../assets/vendor/daterangepicker/moment.min.js"></script>
<script src="../assets/vendor/daterangepicker/daterangepicker.js"></script>




<!-- Scripts de las tablas con su ID y la responsividad activa-->
<script>
    $(document).ready(function() {
        $('#maestroTable').DataTable({
            responsive: true
        });
    });


    $(document).ready(function() {
        $('#miEquipoTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#administradorTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#alumnoTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#gruposTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_equiposTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_horariosTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_laboratoriosTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_mobiliarioTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosmonitor').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosteclado').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosgabinete').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosmouse').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#laboratoriosTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#incidenciasTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#solicitudesTable').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $('#equiposAsignadosTable').DataTable({
            responsive: true
        });
    });
</script>




<!-- Alerta para confirmar registro -->
<script type="text/javascript">
    function alertaRegistrar() {
        var mensaje;
        var opcion = confirm("¿Desea guardar el registro?");
        if (opcion == true) {
            return true;
        } else {
            return false;
        }
    }
</script>



<!-- Alerta para confirmar edición -->
<script type="text/javascript">
    function alertaEditar() {
        var mensaje;
        var opcion = confirm("¿Desea guardar los cambios?");
        if (opcion == true) {
            return true;
        } else {
            return false;
        }
    }
</script>


<!-- Alerta para confirmar eliminacion -->
<script type="text/javascript">
    function eliminar() {
        var mensaje;
        var opcion = confirm("¿Desea eliminar el registro?");
        if (opcion == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

<!--Sólo permite números -->
<script>
    function verificaNumeros(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    }
</script>

<!--Sólo permite letras -->
<script>
    function ValidarLestrasC(e) {
        var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
            especiales = [8],
            tecla_especial = false;

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }
</script>

<!--Función para validar las contraseñas -->
<script>
    function ValidarContrasena(e) {
        var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = "abcdefghijklmnñopqrstuvwxyz1234567890",
            especiales = [8],
            tecla_especial = false;

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }
</script>

<!--Termina apartado de Diana-->






<!--REVISAR-->
<script type="text/javascript">
    function funcionMonitor() {
        var x = document.getElementById("vistamonitor");
        var y = document.getElementById("vistateclado");
        var z = document.getElementById("vistagabinete");
        var m = document.getElementById("vistamouse");


        if (x.style.display == "none" || y.style.display == "block" || z.style.display == "none" || m.style.display == "none") {
            y.style.display = "none";
            x.style.display = "block";
            z.style.display = "none";
            m.style.display = "none";
        }
    }

    function funcionTeclado() {
        var x = document.getElementById("vistamonitor");
        var y = document.getElementById("vistateclado");
        var z = document.getElementById("vistagabinete");
        var m = document.getElementById("vistamouse");

        if (x.style.display == "block" || y.style.display == "none" || z.style.display == "none" || m.style.display == "none") {
            y.style.display = "block";
            x.style.display = "none";
            z.style.display = "none";
            m.style.display = "none";
        }
    }

    function funcionGabinete() {
        var x = document.getElementById("vistamonitor");
        var y = document.getElementById("vistateclado");
        var z = document.getElementById("vistagabinete");
        var m = document.getElementById("vistamouse");

        if (x.style.display == "none" || y.style.display == "none" || z.style.display == "block" || m.style.display == "none") {
            y.style.display = "none";
            x.style.display = "none";
            z.style.display = "block";
            m.style.display = "none";
        }
    }

    function funcionMouse() {
        var x = document.getElementById("vistamonitor");
        var y = document.getElementById("vistateclado");
        var z = document.getElementById("vistagabinete");
        var m = document.getElementById("vistamouse");

        if (x.style.display == "none" || y.style.display == "none" || z.style.display == "none" || m.style.display == "block") {
            y.style.display = "none";
            x.style.display = "none";
            z.style.display = "none";
            m.style.display = "block";
        }
    }


    element = document.getElementById("vistamonitor");
    element2 = document.getElementById("vistateclado");
    element3 = document.getElementById("vistagabinete");
    element4 = document.getElementById("vistamouse");

    element.style.display = 'block';
    element2.style.display = 'none';
    element3.style.display = 'none';
    element4.style.display = 'none';
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<script type="text/javascript">
    $('button').on('submit', function(e) {
        e.stopPropagation();
    });
</script>



<!--REVISAR-->


<script>
    function onSubmitForm() {
        var frm = document.getElementById('form1');
        var data = new FormData(frm);
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readystate == 4) {
                var msg = xhttp.responseText;
                if (msg == 'success') {
                    alert(msg);
                    $('#archivos').modal('hide');
                } else {
                    alert(msg);
                }
            }
        };
        xhttp.open("POST", "uploadPDF.php", true);
        xhttp.send(data);
        $('#form1').trigger('reset');
        window.location.reload();
    }

    function openModelPDF(url) {
        $('#modalPdf').modal('show');
        $('#iframePDF').attr('src', '<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/sigelab/'; ?>' + url);
    }
</script>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla1').DataTable();
    });
</script>

<script type="text/javascript">
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    }
</script>

<!-- ////////////////////////GABI//////////////////////////// -->

<!-- Para verificar las horas y que sean validas  -->

<script type="text/javascript">
let input = document.getElementById("input")
const entrada = document.getElementById("horaEntrada");
const salida = document.getElementById("horaSalida");


const comparaHoras = () => {

  const ventrada = entrada.value;
  const vsalida = salida.value;

  if (!ventrada || !vsalida) {
    return;
  }

  const tIni = new Date();

  const pentrada = ventrada.split(":");

  tIni.setHours(pentrada[0], pentrada[1]);

  const tFin = new Date();

  const pFin = vsalida.split(":");

  tFin.setHours(pFin[0], pFin[1]);


  if (tFin.getTime() > tIni.getTime()) {

    
    horaSalida.style.border = "1px solid black"
    acceptData()

  }

  if (tFin.getTime() < tIni.getTime()) {

    alert("Salida menor a entrada");
    
   horaSalida.style.border = "1px solid red"

  }

  if (tFin.getTime() === tIni.getTime()) {

    alert("Las fechas son iguales");
   
    horaSalida.style.border = "1px solid red"

  }


}

entrada.addEventListener("change", comparaHoras);
salida.addEventListener("change", comparaHoras);
</script>

<!-- Para registrar sin errores de hora en el formulario de solicitudes -->
<script type="text/javascript">
    function alertaRegistrarS() {
        var mensaje;
        var opcion = confirm("¿Desea guardar el registro?");
        if (horaSalida.style.border == "1px solid red") {
            alert("Hora incorrecta");
            return false;
        } else if (opcion == true &&  horaSalida.style.border != "1px solid red"){
            return true;
        }
        else {
            return false;
        }
    }
</script>


<script type="text/javascript">
    function alertaRechazar() {
        var mensaje;
        var opcion = confirm("¿Desea rechazar la solicitud?");
        if (!opcion){
            return false;
        } else{
            window.location.href="updateSE2.php?idsolicitudCambioE=<?php echo $idsolicitudCambioE; ?>"
            return true;
        }
    }
</script>

<!-- Función para rango de fechas valido  -->


<script>
  $(document).on('ready', function () {
    // initialization of daterangepicker
    $('.js-daterangepicker').daterangepicker();
  });
</script>

<!-- TERMINA PARTE DE GABI-->






<!-- Librería Bootstrap 4 Icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</html>