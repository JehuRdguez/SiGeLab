DROP DATABASE IF EXISTS SiGeLab;
CREATE DATABASE SiGeLab;
USE SiGeLab;

CREATE TABLE tipoUsuario(
idTipoUsuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY  NOT NULL,
tipoUsuario varchar(30)  NOT NULL
);

CREATE TABLE  usuario(
idUsuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
nombreC VARCHAR (100) NOT  NULL UNIQUE,
correo VARCHAR (100) NOT NULL UNIQUE,
telefono VARCHAR (10) UNIQUE,
contrasena  VARCHAR (40)NOT NULL,
uActivo BOOLEAN,
idTipoUsuario INT  UNSIGNED  NOT NULL,
FOREIGN KEY(idTipoUsuario) REFERENCES tipoUsuario(idTipoUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE  contrasenaDescifrada(
idContra INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUsuario INT UNSIGNED NOT NULL,
contrasena  VARCHAR (30)NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE grupo (
idGrupo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY  NOT NULL,
nombreGrupo varchar(10)  NOT NULL UNIQUE,
cantidadAlumnos INT UNSIGNED  NOT NULL,
idUsuario INT UNSIGNED NOT NULL UNIQUE,
estado BOOLEAN NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
); 
 
CREATE TABLE administrador(
numConAdmin INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idUsuario INT UNSIGNED NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE INDEX IDX_UsuarioNombre ON usuario (nombreC);

CREATE TABLE  laboratorio (
idLaboratorio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
nombreLaboratorio VARCHAR (100) NOT NULL,
capacidad INT (11) UNSIGNED NOT NULL,
estado BOOLEAN NOT NULL,
idUsuario INT UNSIGNED NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);


CREATE INDEX IDX_laboratorioNombre ON laboratorio (nombreLaboratorio);

CREATE TABLE maestro(
numConMaes INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idUsuario INT UNSIGNED NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);
 

CREATE TABLE mobiliario (
idMobiliario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
numInvMobiliario INT UNSIGNED NOT NULL,
seccionesDeMesa VARCHAR (100),
descripcion VARCHAR (100) NOT NULL,
estado BOOLEAN NOT NULL,
idLaboratorio INT UNSIGNED,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE
);
 
 
CREATE TABLE solicitudAcceso (
idSolicitudAcceso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idGrupo INT UNSIGNED NOT NULL,
fecha date NOT NULL,
fechaSalida date NOT NULL,
horaEntrada TIME NOT NULL,
horaSalida TIME NOT NULL,
estado INT NOT NULL,
maestro VARCHAR (100) NOT NULL,
idLaboratorio INT UNSIGNED NOT NULL,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idGrupo) REFERENCES grupo(idGrupo)
ON DELETE CASCADE
ON UPDATE CASCADE
);

ALTER TABLE `solicitudacceso` ADD `estadoLaboratorio` BOOLEAN NOT NULL AFTER `idLaboratorio`;
ALTER TABLE `solicitudacceso` ADD `razon` VARCHAR(200) NULL AFTER `estadoLaboratorio`;
ALTER TABLE `solicitudacceso` ADD `materia` VARCHAR(50) NOT NULL AFTER `idGrupo`;

CREATE TABLE solicitudCambioE (
idsolicitudCambioE INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idGrupo VARCHAR(20) NOT NULL,
estado INT NOT NULL,
fecha datetime NOT NULL,
alumno VARCHAR (100) NOT NULL,
razon VARCHAR(200) NOT NULL,
idLaboratorio INT UNSIGNED NOT NULL,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE,
respuesta varchar(200)
);

ALTER TABLE `solicitudcambioe` CHANGE `fecha` `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

CREATE VIEW vwsolicitudequipo AS
SELECT `solicitudcambioe`.`idsolicitudCambioE`, `solicitudcambioe`.`alumno`, `laboratorio`.`nombreLaboratorio`, `solicitudcambioe`.`idGrupo`, `solicitudcambioe`.`razon`, `solicitudcambioe`.`estado`
FROM `solicitudcambioe` 
	INNER JOIN `laboratorio` ON `solicitudcambioe`.`idLaboratorio` = `laboratorio`.`idLaboratorio`;


INSERT INTO `tipousuario`(`idTipoUsuario`, `tipoUsuario`) VALUES (1,'Administrador'),(2,'Maestro'),(3,'Alumno');

CREATE TABLE tipoPerifericos (
idTipoPerifericos INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
tipoPeriferico VARCHAR (20) NOT NULL
);

INSERT INTO `tipoPerifericos` (`idTipoPerifericos`, `tipoPeriferico`) VALUES (NULL, 'Monitor'), (NULL, 'Teclado'), (NULL, 'Gabinete'), (NULL, 'Mouse');

CREATE TABLE  perifericos (
idPerifericos INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
numInvEscolar INT UNSIGNED NOT NULL UNIQUE,
marca VARCHAR (20) ,
modelo VARCHAR (20),
estado BOOLEAN NOT NULL,
idTipoPerifericos INT UNSIGNED,
FOREIGN KEY(idTipoPerifericos) REFERENCES tipoPerifericos(idTipoPerifericos)
ON DELETE CASCADE
ON UPDATE CASCADE
);
CREATE TABLE  perifericoMonitor(
numSerieMonitor INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idPerifericos INT UNSIGNED,
FOREIGN KEY(idPerifericos) REFERENCES perifericos(idPerifericos)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE  perifericoTeclado(
numSerieTeclado INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idPerifericos INT UNSIGNED,
FOREIGN KEY(idPerifericos) REFERENCES perifericos(idPerifericos)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE  perifericoMouse(
numSerieMouse INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idPerifericos INT UNSIGNED,
FOREIGN KEY(idPerifericos) REFERENCES perifericos(idPerifericos)
ON DELETE CASCADE
ON UPDATE CASCADE
);

INSERT INTO `perifericomonitor` (`numSerieMonitor`, `idPerifericos`) VALUES ('0', NULL);
INSERT INTO `perifericoteclado` (`numSerieTeclado`, `idPerifericos`) VALUES ('0', NULL);
INSERT INTO `perifericomouse` (`numSerieMouse`, `idPerifericos`) VALUES ('0', NULL);




CREATE TABLE equipo (
idEquipo INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idLaboratorio INT UNSIGNED,
numInvEscolar INT NOT NULL UNIQUE,
numSerieEquipo INT UNSIGNED NOT NULL UNIQUE,
numSerieMonitor INT UNSIGNED,
numSerieTeclado INT UNSIGNED,
numSerieMouse INT UNSIGNED,
ubicacionEnMesa VARCHAR(100),
procesador VARCHAR(15),
discoDuro VARCHAR(15),
ram VARCHAR(15),
estado BOOLEAN NOT NULL,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(numSerieMonitor) REFERENCES perifericoMonitor(numSerieMonitor)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(numSerieTeclado) REFERENCES perifericoTeclado(numSerieTeclado)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(numSerieMouse) REFERENCES perifericoMouse(numSerieMouse)
ON DELETE CASCADE
ON UPDATE CASCADE
);

INSERT INTO `equipo` (`idEquipo`, `idLaboratorio`, `numInvEscolar`, `numSerieEquipo`, `numSerieMonitor`, `numSerieTeclado`, `numSerieMouse`, `ubicacionEnMesa`, `procesador`, `discoDuro`, `ram`, `estado`) VALUES ('1', NULL, '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0');


CREATE INDEX IDX_SerieEquipo ON equipo (numSerieEquipo);
CREATE INDEX IDX_NGrupo ON grupo(nombreGrupo);

CREATE TABLE alumno(
numConAlum INT UNSIGNED PRIMARY KEY NOT NULL UNIQUE,
idUsuario INT UNSIGNED NOT NULL,
idGrupo INT UNSIGNED NOT NULL,
idEquipoIOT INT UNSIGNED,
idEquipoDesarrollo INT UNSIGNED,
idEquipoSoporte INT UNSIGNED,
FOREIGN KEY(idGrupo) REFERENCES grupo(idGrupo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idEquipoIOT) REFERENCES equipo(idEquipo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idEquipoDesarrollo) REFERENCES equipo(idEquipo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idEquipoSoporte) REFERENCES equipo(idEquipo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE horarios (
idHorarios INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
idUsuario INT UNSIGNED NOT NULL,
materia VARCHAR (100) NOT NULL,
idGrupo INT UNSIGNED NOT NULL,
cantidad INT UNSIGNED  NOT NULL,
dia VARCHAR(15) NOT NULL,
horaEntrada VARCHAR(15) NOT NULL,
horaSalida VARCHAR(15) NOT NULL,
idLaboratorio INT UNSIGNED NOT NULL,
horasPorCuatri INT(10) UNSIGNED NOT NULL,
estado BOOLEAN NOT NULL,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idGrupo) REFERENCES grupo(idGrupo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE
);
 

CREATE TABLE tipoIncidencia (
idTipoIncidencia INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
tipoIncidencia VARCHAR (20) NOT NULL
);

INSERT INTO `tipoincidencia` (`idTipoIncidencia`, `tipoIncidencia`) VALUES ('1', 'Actualización'), ('2', 'Falla'), ('3', 'Otro');


CREATE TABLE  incidencia(
idIncidencia INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
usuarioRegistra VARCHAR (100) NOT NULL,
idLaboratorio INT UNSIGNED NOT NULL,
idTipoIncidencia INT UNSIGNED NOT NULL,
idEquipo INT UNSIGNED NOT NULL,
fecha DATE NOT NULL,
descripcion VARCHAR (150) NOT NULL,
idUsuario INT UNSIGNED NOT  NULL,
estado BOOLEAN NOT NULL,
FOREIGN KEY(idLaboratorio) REFERENCES laboratorio(idLaboratorio)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idTipoIncidencia) REFERENCES tipoincidencia (idTipoIncidencia)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idEquipo) REFERENCES equipo(idEquipo)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
ON DELETE CASCADE
ON UPDATE CASCADE
);
ALTER TABLE `incidencia` ADD `descripcionIncidencia` VARCHAR(500) NULL AFTER `estado`;
ALTER TABLE `incidencia` CHANGE `fecha` `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;


INSERT INTO `usuario` (`idUsuario`, `nombreC`, `correo`, `telefono`, `contrasena`, `uActivo`, `idTipoUsuario`) VALUES ('0', 'Pendiente', '0', '0', '0', '0', '1');
UPDATE `usuario` SET `idUsuario` = '0' WHERE `usuario`.`idUsuario` = 1;

CREATE TABLE horariospdf (
idHorariospdf int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
nombrepdf varchar(255) NOT NULL,
url varchar(200) NOT NULL
);




CREATE VIEW VWLOGIN AS
SELECT `usuario`.`idUsuario`, `usuario`.`nombreC`, `usuario`.`correo`, `usuario`.`contrasena`, `usuario`.`idTipoUsuario` 
FROM `usuario` where uActivo=1 ;

CREATE VIEW vwequipo AS
SELECT `equipo`.`idEquipo`,`laboratorio`.`nombreLaboratorio`, `equipo`.`numInvEscolar`, `equipo`.`numSerieEquipo`, `equipo`.`numSerieMonitor`, `equipo`.`numSerieTeclado`, `equipo`.`numSerieMouse`, `equipo`.`ubicacionEnMesa`, `equipo`.`procesador`, `equipo`.`discoDuro`, `equipo`.`ram`, `equipo`.`estado`
FROM `laboratorio` 
	INNER JOIN `equipo` ON `equipo`.`idLaboratorio` = `laboratorio`.`idLaboratorio`;


CREATE VIEW vwmonitor AS
SELECT `perifericos`.`idPerifericos`,`perifericos`.`numInvEscolar`, `perifericomonitor`.`numSerieMonitor`, `perifericos`.`marca`, `perifericos`.`modelo`, `perifericos`.`estado`
FROM `perifericos` 
	INNER JOIN `perifericomonitor` ON `perifericomonitor`.`idPerifericos` = `perifericos`.`idPerifericos`;

CREATE VIEW vwmonitorA AS
SELECT * FROM vwmonitor
WHERE estado=1;

CREATE VIEW vwteclado AS
SELECT `perifericos`.`idPerifericos`,`perifericos`.`numInvEscolar`, `perifericoteclado`.`numSerieTeclado`, `perifericos`.`marca`, `perifericos`.`modelo`, `perifericos`.`estado`
FROM `perifericos` 
	INNER JOIN `perifericoteclado` ON `perifericoteclado`.`idPerifericos` = `perifericos`.`idPerifericos`;

CREATE VIEW vwtecladoA AS
SELECT * FROM vwteclado
WHERE estado=1;

CREATE VIEW vwmouse AS
SELECT `perifericos`.`idPerifericos`,`perifericos`.`numInvEscolar`, `perifericomouse`.`numSerieMouse`, `perifericos`.`marca`, `perifericos`.`modelo`, `perifericos`.`estado`
FROM `perifericos` 
	INNER JOIN `perifericomouse` ON `perifericomouse`.`idPerifericos` = `perifericos`.`idPerifericos`;

CREATE VIEW vwmouseA AS
SELECT * FROM vwmouse
WHERE estado=1;

CREATE VIEW vwEditAlumno AS
SELECT `usuario`.*, `alumno`.`numConAlum`, `alumno`.`idGrupo`, `alumno`.`idEquipoIOT`, `alumno`.`idEquipoDesarrollo`, `alumno`.`idEquipoSoporte`
FROM `usuario` 
	INNER JOIN `alumno` ON `alumno`.`idUsuario` = `usuario`.`idUsuario`;

CREATE VIEW vwlaboratorio AS
SELECT `laboratorio`.`idLaboratorio`, `laboratorio`.`nombreLaboratorio`, `usuario`.`nombreC`, `laboratorio`.`capacidad`, `laboratorio`.`estado`
FROM `laboratorio` 
	INNER JOIN `usuario` ON `laboratorio`.`idUsuario` = `usuario`.`idUsuario`;

CREATE VIEW vwlaboratorioA AS
SELECT * FROM vwlaboratorio
WHERE estado=1;

CREATE VIEW vwMobiliario AS

SELECT `mobiliario`.`idMobiliario`, `mobiliario`.`numInvMobiliario`, `laboratorio`.`nombreLaboratorio`, `mobiliario`.`seccionesDeMesa`, `mobiliario`.`descripcion`, `mobiliario`.`estado`
FROM `mobiliario` 
	INNER JOIN `laboratorio` ON `mobiliario`.`idLaboratorio` = `laboratorio`.`idLaboratorio`;



CREATE VIEW vwUsuarioAdministrador AS
SELECT `usuario`.`idUsuario`, `administrador`.`numConAdmin`, `usuario`.`nombreC`, `usuario`.`correo`, `usuario`.`telefono` , `usuario`.`contrasena` , `usuario`.`uActivo`, `tipousuario`.`tipoUsuario`
FROM `administrador`
            	INNER JOIN `usuario` ON `administrador`.`idUsuario` = `usuario`.`idUsuario`
            	INNER JOIN `tipousuario` ON `usuario`.`idTipoUsuario` = `tipousuario`.`idTipoUsuario`;

CREATE VIEW vwUsuarioAlumno AS
SELECT `usuario`.`idUsuario`,`alumno`.`numConAlum`, `usuario`.`nombreC`, `usuario`.`correo`, `usuario`.`telefono`, `grupo`.`nombreGrupo`, `grupo`.`estado` AS `estadoGrupo`, `usuario`.`contrasena`, 

`equiposIOT`.`numSerieEquipo` AS `equipoIOT`,
`equiposIOT`.`estado` AS `estadoIOT`,
`equiposDesarrollo`.`numSerieEquipo` AS `equipoDesarrollo`,
`equiposDesarrollo`.`estado` AS `estadoDesarrollo`,
`equiposSoporte`.`numSerieEquipo` AS `equipoSoporte`, 
`equiposSoporte`.`estado` AS `estadoSoporte`, 

`tipousuario`.`tipoUsuario`, `usuario`.`uActivo`
FROM `alumno` 
	INNER JOIN `usuario` ON `alumno`.`idUsuario` = `usuario`.`idUsuario` 
    INNER JOIN `tipousuario` ON `usuario`.`idTipoUsuario` = `tipousuario`.`idTipoUsuario`
	INNER JOIN `grupo` ON `alumno`.`idGrupo` = `grupo`.`idGrupo` 
    
    
	INNER JOIN `equipo` AS `equiposIOT` ON `alumno`.`idEquipoIOT` = `equiposIOT`.`idEquipo`
	INNER JOIN `equipo` AS `equiposDesarrollo` ON `alumno`.`idEquipoDesarrollo` = `equiposDesarrollo`.`idEquipo`
	INNER JOIN `equipo` AS `equiposSoporte` ON `alumno`.`idEquipoSoporte` = `equiposSoporte`.`idEquipo` order by nombreGrupo;

CREATE VIEW vwEquiposAsignados AS
SELECT `usuario`.`idUsuario`, `usuario`.`nombreC`,  `grupo`.`nombreGrupo`, `grupo`.`estado` AS `estadoGrupo`, 

`equiposIOT`.`numSerieEquipo` AS `equipoIOT`,
`equiposIOT`.`estado` AS `estadoIOT`,
`equiposDesarrollo`.`numSerieEquipo` AS `equipoDesarrollo`,
`equiposDesarrollo`.`estado` AS `estadoDesarrollo`,
`equiposSoporte`.`numSerieEquipo` AS `equipoSoporte`, 
`equiposSoporte`.`estado` AS `estadoSoporte`

FROM `alumno` 
	INNER JOIN `usuario` ON `alumno`.`idUsuario` = `usuario`.`idUsuario` 
	INNER JOIN `grupo` ON `alumno`.`idGrupo` = `grupo`.`idGrupo` 
    
    
	INNER JOIN `equipo` AS `equiposIOT` ON `alumno`.`idEquipoIOT` = `equiposIOT`.`idEquipo`
	INNER JOIN `equipo` AS `equiposDesarrollo` ON `alumno`.`idEquipoDesarrollo` = `equiposDesarrollo`.`idEquipo`
	INNER JOIN `equipo` AS `equiposSoporte` ON `alumno`.`idEquipoSoporte` = `equiposSoporte`.`idEquipo` where uActivo=1;

CREATE VIEW vwValidaEquipos AS
SELECT `usuario`.`idUsuario`,`alumno`.`numConAlum`, `alumno`.`idGrupo`,  `equiposIOT`.`numSerieEquipo` AS `equipoIOT`, `equiposDesarrollo`.`numSerieEquipo` AS `equipoDesarrollo`, `equiposSoporte`.`numSerieEquipo` AS `equipoSoporte`,  `usuario`.`uActivo`
FROM `alumno` 
	INNER JOIN `usuario` ON `alumno`.`idUsuario` = `usuario`.`idUsuario` 
    INNER JOIN `tipousuario` ON `usuario`.`idTipoUsuario` = `tipousuario`.`idTipoUsuario`
	INNER JOIN `equipo` AS `equiposIOT` ON `alumno`.`idEquipoIOT` = `equiposIOT`.`idEquipo`
	INNER JOIN `equipo` AS `equiposDesarrollo` ON `alumno`.`idEquipoDesarrollo` = `equiposDesarrollo`.`idEquipo`
	INNER JOIN `equipo` AS `equiposSoporte` ON `alumno`.`idEquipoSoporte` = `equiposSoporte`.`idEquipo`
    Where uActivo=1 ;


CREATE VIEW vwGrupos AS
SELECT `grupo`.`idGrupo`, `grupo`.`nombreGrupo`, `grupo`.`cantidadAlumnos`, `usuario`.`nombreC`, `grupo`.`estado`
FROM `grupo` 
	INNER JOIN `usuario` ON `grupo`.`idUsuario` = `usuario`.`idUsuario`;

CREATE VIEW vwUsuarioMaestro AS
SELECT `usuario`.`idUsuario`,`maestro`.`numConMaes`, `usuario`.`nombreC`, `usuario`.`correo`, `usuario`.`telefono` , `usuario`.`contrasena`, `usuario`.`uActivo` , `tipousuario`.`tipoUsuario`
FROM `maestro`
        	  	INNER JOIN `usuario` ON `maestro`.`idUsuario` = `usuario`.`idUsuario`
        	  	INNER JOIN `tipousuario` ON `usuario`.`idTipoUsuario` = `tipousuario`.`idTipoUsuario`;

 CREATE VIEW vwListaGrupos  AS 
SELECT * FROM `grupo` where  estado=1;

 CREATE VIEW vwListaMaestros  AS 
SELECT * FROM `vwUsuarioMaestro` where  uActivo=1;


 CREATE VIEW vwEquiposIOT  AS 
SELECT `equipo`.* FROM `equipo` where idLaboratorio=1 and estado=1;

CREATE VIEW vwEquiposDesarrollo  AS 
SELECT `equipo`.* FROM `equipo` where idLaboratorio=2 and estado=1;

CREATE VIEW vwEquiposSoporte  AS 
SELECT `equipo`.* FROM `equipo` where idLaboratorio=3  and estado=1;



CREATE VIEW vwhorarios AS
SELECT `horarios`.`idHorarios`,`usuario`.`nombreC`, `horarios`.`materia`, `grupo`.`nombreGrupo`, `horarios`.`cantidad`, `horarios`.`dia`, `horarios`.`horaEntrada`, `horarios`.`horaSalida`, `laboratorio`.`nombreLaboratorio`, `horarios`.`horasPorCuatri`, `horarios`.`estado`
FROM `usuario` 
	INNER JOIN `horarios` ON `horarios`.`idUsuario` = `usuario`.`idUsuario` 
	INNER JOIN `grupo` ON `grupo`.`idUsuario` = `usuario`.`idUsuario` 
	INNER JOIN `laboratorio` ON `horarios`.`idLaboratorio` = `laboratorio`.`idLaboratorio`;

CREATE VIEW vwincidencia AS 
SELECT `incidencia`.`idIncidencia`, `incidencia`.`usuarioRegistra`, `laboratorio`.`nombreLaboratorio`, `tipoincidencia`.`tipoIncidencia`, `equipo`.`numSerieEquipo`, `incidencia`.`fecha`, `incidencia`.`descripcion`, `usuario`.`nombreC`, `incidencia`.`estado`
FROM `incidencia` 
	INNER JOIN `laboratorio` ON `incidencia`.`idLaboratorio` = `laboratorio`.`idLaboratorio` 
	INNER JOIN `tipoincidencia` ON `incidencia`.`idTipoIncidencia` = `tipoincidencia`.`idTipoIncidencia` 
	INNER JOIN `equipo` ON `equipo`.`idLaboratorio` = `laboratorio`.`idLaboratorio` 
	INNER JOIN `usuario` ON `incidencia`.`idUsuario` = `usuario`.`idUsuario`;


CREATE VIEW vwadministradora AS
SELECT * FROM vwusuarioadministrador
WHERE uActivo=1;

CREATE VIEW vwsolicitud AS
SELECT  `solicitudacceso`.`idSolicitudAcceso`,`solicitudacceso`.`maestro`, `laboratorio`.`nombreLaboratorio`, `grupo`.`nombreGrupo`, `solicitudacceso`.`fecha`, `solicitudacceso`.`estado`, `solicitudacceso`.`estadoLaboratorio`
FROM `solicitudacceso` 
	INNER  JOIN `laboratorio` ON `solicitudacceso`.`idLaboratorio` = `laboratorio`.`idLaboratorio` 
	INNER JOIN `grupo` ON `solicitudacceso`.`idGrupo` = `grupo`.`idGrupo`;



DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddMonitor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddMonitor` (IN `numInvEscolar` INT,  IN `numSerieMonitor` INT, IN `marca` VARCHAR (20), IN `modelo` VARCHAR(20), IN `estado` BOOLEAN, IN `idTipoPerifericos` INT)   

BEGIN 
INSERT INTO  perifericos( numInvEscolar, marca, modelo, estado, idTipoPerifericos)
VALUES ( numInvEscolar, marca, modelo, estado, idTipoPerifericos);
SELECT MAX(idPerifericos) INTO @idP FROM perifericos;
INSERT INTO perifericomonitor
            	(numSerieMonitor,idPerifericos)
            	VALUES (numSerieMonitor,@idP);
 
 END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddTeclado`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddTeclado` (IN `numInvEscolar` INT,  IN `numSerieTeclado` INT, IN `marca` VARCHAR (20), IN `modelo` VARCHAR(20), IN `estado` BOOLEAN, IN `idTipoPerifericos` INT)   

BEGIN 
INSERT INTO  perifericos( numInvEscolar, marca, modelo, estado, idTipoPerifericos)
VALUES ( numInvEscolar, marca, modelo, estado, idTipoPerifericos);
SELECT MAX(idPerifericos) INTO @idP FROM perifericos;
INSERT INTO perifericoteclado
            	(numSerieTeclado,idPerifericos)
            	VALUES (numSerieTeclado,@idP);
 
 END$$
 

 DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddMouse`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddMouse` (IN `numInvEscolar` INT,  IN `numSerieMouse` INT, IN `marca` VARCHAR (20), IN `modelo` VARCHAR(20), IN `estado` BOOLEAN, IN `idTipoPerifericos` INT)   

BEGIN 
INSERT INTO  perifericos( numInvEscolar, marca, modelo, estado, idTipoPerifericos)
VALUES ( numInvEscolar, marca, modelo, estado, idTipoPerifericos);
SELECT MAX(idPerifericos) INTO @idP FROM perifericos;
INSERT INTO perifericomouse
            	(numSerieMouse,idPerifericos)
            	VALUES (numSerieMouse,@idP);
 
 END$$




 

 
DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddAdministrador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddAdministrador` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR (10), IN `contrasena` VARCHAR(40), IN `idTipoUsuario` INT, IN `uActivo`BOOLEAN, IN `numConAdmin` INT)   BEGIN
 
 
INSERT INTO  usuario(nombreC, correo, telefono,contrasena, uActivo, idTipoUsuario )
VALUES (nombreC, correo, telefono,md5( contrasena),uActivo, idTipoUsuario );

SELECT MAX(idUsuario) INTO @idA FROM usuario;

INSERT INTO contrasenaDescifrada(idUsuario, contrasena)
VALUES (@idA,contrasena);

INSERT INTO administrador
            	(numConAdmin,idUsuario)
            	VALUES (numConAdmin,@idA);
 
            	END$$

 

 

  
 
DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddMaestro`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddMaestro` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR (10), IN `contrasena` VARCHAR(40), IN `idTipoUsuario` INT,IN `uActivo` BOOLEAN, IN `numConMaes` INT)   BEGIN
 
 
INSERT INTO  usuario( nombreC, correo, telefono, contrasena, uActivo,idTipoUsuario)
VALUES ( nombreC, correo, telefono, md5( contrasena), uActivo, idTipoUsuario);
 
SELECT MAX(idUsuario) INTO @idA FROM usuario;
 INSERT INTO contrasenaDescifrada(idUsuario, contrasena)
VALUES (@idA,contrasena);

INSERT INTO maestro
            	(numConMaes,idUsuario)
            	VALUES (numConMaes,@idA);
 
            	END$$
 
 

DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddAlumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddAlumno` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR (10), IN `contrasena` VARCHAR(40), IN `idTipoUsuario` INT,IN `uActivo`BOOLEAN, IN `numConAlum` INT, IN `idGrupo` INT,  IN  `idEquipoIOT` INT,  IN `idEquipoDesarrollo` INT,  IN `idEquipoSoporte` INT)   BEGIN

INSERT INTO  usuario( nombreC, correo, telefono,contrasena, uActivo, idTipoUsuario)
VALUES ( nombreC, correo, telefono, md5(contrasena), uActivo, idTipoUsuario);
 
SELECT MAX(idUsuario) INTO @idA FROM usuario;

 INSERT INTO contrasenaDescifrada(idUsuario, contrasena)
VALUES (@idA,contrasena);

INSERT INTO alumno
            	(numConAlum,idUsuario, idGrupo, idEquipoIOT,idEquipoDesarrollo, idEquipoSoporte)
            	VALUES (numConAlum,@idA, idGrupo, idEquipoIOT,idEquipoDesarrollo, idEquipoSoporte);
 
            	END$$
 
 





DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddGrupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddGrupo` (IN `nombreGrupo` VARCHAR(10),  IN `cantidadAlumnos` INT(10), IN `idUsuario` INT, IN `estado` BOOLEAN)   BEGIN
INSERT INTO grupo (nombreGrupo,cantidadAlumnos,idUsuario,estado) 
	VALUES(nombreGrupo,cantidadAlumnos,idUsuario,estado)  ;
 
            	END$$
















DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddLaboratorio`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddLaboratorio` (IN `nombreLaboratorio` VARCHAR(100),  IN `nombreC` VARCHAR(100), IN `capacidad` INT (10),IN `estado` BOOLEAN)   BEGIN
 
 
INSERT INTO  laboratorio( nombreLaboratorio, nombreC, capacidad, estado )
VALUES ( nombreLaboratorio, nombreC, capacidad, estado );
 
            	END$$

DELIMITER $$
DROP PROCEDURE IF EXISTS `proAddMobiliario`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proAddMobiliario` (IN `numSerieMobiliario` INT UNSIGNED,  IN `seccionesDeMesa` VARCHAR(100), IN `descripcion` VARCHAR (100),IN `estado` BOOLEAN)   BEGIN
INSERT INTO  mobiliario( numSerieMobiliario, seccionesDeMesa, descripcion, estado )
VALUES ( numSerieMobiliario, seccionesDeMesa, descripcion, estado );
 
            	END$$

 




DELIMITER $$
DROP PROCEDURE IF EXISTS `proEditMaestro`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proEditMaestro` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR(10), IN `contrasena` VARCHAR(30),IN `numConMaes` INT, IN  `idUsuario` INT)   BEGIN
 
UPDATE  usuario, maestro,contrasenadescifrada  SET usuario.nombreC=nombreC, usuario.correo=correo, usuario.telefono=telefono,usuario.contrasena=md5(contrasena),maestro.numConMaes=numConMaes, contrasenadescifrada.contrasena=contrasena
WHERE usuario.idUsuario=idUsuario and maestro.idUsuario=idUsuario  and contrasenadescifrada.idUsuario=idUsuario; 

 
            	END$$









DELIMITER $$
DROP PROCEDURE IF EXISTS `proEditGrupo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proEditGrupo` (IN `nombreGrupo` VARCHAR(10),  IN `cantidadAlumnos` INT(10), IN `idUsuario` INT)  BEGIN
UPDATE  grupo SET nombreGrupo=nombreGrupo,cantidadAlumnos=cantidadAlumnos,idUsuario=idUsuario WHERE idGrupo=idGrupo; 
 
            	END$$



DELIMITER $$
DROP PROCEDURE IF EXISTS `proEditAdministrador`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proEditAdministrador` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR(10), IN `contrasena` VARCHAR(30),IN `numConAdmin` INT, IN  `idUsuario` INT)   BEGIN
 
UPDATE  usuario, administrador,contrasenadescifrada SET usuario.nombreC=nombreC, usuario.correo=correo, usuario.telefono=telefono, usuario.contrasena=md5(contrasena),  administrador.numConAdmin=numConAdmin, contrasenadescifrada.contrasena=contrasena
WHERE usuario.idUsuario=idUsuario and administrador.idUsuario=idUsuario and contrasenadescifrada.idUsuario=idUsuario; 


            	END$$





 

DELIMITER $$
DROP PROCEDURE IF EXISTS `proEditAlumno`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `proEditAlumno` (IN `nombreC` VARCHAR(100),  IN `correo` VARCHAR(100), IN `telefono` VARCHAR (10), IN `contrasena` VARCHAR(40), IN `numConAlum` INT, IN `idGrupo` INT,  IN  `idEquipoIOT` INT,  IN `idEquipoDesarrollo` INT,  IN `idEquipoSoporte` INT)   BEGIN
 
UPDATE  usuario, alumno,contrasenadescifrada SET usuario.nombreC=nombreC, usuario.correo=correo, usuario.telefono=telefono, usuario.contrasena=md5(contrasena), 
 alumno.numConAlum=numConAlum,
alumno.idGrupo=idGrupo,
   alumno.idEquipoIOT=idEquipoIOT,
    alumno.idEquipoDesarrollo=idEquipoDesarrollo,
    alumno.idEquipoSoporte=idEquipoSoporte, contrasenadescifrada.contrasena=contrasena
WHERE usuario.idUsuario=idUsuario and alumno.idUsuario=idUsuario and contrasenadescifrada.idUsuario=idUsuario; 
            	END$$


