</body>



<!--///////////////////////////////////// Funciones de Diana///////////////////////////////////////////////-->

<!-- Para las tablas -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script><!-- Para hacerlas responsivas-->

<!-- Calendario -->

<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script src="jquery.ui.datepicker-es.js"></script>








<!-- Scripts de las tablas con su ID y la responsividad activa-->

<script>
    $(document).ready(function() {
        $('#maestroTable').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });


    $(document).ready(function() {
        $('#miEquipoTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#administradorTable').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#alumnoTable').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
                if (data[3] == 'Pendiente') {
                    $('td', row).eq(3).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
            }

        });
    });

    $(document).ready(function() {
        $('#gruposTable').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
                if (data[2] == 'Pendiente') {
                    $('td', row).eq(2).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }




            }

        });
    });

    //Jehu////////

    $(document).ready(function() {
        $('#laboratorios_laboratoriosTable').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
                if (data[1] == 'Pendiente') {
                    $('td', row).eq(1).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableIOT').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableIOTUsuarios').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableDesarrollo').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableDesarrolloUsuarios').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableSoporte').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_TableSoporteUsuario').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_horariosTableIOT').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_horariosTableDesarrollo').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#laboratorios_horariosTableSoporte').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });


    $(document).ready(function() {
        $('#laboratorios_equiposTableIOT').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[2] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_equiposTableDesarrollo').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[2] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_equiposTableSoporte').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[2] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_mobiliarioTableIOT').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_mobiliarioTableDesarrollo').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_mobiliarioTableSoporte').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[3] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMonitorIOT').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMonitorDesarrollo').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMonitorSoporte').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosTecladoIOT').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosTecladoDesarrollo').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosTecladoSoporte').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMouseIOT').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMouseDesarrollo').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

    $(document).ready(function() {
        $('#laboratorios_perifericosMouseSoporte').DataTable({

            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[4] == 'Inactivo') {
                    $('td', row).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }

            }

        });
    });

   ////////

    $(document).ready(function() {
        $('#incidenciasTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            "createdRow": function(row, data, index) {
                if (data[5] == 'Pendiente') {
                    $('td', row).eq(5).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
                else if(data[5] == 'En proceso') {
                    $('td', row).eq(5).css({
                        'background-color': '#fdfd96',

                        'color': 'black'

                    });
                }
               else if (data[5] == 'Concluida') {
                    $('td', row).eq(5).css({
                        'background-color': '#bdecb6',

                        'color': 'black'

                    });
                }
            }
        });
    });
    


    $(document).ready(function() {
        $('#solicitudesTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            
            "createdRow": function(row, data, index) {
                if (data[4] == 'Pendiente') {
                    $('td', row).eq(4).css({
                        'background-color': '#fdfd96',

                        'color': 'black'

                    });
                } else if(data[4] == 'Aceptada') {
                    $('td', row).eq(4).css({
                        'background-color': '#bdecb6',

                        'color': 'black'

                    });
            }else {
                    $('td', row).eq(4).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
            }
        }
    });
    });

    $(document).ready(function() {
        $('#solicitudesTableCEquipo').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            },
            
            "createdRow": function(row, data, index) {
                if (data[5] == 'Pendiente') {
                    $('td', row).eq(5).css({
                        'background-color': '#fdfd96',

                        'color': 'black'

                    });
                } else if(data[4] == 'Aceptada') {
                    $('td', row).eq(4).css({
                        'background-color': '#bdecb6',

                        'color': 'black'

                    });
            }else {
                    $('td', row).eq(4).css({
                        'background-color': '#ffb6af',

                        'color': 'black'

                    });
                }
            
            }

        });
    });



    $(document).ready(function() {
        $('#solicitudesTable2').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });

    $(document).ready(function() {
        $('#equiposAsignadosTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla1').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/es-MX.json'
            }
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


<!--Sólo permite números y guiones-->
<script>
    function verificaNumInv(e) {
        var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = "-0123456789",
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
        $('#iframePDF').attr('src', '<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/sigelab/modLaboratorios/'; ?>' + url);
    }
</script>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
    });
</script>

<script type="text/javascript">
    function mayusculas(e) {
        e.value = e.value.toUpperCase();
    }
</script>

<!-- ////////////////////////GABI//////////////////////////// -->




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

            alert("Hpra de salida menor a la de entrada");

            horaSalida.style.border = "1px solid red"

        }

        if (tFin.getTime() === tIni.getTime()) {

            alert("Las horas son iguales");

            horaSalida.style.border = "1px solid red"

        }


    }

    entrada.addEventListener("change", comparaHoras);
    salida.addEventListener("change", comparaHoras);
</script>

<script type="text/javascript">
    function alertaRegistrarS() {
        var mensaje;
        var opcion = confirm("¿Desea guardar el registro?");
        if (horaSalida.style.border == "1px solid red") {
            alert("Hora incorrecta");
            return false;
        } else if (opcion == true && horaSalida.style.border != "1px solid red") {
            if (document.getElementById("fecha").value > document.getElementById("fechaSalida").value) {
                alert("Rango de fechas inválido");
                return false;
            }
            
            return true;
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    function alertaLiberar() {
        var mensaje;
        var opcion = confirm("¿Esta seguro de liberar el laboratorio? *Esta accion no se puede deshacer*");
        if (!opcion) {
            return false;
        } else {
            return true;
        }
    }
</script>

<script type="text/javascript">
    function alertaRechazar() {
        var mensaje;
        var opcion = confirm("¿Desea rechazar la solicitud?");
        if (!opcion) {
            return false;
        } else {
            return true;
        }
    }
</script>
<!-- Validacion de fines de semana  -->
<script>
    function noExcursion(date) {

        var day = date.getDay();
        // aqui indicamos el numero correspondiente a los dias que ha de bloquearse (el 0 es Domingo, 1 Lunes, etc...) en el ejemplo bloqueo todos menos los lunes y jueves.
        return [(day != 0 && day != 6), ''];
    };
    $(function() {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#fecha").datepicker({
            dateFormat: "mm/dd/yy",
            minDate: 0,
            beforeShowDay: noExcursion,
            firstDay: 0,
            dayNamesMin: [ "Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb" ],
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
        });
    });
</script>
<script>
    $(function() {
        $.datepicker.setDefaults($.datepicker.regional["es"]);
        $("#fechaSalida").datepicker({
            dateFormat: "mm/dd/yy",
            minDate: 0,
            beforeShowDay: noExcursion,
            firstDay: 0,
            dayNamesMin: [ "Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb" ],
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]
        });
    });
</script>





<!-- TERMINA PARTE DE GABI-->






<!-- Librería Bootstrap 4 Icons -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

</html>