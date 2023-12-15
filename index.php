<?php
include './app/database/database.php';
session_start();

$dni = '';
$celular = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';

    if ($conexion) {
        $consulta = $conexion->query("SELECT * FROM Usuarios WHERE Dni = '$dni' AND Celular = '$celular'");

        if ($consulta->num_rows > 0) {
            $usuario = $consulta->fetch_assoc();
            session_start();
            $mensaje = 'Bienvenido';
            $_SESSION['usuario'] = $usuario;
            header("Location: ./app/Views/Home/Home.php");
            exit();
        } else {
            $consultaDni = $conexion->query("SELECT * FROM Usuarios WHERE Dni = '$dni'");
            if ($consultaDni->num_rows == 0) {
                header("Location: ./app/Views/SignUp/signup.php");
                exit();
            } else {
                $mensaje = 'Contraseña Incorrecta';
            }
        }
        $conexion->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Chincha</title>
    <link href="./styles/index.css" rel="stylesheet" />
</head>

<body>
    <section class="p__section ">
        <div class="login__container">
            <form action="" method="post">
                <h1 class="login__title">Iniciar Sesión</h1>
                <input type="text" id="dni" name="dni" placeholder="Ingrese DNI de 8 dígitos" pattern="[0-9]{8}"
                    title="Ingrese un DNI válido de 8 dígitos" class="login__input" required>
                <input type="text" id="celular" name="celular" placeholder="Celular" pattern="[0-9]{9}"
                    title="Ingrese un Celular válido de 9 dígitos" class="login__input">
                <span class="login__resetpassword"><a href="#" class="login__resetpassword-text">¿Olvidaste tu
                        Contraseña?</a></span>
                <button type="submit" class="login__button" onclick="toast()">Ingresar</button>
            </form>
            <hr class="login__separator">
            <a href="./app/Views/SignUp/signup.php" class="login__button-light">Regístrate</a>
        </div>
    </section>
    <div id="snackbar">
        <?php echo $mensaje ?>
    </div>

    <div class="splash">
        <section class="splash__background">
            <div class="splash__filter">
                <img src="./assets/logo.png" alt="Logo" class="splash__image">
            </div>
        </section>
    </div>
    <script src="./app/scripts/splashScreen.js"></script>
    <script src="./app/scripts/toast.js"></script>

</body>

</html>