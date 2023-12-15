<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Chincha</title>
    <link href="../../../styles/index.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <section class="p__section-home">
        <div class="login__container-register">
            <header class="home__header">
                <?php
                include '../../database/database.php';

                session_start();
                if (isset($_SESSION['usuario'])) {
                    $usuario = $_SESSION['usuario'];
                    echo '<h2 class="home__title">Bienvenido, ' . $usuario['Nombre'] . '</h2>';
                    echo '<label class="dropdown">
                    <div class="dd-button">
                    <img src="' . $usuario['RutaFoto'] . '" alt="" class="home__imgUser">
                    </div>
                    <input type="checkbox" class="dd-input" id="test">
                    <ul class="dd-menu">
                        <li><a href="../Profile/profile.php">Actualizar Perfil</a></li>
                        <li><a href="../Logout/logout.php">Cerrar Sesión</a></li>
                    </ul>
                    </label>';
                } else {
                    // Si la sesión no está iniciada, redirigir a la página de login
                    header("Location: ../../../index.php");
                    exit();
                }
                ?>
            </header>
            <section class="home__gridOptions">
                <a class="home__Options" onclick="toggleActive(this, 'Robo')"><img src="../../../assets/robo.png"
                        alt="Robo" class="home__OptionsImage"><span>Robo</span></a>
                <a class="home__Options" onclick="toggleActive(this,'Incendio')"><img
                        src="../../../assets/extintor-de-incendios.png" alt="Incendios"
                        class="home__OptionsImage"><span>Incendio</span></a>
                <a class="home__Options" onclick="toggleActive(this,'Accidente')"><img
                        src="../../../assets/accidente-de-auto.png" alt="Accidente de Tránsito"
                        class="home__OptionsImage"><span>Accidente <br> de
                        Tránsito</span></a>
                <a class="home__Options" onclick="toggleActive(this,'Emergencia')"><img
                        src="../../../assets/paciente.png" alt="Emergencias" class="home__OptionsImage"><span>Otras <br>
                        Emergencias</span></a>
            </section>
            <footer class="home__footer">
                <span>Tiempo Restante: <span id="tiempo-restante">4:00</span></span>
            </footer>
            <div class="modal" id="myModal">
                <div class="modal-content">
                    <a class="close-btn" onclick="closeModal()"><i class="bi bi-x"></i></a>
                    <form method="post">
                        <input type="text" name="tipo" class="modal__input" id="btnSeleccionado" value="">
                        <span class="modal__subtitle">¿Estas seguro de enviar la alerta?</span>
                        <button type="submit" class="login__button">Confirmar</button>
                    </form>
                    <?php
                    include '../../database/database.php';

                    $tipo = '';

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

                        $fechaActual = date("Y-m-d H:i:s");
                        $fechaActualPeru = date("Y-m-d H:i:s", strtotime("$fechaActualUTC -6 hours"));

                        if (isset($_SESSION['usuario'])) {
                            $usuario = $_SESSION['usuario'];
                            $usuario['IdUsuario'];
                            $user = $usuario['IdUsuario'];
                        }

                        if ($conexion) {
                            $consulta = $conexion->query("INSERT INTO Alertas (Fecha,IdUsuario,TipoAlerta) VALUES ('$fechaActualPeru','$user','$tipo') ");
                            $conexion->close();
                        }
                    }
                    ?>
                </div>
            </div>
            <!--             <script src="../../scripts/timer.js"></script>
 -->
            <script>
                iniciarCuentaAtras(240);
            </script>
            <script src="../../scripts/modal.js"></script>
            <script src="../../scripts/dropdown.js"></script>
        </div>
    </section>

</body>

</html>