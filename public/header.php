<?php
session_start();
$correo = $_SESSION['correo'];
$nombreC = $_SESSION['nombreC'];
$idTipoUsuario = $_SESSION['idTipoUsuario'];
$idUsuario = $_SESSION['idUsuario'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css">
    <script src="https://kit.fontawesome.com/b96b78234f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>SiGeLab</title>
    <link rel="icon" type="image/png" href="../styles/sigelabicon.png" />
</head>

<body style="background-color: #dfdfdf;">

    <!--Navbar horizontal-->
    <nav class="navbar">
        <div class="container-fluid" id="navbarH">
            <a class="logo" href="#">
                <img src="../styles/sigelablogo.png" class="logo-img"></a>
            <center>
                <h2 class="tituloP"><?php echo $pagNom ?></h2>
            </center>
            <form class="d-flex">
                <div>
                    <button type="button" class="btn btn-outline-light" data-bs-toggle="dropdown"><i class="fa-solid fa-right-from-bracket"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="../cerrar.php">Cerrar sesión</a></li>
                    </ul>
                </div>
                <div class="active"></div>
        </div>
        </form>
        </div>
    </nav>

    <!--Navbar vertical-->
    <?php if ($idTipoUsuario == 1) { ?>
        <div class="navvertical">
            <div class="side-nav">
                <h6 id="bienvenida">Bienvenid@:  </br><?php echo $nombreC ?></h6>
                <ul class="nav-links">
                    <li><a href="../modLaboratorios/laboratorios.php"><i class="fa-solid fa-computer"></i>
                            <p>Laboratorios</p>
                        </a></li>
                    <li><a href="../modUsuarios/usuarioAdministrador.php"><i class="fa-solid fa-users"></i>
                            <p>Usuarios</p>
                        </a></li>
                    <li><a href="../modIncidencias/incidencias.php"><i class="fa-solid fa-file-signature"></i>
                            <p>Incidencias</p>
                        </a></li>
                    <li><a href="../modSolicitudes/solicitudes.php"><i class="fa-solid fa-person-circle-check"></i>
                            <p>Solicitudes</p>
                        </a></li>
                    <div class="active"></div>
                </ul>
                <div class="logoUTEM">
                    <a class="logoUTEM" href="#">
                        <img src="../styles/logoUTEM1.png" class="logoUTEM-img"></a>
                </div>
            </div>
        </div>
    <?php } else if ($idTipoUsuario == 2) { ?>
        <div class="navvertical">
            <div class="side-nav">
            <h6 id="bienvenida">Bienvenid@:  </br><?php echo $nombreC ?></h6>
                <ul class="nav-links">
                    <li><a href="../modLaboratorios/laboratorios.php"><i class="fa-solid fa-calendar"></i>
                            <p>Horarios</p>
                        </a></li>
                    <li><a href="../modSolicitudes/solicitudes.php"><i class="fa-solid fa-person-circle-check"></i>
                            <p>Solicitudes</p>
                        </a></li>
                    <li><a href="../modIncidencias/incidencias.php"><i class="fa-solid fa-file-signature"></i>
                            <p>Incidencias</p>
                        </a></li>
                    <li><a href="../modUsuarios/equiposAsignados.php"><i class="fa-solid fa-computer"></i>
                            <p>Equipos</p>
                        </a></li>
                    <div class="active"></div>
                </ul>
                <div class="logoUTEM">
                    <a class="logoUTEM" href="#">
                        <img src="../styles/logoUTEM1.png" class="logoUTEM-img"></a>
                </div>
            </div>
        </div>
    <?php } else if ($idTipoUsuario == 3) { ?>
        <div class="navvertical">
            <div class="side-navalum">
            <h6 id="bienvenidaalum">Bienvenid@:  </br><?php echo $nombreC ?></h6>
                <ul class="nav-links">
                    <li><a href="../modLaboratorios/laboratorios.php"><i class="fa-solid fa-calendar"></i><p>Horarios</p></a></li>
                    <li><a href="../modIncidencias/incidencias.php"><i class="fa-solid fa-file-signature"></i><p>Incidencias</p></a></li>
                    <li><a href="../modSolicitudes/solicitudEquipo.php"><i class="fa-solid fa-computer"></i><p>Mi equipo</p></a></li>
                    <li style="visibility: hidden;"><a href="#">
                            <p>Null</p>
                        </a></li>
                    <div class="activealum"></div>
                </ul>
                <div class="logoUTEM">
                    <a class="logoUTEM" href="#">
                        <img src="../styles/logoUTEM1.png" class="logoUTEM-imgalum"></a>
                </div>
            </div>
        </div>
    <?php } ?>