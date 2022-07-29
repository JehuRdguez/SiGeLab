<?php

class Database
{
    private $con; //Almacenar conexión
    private $dbhost = "localhost"; //nombre del hsot
    private $dbuser = "root"; //Nombre usuario para acceder 
    private $dbpass = ""; //contraseña para acceder 
    private $dbname = "sigelab"; //Nombre de la bdd


    function __construct()
    {  //permite realizar la conexión a la BDD 
        $this->connect_db(); //usando la función DB
    }
    public function connect_db()
    {
        $this->con = mysqli_connect(
            $this->dbhost,
            $this->dbuser,
            $this->dbpass,
            $this->dbname
        );

        if (mysqli_connect_error()) {
            die("Conexión a la BDD falló" . mysqli_connect_error() . mysqli_connect_errno());
        }
    }

    public function sanitize($var)
    {
        $return = mysqli_real_escape_string($this->con, $var);
        return $return;
    }

////////////////////////////////////////////////////////////INICIA PARTE DE DIANA/////////////////////////////////////////////////
   
/////////////////////////////ADMINISTRADOR/////////////////////////////////////////////////

    //registro administrador
    public function createAdministrador($nombreC, $correo, $telefono,  $contrasena, $uActivo, $idTipoUsuario, $numConAdmin,)
    {
        $sql = "CALL proAddAdministrador('$nombreC','$correo','$telefono','$contrasena','$uActivo','$idTipoUsuario','$numConAdmin')  ";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //Consulta Administrador
    public function readAdministrador()
    { 
        $sql = "SELECT * from  vwusuarioadministrador ";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    
//Vista usuarios activos opción de selección
    public function readAdministradorAct()
    {
        $sql = "SELECT * from  usuario WHERE idTipoUsuario = '1' AND uActivo = '1' ";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Función para editar estado Administrador
    public function updateusuarioAdministrador($idUsuario)
    {
        $sql = "SELECT * FROM usuario WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->uActivo) {
            $sql = "UPDATE usuario SET uActivo=0 WHERE idUsuario='$idUsuario'";
        } else {
            $sql = "UPDATE usuario SET uActivo=1 WHERE idUsuario='$idUsuario'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }



        //Función para obtener la contraseña
    public function single_recordadministrador($idUsuario)
    {
        $sql = "SELECT * FROM contrasenaDescifrada WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }


    //Función para editar los datos de un administrador
    public function editarAdministrador($numConAdmin, $nombreC, $correo, $telefono,  $contrasena, $idTipoUsuario)
    {
        $sql = "CALL proEditAdministrador('$numConAdmin','$nombreC','$correo','$telefono','$contrasena','$idTipoUsuario')  ";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////////////////////ALUMNO/////////////////////////////////////////////////////

    //registro alumno/////////
    public function createAlumno($nombreC, $correo, $telefono, $contrasena, $uActivo, $idTipoUsuario, $numConAlum, $idGrupo, $idEquipoIOT, $idEquipoDesarrollo, $idEquipoSoporte)
    {
        $sql = "CALL proAddAlumno('$nombreC','$correo','$telefono','$contrasena','$uActivo','$idTipoUsuario','$numConAlum','$idGrupo','$idEquipoIOT','$idEquipoDesarrollo', '$idEquipoSoporte')  ";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //Consulta Alumno///////////////
    public function readAlumno()
    { //Función para consulta
        $sql = "SELECT * from vwUsuarioAlumno";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }



    //Función para editar estado alumno///
    public function updateusuarioAlumno($idUsuario)
    {
        $sql = "SELECT * FROM usuario WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->uActivo) {
            $sql = "UPDATE usuario SET uActivo=0 WHERE idUsuario='$idUsuario'";
        } else {
            $sql = "UPDATE usuario SET uActivo=1 WHERE idUsuario='$idUsuario'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }



    //Función para obtener la contraseña
    public function single_recordusuarioContraAl($idUsuario)
    {
        $sql = "SELECT * FROM contrasenadescifrada WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

       //Función para obtener toda la info de un sólo registro
    public function single_recordusuarioAl($idUsuario)
    {
        $sql = "SELECT * from vwEditAlumno WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    //Función para editar
    public function editarUAlumno($nombreC, $correo, $telefono, $contrasena, $numConAlum, $idGrupo, $idEquipoIOT, $idEquipoDesarrollo, $idEquipoSoporte, $idUsuario)
    {
        $sql = "    UPDATE  usuario,alumno,contrasenadescifrada SET usuario.nombreC='$nombreC', usuario.correo='$correo', usuario.telefono='$telefono', usuario.contrasena=md5('$contrasena'),  alumno.numConAlum='$numConAlum',alumno.idGrupo='$idGrupo',
    alumno.idEquipoIOT='$idEquipoIOT',
    alumno.idEquipoDesarrollo='$idEquipoDesarrollo',
    alumno.idEquipoSoporte='$idEquipoSoporte',
    contrasenadescifrada.contrasena='$contrasena'
     WHERE usuario.idUsuario='$idUsuario' and alumno.idUsuario='$idUsuario' and contrasenadescifrada.idUsuario='$idUsuario' ";


        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

//Función para el listado de alumnos que se muestra en modal detalles de grupo
    public function listaAl()
    { 
        $sql = "SELECT `usuario`.`nombreC`, `alumno`.`idUsuario`, `grupo`.`idGrupo`
            FROM `usuario` 
                INNER JOIN `alumno` ON `alumno`.`idUsuario` = `usuario`.`idUsuario`
                INNER JOIN `grupo` ON `alumno`.`idGrupo` = `grupo`.`idGrupo` where uActivo=1";        //nombre tabla, es la misma q en el insert intoooo
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    ///////////////////////////////MAESTRO/////////////////////////////////////////////////////////

    //registro maestro
    public function createMaestro($numConMaes, $nombreC, $correo, $telefono, $contrasena, $tipoUsuario, $uActivo)
    {   $sql = "CALL proAddMaestro('$numConMaes','$nombreC','$correo','$telefono','$contrasena','$tipoUsuario','$uActivo')  ";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //Consulta Maestro
    public function readMaestro()
    {
        $sql = "SELECT * from vwUsuarioMaestro";     
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    //Función para editar estado maestro
    public function updateusuarioMaestro($idUsuario)
    {
        $sql = "SELECT * FROM usuario WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->uActivo) {
            $sql = "UPDATE usuario SET uActivo=0 WHERE idUsuario='$idUsuario'";
        } else {
            $sql = "UPDATE usuario SET uActivo=1 WHERE idUsuario='$idUsuario'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }


      //Función para obtener la contraseña
    public function single_recordmaestro($idUsuario)
    {
        $sql = "SELECT * FROM contrasenadescifrada WHERE idUsuario='$idUsuario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }


    //Función para editar
    public function editarMaestro($numConMaes, $nombreC, $correo, $telefono,  $contrasena, $idUsuario)
    {
        $sql = "CALL proEditMaestro('$numConMaes','$nombreC','$correo','$telefono','$contrasena','$idUsuario')  ";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////GRUPO/////////////////////////////////////

    //registro grupo
    public function createGrupo($nombreGrupo, $idUsuario, $estado)
    { 
        $sql = "CALL proAddGrupo('$nombreGrupo','$idUsuario','$estado')  ";

        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //ConsultaGrupo
    public function readGrupo()
    { 
        $sql = "SELECT * from vwGrupos";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    //Función para editar estado grupo
    public function updategrupo($idGrupo)
    {
        $sql = "SELECT * FROM grupo WHERE idGrupo='$idGrupo'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE grupo SET estado=0 WHERE idGrupo='$idGrupo'";
        } else {
            $sql = "UPDATE grupo SET estado=1 WHERE idGrupo='$idGrupo'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //Función para obtener toda la info de un sólo registro
    public function single_recordgrupo($idGrupo)
    {
        $sql = "SELECT * FROM grupo WHERE idGrupo='$idGrupo'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    //Función para editar tutor
    public function editarGrupo( $idUsuario, $idGrupo)
    {
        $sql = "UPDATE grupo SET idUsuario='$idUsuario' WHERE idGrupo='$idGrupo'";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    ////////////////////////////////CONSULTAS PARA OPCIONES/////////////////////////////////////////////////////

    //Consulta de equipos por laboratorios
    public function equiposIOT()
    {
        $sql = "SELECT * from vwEquiposIOT";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    public function equiposDESARROLLO()
    { 
        $sql = "SELECT * from vwEquiposDesarrollo";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function equiposSOPORTE()
    { 
        $sql = "SELECT * from vwEquiposSoporte";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    public function SeleccionarAlumno()
    { //Función para consulta
        $sql = "SELECT * from vwEditAlumno";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Listado de grupos activos
    public function readListaGrupo()
    { 
        $sql = "SELECT * from vwListaGrupos";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

        //Listado de maestros activos
    public function readListaTutores()
    {
        $sql = "SELECT * from vwListaMaestros";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }



    //////////////////////////////EQUIPOS ASIGNADOS////////////////////////
    ///Para mostrar los equipos asignados a los alumnos
    public function equiposA()
    {
        $sql = "SELECT * from vwEquiposAsignados";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

//////REGISTRAR SOLICITUD CAMBIO EQUIPO ALUMNOS/////
    public function createSolicitudAL($idGrupo, $estado, $alumnoN, $razon, $idLaboratorio, $respuesta)
    {

        $sql = "INSERT INTO `solicitudcambioe` ( `idGrupo`, `estado`, `alumno`, `razon`, `idLaboratorio`, `respuesta`)
         VALUES ('$idGrupo', '$estado','$alumnoN', '$razon', '$idLaboratorio', '$respuesta'); ";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }



    /////////////////////////////////////////////////////////////////JEHU/////////////////////////////////////////////////////////////////////     

    public function createEquipo($idLaboratorio, $numInvEscolar, $numSerieEquipo, $numMonitor, $numTeclado, $numMouse, $ubicacionEnMesa, $procesador, $discoDuro, $ram, $estado)
    {
        $sql = "INSERT INTO `equipo` (
        idLaboratorio, numInvEscolar, numSerieEquipo, numMonitor, numTeclado, numMouse, ubicacionEnMesa, procesador, discoDuro, ram, estado)
        VALUES ('$idLaboratorio', '$numInvEscolar', '$numSerieEquipo', '$numMonitor', '$numTeclado', '$numMouse', '$ubicacionEnMesa', '$procesador', '$discoDuro', '$ram', '$estado')";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function readEquipoIOT()
    {
        $sql = "SELECT * FROM vwequipo WHERE idLaboratorio=1";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readEquipoDesarrollo()
    {
        $sql = "SELECT * FROM vwequipo WHERE idLaboratorio=2";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readEquipoSoporte()
    {
        $sql = "SELECT * FROM vwequipo WHERE idLaboratorio=3";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    public function single_recordequipo($idEquipo)
    {
        $sql = "SELECT * FROM equipo WHERE idEquipo='$idEquipo'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function single_recordequipoDet($idEquipo)
    {
        $sql = "SELECT * FROM vwequipo WHERE idEquipo='$idEquipo'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function updateEstadoEquipo($idEquipo)
    {
        $sql = "SELECT * FROM equipo WHERE idEquipo='$idEquipo'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE equipo SET estado=0 WHERE idEquipo='$idEquipo'";
        } else {
            $sql = "UPDATE equipo SET estado=1 WHERE idEquipo='$idEquipo'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function updateEquipo($idLaboratorio, $numInvEscolar, $numSerieEquipo, $numMonitor, $numTeclado, $numMouse, $ubicacionEnMesa, $procesador, $discoDuro, $ram, $idEquipo)
    {
        $sql = "UPDATE equipo SET idLaboratorio='$idLaboratorio', numInvEscolar='$numInvEscolar', numSerieEquipo='$numSerieEquipo', numMonitor='$numMonitor', numTeclado='$numTeclado', numMouse='$numMouse', ubicacionEnMesa='$ubicacionEnMesa', procesador='$procesador', discoDuro='$discoDuro',ram='$ram'
    WHERE idEquipo='$idEquipo'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }



    //registro monitor
    public function createPeriferico($numInvEscolar, $numSerie, $marca, $modelo, $estado, $idTipoPerifericos, $idLaboratorio)
    {
        $sql = "INSERT INTO `perifericos` (numInvEscolar, numSerie, marca, modelo, estado, idTipoPerifericos, idLaboratorio)
        VALUES ('$numInvEscolar','$numSerie','$marca','$modelo' ,'$estado', '$idTipoPerifericos', '$idLaboratorio')";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //Consulta monitor
    public function readMonitorIOT()
    {
        $sql = "SELECT * from vwmonitor WHERE idLaboratorio=1";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readMonitorDesarrollo()
    {
        $sql = "SELECT * from vwmonitor WHERE idLaboratorio=2";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readMonitorSoporte()
    {
        $sql = "SELECT * from vwmonitor WHERE idLaboratorio=3";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Función para editar estado monitor
    public function updateEstadoPeriferico($idPerifericos)
    {
        $sql = "SELECT * FROM perifericos WHERE idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE perifericos SET estado=0 WHERE idPerifericos='$idPerifericos'";
        } else {
            $sql = "UPDATE perifericos SET estado=1 WHERE idPerifericos='$idPerifericos'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function single_recordperiferico($idPerifericos)
    {
        $sql = "SELECT * FROM perifericos WHERE idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }


    //Función editar monitor
    public function editarPerifericos($numInvEscolar, $numSerie, $marca, $modelo, $idPerifericos)
    {
        $sql = "UPDATE  perifericos SET perifericos.numInvEscolar='$numInvEscolar', perifericos.numSerie='$numSerie', perifericos.marca='$marca', perifericos.modelo='$modelo'
         WHERE perifericos.idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //registro teclado
    public function createTeclado($numInvEscolar, $numSerieTeclado, $marca, $modelo, $estado, $idTipoPerifericos)
    { //variables
        $sql = "CALL proAddTeclado ('$numInvEscolar','$numSerieTeclado', '$marca', '$modelo', '$estado', '$idTipoPerifericos')";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //Consulta monitor
    public function readTecladoIOT()
    {
        $sql = "SELECT * from vwteclado WHERE idLaboratorio=1";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readTecladoDesarrollo()
    {
        $sql = "SELECT * from vwteclado WHERE idLaboratorio=2";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readTecladoSoporte()
    {
        $sql = "SELECT * from vwteclado WHERE idLaboratorio=3";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    


    //Función para editar estado perifericos
    public function updateEstadoTeclado($idPerifericos)
    {
        $sql = "SELECT * FROM perifericos WHERE idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE perifericos SET estado=0 WHERE idPerifericos='$idPerifericos'";
        } else {
            $sql = "UPDATE perifericos SET estado=1 WHERE idPerifericos='$idPerifericos'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }



    //Función editar teclado
    public function editarTeclado($numInvEscolar, $numSerieTeclado, $marca, $modelo, $idPerifericos)
    {
        $sql = "UPDATE  perifericos,perifericoteclado SET perifericos.numInvEscolar='$numInvEscolar', perifericoteclado.numSerieTeclado='$numSerieTeclado', perifericos.marca='$marca', perifericos.modelo='$modelo'
         WHERE perifericos.idPerifericos='$idPerifericos' AND perifericoTeclado.idPerifericos='$idPerifericos' ";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //registro mouse
    public function createMouse($numInvEscolar, $numSerieMouse, $marca, $modelo, $estado, $idTipoPerifericos)
    { //variables
        $sql = "CALL proAddMouse ('$numInvEscolar','$numSerieMouse', '$marca', '$modelo', '$estado', '$idTipoPerifericos')";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //Consulta mouse
    public function readMouseIOT()
    {
        $sql = "SELECT * from vwmouse WHERE idLaboratorio=1";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readMouseDesarrollo()
    {
        $sql = "SELECT * from vwmouse WHERE idLaboratorio=2";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readMouseSoporte()
    {
        $sql = "SELECT * from vwmouse WHERE idLaboratorio=3";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }


    //Función para editar estado monitor
    public function updateEstadoMouse($idPerifericos)
    {
        $sql = "SELECT * FROM perifericos WHERE idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE perifericos SET estado=0 WHERE idPerifericos='$idPerifericos'";
        } else {
            $sql = "UPDATE perifericos SET estado=1 WHERE idPerifericos='$idPerifericos'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function single_recordMouse($idPerifericos)
    {
        $sql = "SELECT * FROM perifericos WHERE idPerifericos='$idPerifericos'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    //Función editar monitor
    public function editarMouse($numInvEscolar, $numSerieMouse, $marca, $modelo, $idPerifericos)
    {
        $sql = "    UPDATE  perifericos,perifericomouse SET perifericos.numInvEscolar='$numInvEscolar', perifericomouse.numSerieMouse='$numSerieMouse', perifericos.marca='$marca', perifericos.modelo='$modelo'
         WHERE perifericos.idPerifericos='$idPerifericos' AND perifericomouse.idPerifericos='$idPerifericos' ";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function readMonitorAct()
    {
        $sql = "SELECT * FROM vwmonitora";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readTecladoAct()
    {
        $sql = "SELECT * FROM vwtecladoa";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readGabineteAct()
    {
        $sql = "SELECT * FROM vwgabinetea";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readMouseAct()
    {
        $sql = "SELECT * FROM vwmousea";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }



    ///////////////////////////////////////////////////////////FIN JEHU///////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////SANABIA///////////////////////////////////////////////////////////////////////
    //registrar laboratorio
    public function createLab($nombreLaboratorio, $idUsuario, $capacidad, $estado)
    {
        $sql = "INSERT INTO `laboratorio` (nombreLaboratorio, idUsuario, capacidad,estado)
           VALUES ('$nombreLaboratorio','$idUsuario','$capacidad','$estado')";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //consultar laboratorio
    public function readLab()
    {
        $sql = "SELECT * FROM vwlaboratorio";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readLabAct()
    {
        $sql = "SELECT * FROM vwlaboratorioa";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }



    //cambio de estado

    public function updateLaboratorio($idLaboratorio)
    {
        $sql2 = "SELECT estado FROM laboratorio where idLaboratorio = $idLaboratorio";
        $res2 = mysqli_query($this->con, $sql2);
        $return = mysqli_fetch_object($res2);
        if ($return->estado) {
            $sql = "UPDATE laboratorio SET estado='0' where idLaboratorio =$idLaboratorio";
        } else {
            $sql = "UPDATE laboratorio SET estado='1' where idLaboratorio =$idLaboratorio";
        }
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function single_recordLaboratorio($idLaboratorio)
    {
        $sql = "SELECT * FROM laboratorio WHERE idLaboratorio='$idLaboratorio'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function editarLaboratorio($nombreLaboratorio, $idUsuario, $capacidad, $idLaboratorio)
    {
        $sql = "UPDATE laboratorio SET nombreLaboratorio='$nombreLaboratorio',idUsuario='$idUsuario',capacidad='$capacidad' WHERE idLaboratorio='$idLaboratorio'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //registro mobiliario
    public function createMobiliario($numInvMobiliario, $seccionesDeMesa, $descripcion, $idLaboratorio, $estado)
    { //variables

        $sql = "INSERT INTO `mobiliario` (numInvMobiliario,seccionesDeMesa,descripcion,idLaboratorio,estado)  
    VALUES('$numInvMobiliario','$seccionesDeMesa','$descripcion','$idLaboratorio','$estado')  ";
        try {
            $res = mysqli_query($this->con, $sql);
        } catch (\Throwable) {
            return 'duplicado';
        }
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    //ConsultaMobiliario
    public function readMobiliarioIOT()
    { //Función para consulta
        $sql = "SELECT * from vwmobiliario WHERE idLaboratorio=1";

        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //ConsultaMobiliario
    public function readMobiliarioDesarrollo()
    { //Función para consulta
        $sql = "SELECT * from vwmobiliario WHERE idLaboratorio=2";

        $res = mysqli_query($this->con, $sql);
        return $res;
    }

        //ConsultaMobiliario
        public function readMobiliarioSoporte()
        { //Función para consulta
            $sql = "SELECT * from vwmobiliario WHERE idLaboratorio=3";
    
            $res = mysqli_query($this->con, $sql);
            return $res;
        }

    public function updateMobiliario($idMobiliario)
    {
        $sql3 = "SELECT estado FROM mobiliario where idMobiliario = $idMobiliario";
        $res3 = mysqli_query($this->con, $sql3);
        $return = mysqli_fetch_object($res3);
        if ($return->estado) {
            $sql = "UPDATE mobiliario SET estado='0' where idMobiliario =$idMobiliario";
        } else {
            $sql = "UPDATE mobiliario SET estado='1' where idMobiliario =$idMobiliario";
        }
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    public function single_recordMobiliario($idMobiliario)
    {
        $sql = "SELECT * FROM mobiliario WHERE idMobiliario='$idMobiliario'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function editarMobiliario($numInvMobiliario, $seccionesDeMesa, $descripcion, $idLaboratorio, $idMobiliario)
    {
        $sql = "UPDATE mobiliario SET numInvMobiliario='$numInvMobiliario',idLaboratorio='$idLaboratorio',seccionesDeMesa='$seccionesDeMesa',descripcion='$descripcion' WHERE idMobiliario='$idMobiliario'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    ////////////////////////////////////////////FIN SANABIA////////////////////////////////////////////////////////////////////


    //registrar Horario
    public function createHorarios($idUsuario, $materia, $idGrupo, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, $estado)
    {
        $sql = "INSERT INTO `horarios` (idUsuario, materia, idGrupo, dia, horaEntrada, horaSalida, idLaboratorio, horasPorCuatri, estado)
          VALUES ('$idUsuario', '$materia', '$idGrupo', '$dia', '$horaEntrada', '$horaSalida', '$idLaboratorio', '$horasPorCuatri', '$estado')";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function readHorariosIOT()
    {
        $sql = "SELECT * FROM vwhorarios WHERE idLaboratorio=1";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readHorariosDesarrollo()
    {
        $sql = "SELECT * FROM vwhorarios WHERE idLaboratorio=2";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function readHorariosSoporte()
    {
        $sql = "SELECT * FROM vwhorarios WHERE idLaboratorio=3";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    


    public function updateHorarios($idHorarios)
    {
        $sql = "SELECT * FROM horarios WHERE idHorarios='$idHorarios'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE horarios SET estado=0 WHERE idHorarios='$idHorarios'";
        } else {
            $sql = "UPDATE horarios SET estado=1 WHERE idHorarios='$idHorarios'";
        }

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }



    public function single_recordHorarios($idHorarios)
    {
        $sql = "SELECT * FROM horarios WHERE idHorarios='$idHorarios'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function single_recordHorariosDet($idHorarios)
    {
        $sql = "SELECT * FROM vwhorarios WHERE idHorarios='$idHorarios'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function editarHorarios($idUsuario, $materia, $idGrupo, $dia, $horaEntrada, $horaSalida, $idLaboratorio, $horasPorCuatri, $idHorarios)
    {
        $sql = "UPDATE horarios SET idUsuario='$idUsuario',materia='$materia',idGrupo='$idGrupo',dia='$dia',horaEntrada='$horaEntrada',horaSalida='$horaSalida',idLaboratorio='$idLaboratorio',horasPorCuatri='$horasPorCuatri' WHERE idHorarios='$idHorarios'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePDF($idHorariospdf)
    {
        $sql = "DELETE FROM horariospdf WHERE idHorariospdf = '$idHorariospdf'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////////////////////////////GABI///////////////////////////////////////////////////////////////////////////7//////


    ////////////////////////////////////////////////GABI///////////////////////////////////////////////////////////////////////////7//////





    public function createIncidencia($usuarioRegistra,$idLaboratorio, $idTipoIncidencia, $idEquipo, $descripcion,  $estado, $descripcionIncidencia)
    { //variables
        $sql = "INSERT INTO `incidencia` (usuarioRegistra,idLaboratorio, idTipoIncidencia,idEquipo,descripcion,idUsuario,estado,descripcionIncidencia)  
    VALUES('$usuarioRegistra','$idLaboratorio','$idTipoIncidencia', '$idEquipo','$descripcion',NULL,'$estado','$descripcionIncidencia')";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //ConsultaReporte
    public function readIncidencia()
    { //Función para consulta
        $sql = "SELECT DISTINCT * FROM vwincidencia ";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    //funcion para actualizar INCIDENCIA
    public function updateI($idIncidencia)
    {
        $sql = "SELECT * FROM incidencia WHERE idIncidencia='$idIncidencia'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        if ($return->estado) {
            $sql = "UPDATE incidencia SET estado=1 WHERE idIncidencia='$idIncidencia'";
        } else {
            $sql = "UPDATE incidencia SET estado=1 WHERE idIncidencia='$idIncidencia'";
        }
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    //EDITAR INCIDENCIA
    public function editarIncidencia($idUsuario, $descripcionIncidencia, $idIncidencia)
    {
        $sql = "UPDATE incidencia SET  idUsuario='$idUsuario', descripcionIncidencia='$descripcionIncidencia' WHERE idIncidencia='$idIncidencia'";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //FUNCION PARA EDITAR ENCARGADO RESOLVER (ADMIN)
    public function readAdministradoresI()
    {
        $sql = "SELECT * FROM usuario WHERE idTipoUsuario = '1' AND uActivo = '1'";     //nombre tabla, es la misma q en el insert intoooo

        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //ESCOGER NUMERO DE SERIE DE EQUIPO
    public function readEquipos()
    {
        $sql = "SELECT * from Equipo WHERE estado = '1'";     //nombre tabla, es la misma q en el insert intoooo

        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Cambiar encargado
    public function single_recordIncidencia($idIncidencia)
    {
        $sql = "SELECT * FROM incidencia WHERE idIncidencia='$idIncidencia'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }
    public function deleteI($idIncidencia)
    {
        $sql = "DELETE FROM incidencia WHERE idIncidencia = '$idIncidencia'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function readDescripcion($descripcionIncidencia, $idIncidencia)
    {
        $sql = "SELECT * from incidencia WHERE descripcionIncidencia = '$descripcionIncidencia', idIncidencia = '$idIncidencia' ";     //nombre tabla, es la misma q en el insert intoooo

        $res = mysqli_query($this->con, $sql);
        return $res;
    }





    ////////////SOLICITUDES ACCESO


    public function createSolicitud($maestro, $idLaboratorio, $idGrupo, $materia, $fecha, $fechaSalida, $horaEntrada, $horaSalida, $estado, $estadoLaboratorio, $razon)
    { //variables

        $sql = "INSERT INTO `solicitudacceso` (maestro,idLaboratorio,idGrupo,materia,fecha,fechaSalida,horaEntrada,horaSalida,estado,estadoLaboratorio,razon)  
VALUES('$maestro','$idLaboratorio','$idGrupo','$materia','$fecha','$fechaSalida','$horaEntrada','$horaSalida','$estado','$estadoLaboratorio','$razon') ";


        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //Consulta TABLA SOLICITUDES
    public function readSolicitud()
    { //Función para consulta
        $sql = "SELECT * from vwsolicitud";

        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Funcion para listar opciones de grupos
    public function readGrupos()
    {
        $sql = "SELECT *FROM grupo WHERE estado = '1'";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    //Funcion para listar opciones de grupos
    public function readLaboratorioS()
    {
        $sql = "SELECT * FROM laboratorio WHERE estado= '1'";

        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    //funcion para actualizar SOLICITUD
    public function updateS($idSolicitudAcceso)
    {
        $sql = "UPDATE `solicitudacceso` SET `estado` = '1' WHERE `idSolicitudAcceso` = $idSolicitudAcceso";

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateSL($idSolicitudAcceso)
    {
        $sql = "UPDATE `solicitudacceso` SET `estadoLaboratorio` = '1' WHERE `idSolicitudAcceso` = $idSolicitudAcceso";

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    //EDITAR Solicitud
   

    public function editarRazon($razon, $idSolicitudAcceso)
    {
        $sql = "UPDATE solicitudacceso SET `razon`='$razon',`estado` = '0' WHERE idSolicitudAcceso='$idSolicitudAcceso';";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function single_recordSolicitud($idSolicitudAcceso)
    {
        $sql = "SELECT * FROM solicitudacceso WHERE idSolicitudAcceso='$idSolicitudAcceso'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }

    public function deleteS($idSolicitudAcceso)
    {
        $sql = "DELETE FROM solicitudAcceso WHERE idSolicitudAcceso = '$idSolicitudAcceso'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    public function PDFReadIOT()
    {
        $sql = "SELECT * FROM horariospdf WHERE nombrepdf='Laboratorio de IoT'";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function PDFReadSoporte()
    {
        $sql = "SELECT * FROM horariospdf WHERE nombrepdf='Laboratorio de soporte'";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    public function PDFReadDesarrollo()
    {
        $sql = "SELECT * FROM horariospdf WHERE nombrepdf='Laboratorio de desarrollo'";
        $res = mysqli_query($this->con, $sql);
        return $res;
    }

    /////////////////////////////////////////////////7CAMBIO DE EQUIPO

    public function updateSE($idsolicitudCambioE)
    {
        $sql = "UPDATE `solicitudcambioe` SET `estado` = '1' WHERE `idsolicitudCambioE` = $idsolicitudCambioE";

        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function single_recordSolicitudE($idsolicitudCambioE)
    {
        $sql = "SELECT * FROM solicitudcambioe WHERE idsolicitudCambioE='$idsolicitudCambioE'";
        $res = mysqli_query($this->con, $sql);
        $return = mysqli_fetch_object($res);
        return $return;
    }
    public function readSolicitudEquipo()
    { //Función para consulta
        $sql = "SELECT * from vwsolicitudequipo";

        $res = mysqli_query($this->con, $sql);
        return $res;
    }
    public function deleteSE($idsolicitudCambioE)
    {
        $sql = "DELETE FROM solicitudcambioe WHERE idsolicitudCambioE = '$idsolicitudCambioE'";
        $res = mysqli_query($this->con, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }


    public function editarRazonE($respuesta, $idsolicitudCambioE)
    {
        $sql = "UPDATE solicitudcambioe SET  respuesta='$respuesta',`estado` = '0' WHERE idsolicitudCambioE='$idsolicitudCambioE'";
        $res = mysqli_query($this->con, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }


}