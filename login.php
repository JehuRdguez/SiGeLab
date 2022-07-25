
<?php
$mysqli = new mysqli("localhost", "root", "", "sigelab");
session_start();


if ($_POST) { //va a guardar lo que lleve el método post
    $correo = $_POST['correo']; //$ es para indicar que es variable en php
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuario WHERE correo='$correo' AND uActivo=1";

    $resultado = $mysqli->query($sql);
    $num = $resultado->num_rows;

    if ($num > 0) {
        $row = $resultado->fetch_assoc();
        $contrasena_bd = $row['contrasena'];

        $pass_C = md5($contrasena);

        if ($contrasena_bd == $pass_C) {
            $_SESSION['idUsuario'] = $row['idUsuario']; //
            $_SESSION['nombreC'] = $row['nombreC'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['idTipoUsuario'] = $row['idTipoUsuario'];
            header("Location: modLaboratorios/laboratorios.php"); //si puedes iniciar sesión te manda a esto

        } else {
            echo '<script>alert("Contraseña incorrecta")</script>';
        }
    } //en caso de que no se encuentre el usuario
    else {
        echo '<script>alert("No esta registrado el usuario")</script>';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://kit.fontawesome.com/b96b78234f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/styleindex.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="styles/sigelabicon.png" />
</head>

<body style="background-color:#0C1A30;">
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 mr-1">
            <!-- centrar por todos lados -->
            <div class="col">
                <center>
                    </br><img src="styles/sigelablogo.png" id="imglogin" class="logo-img"></a></br>
                    </br>
                    <h2 style="color: white" id="titsigelab">Sistema de Gestión de Laboratorios
                        </h2><br>
                    <center>
                        <p>
                        </br><img src="styles/logoUTEM1.png" id="logoutem1" class=""></a></br>

            </div>


            <!--APARTADO DERECHA -->

            <div class="col">
                <div class="card" style="width: 26rem;" id="fondoblanco">
                    <!--Marco -->
                    <center>
                        <div class="abs-center">
                            <!--centrar -->
                            </br>
                            </br>
                            <h5 style="color: black" > BIENVENIDO(A) A SIGELAB</h5>
                            <i class="fa-solid fa-circle-user fa-4x"></i>
                            <!--LOGIN -->
                            <form method="POST" action="">
                                <div class="col-sm-6">
                                    <br><label>Correo institucional:</label><br>
                                    <input style="background-color:#ECE9F1;" type="email" name="correo" id="correo" class="form-control" required><br>
                                    <label>Contraseña:</label><br>
                                    <input style="background-color:#ECE9F1;" type="password" name="contrasena" id="contrasena" class="form-control" required> <br>
                                    <button type="submit" class="btn btn-primary">ENTRAR</button>
                                    </br>
                                    </br>

                                </div>
                            </form>
                        </div>
                        <!--APARTADO DERECHA -->
                </div>
            </div>
        </div>
    </div>
</body>




<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</html>