<?php
session_start();
include '../../database/database.php';

$dni = '';
$nombres = '';
$apellidos = '';
$celular = '';
$direccion = '';
$distrito = '';
$provincia = '';
$departamento = '';
$celEmergencia = '';
$foto = '';
$mensaje = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dni = isset($_POST['dni']) ? $_POST['dni'] : '';
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $distrito = isset($_POST['distrito']) ? $_POST['distrito'] : '';
    $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : '';
    $departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';
    $celEmergencia = isset($_POST['celEmergencia']) ? $_POST['celEmergencia'] : '';

    $consultaExisteUsuario = $conexion->query("SELECT COUNT(*) as totalUsuarios FROM Usuarios WHERE Dni = '$dni'");
    $datosExisteUsuario = $consultaExisteUsuario->fetch_assoc();
    $totalUsuarios = $datosExisteUsuario['totalUsuarios'];

    if ($totalUsuarios > 0) {
        echo "<script>alert('Error: El usuario con el DNI ingresado ya existe.')</script>";
    } else {
        // Resto de tu código para procesar la inserción
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $foto_nombre = $_FILES['foto']['name'];
            $foto_extension = strtolower(pathinfo($foto_nombre, PATHINFO_EXTENSION));

            // Array de extensiones permitidas
            $extensiones_permitidas = ['jpg', 'jpeg', 'png'];

            // Verificar la extensión del archivo
            if (in_array($foto_extension, $extensiones_permitidas)) {
                $ruta_destino = '../../../fotos/' . $foto_nombre;

                // Mover el archivo a la carpeta de destino
                move_uploaded_file($foto_tmp, $ruta_destino);

                // Guardar la ruta en la variable $foto para almacenarla en la base de datos
                $foto = $ruta_destino;
            } else {
                $mensaje = 'Error: Solo se permiten archivos en formato jpg, jpeg o png.';
                echo "<script>alert('$mensaje')</script>";
            }
        } else {
            $mensaje = 'Error: No se ha seleccionado ninguna imagen.';
            echo "<script>alert('$mensaje')</script>";
        }

        if ($conexion && empty($mensaje)) {
            $consulta = $conexion->query("INSERT INTO Usuarios (Dni,Nombre,Apellido,Celular,Direccion,Distrito,Provincia,Departamento,CelEmergencia,RutaFoto) VALUES('$dni','$nombres','$apellidos','$celular','$direccion','$distrito','$provincia','$departamento','$celEmergencia','$foto')");
            if ($consulta) {
                echo "<script>alert('Registrado con éxito')</script>";
                $_SESSION['usuario'] = $usuario;
                header("Location: ../../../index.php");
                exit();
            } else {
                echo "<script>alert('Error al registrar.')</script>";
            }
        }
    }
    $conexion->close();
}


?>

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
    <section class="p__section-register ">
        <div class="login__container-register">
            <header class="login__header">
                <a href="../../../index.php" class="login__back"><i class="bi bi-chevron-left"></i></a>
                <h1 class="login__title">Regístrate</h1>
            </header>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" id="dni" name="dni" placeholder="Ingrese DNI de 8 dígitos" pattern="[0-9]{8}"
                    title="Ingrese un DNI válido de 8 dígitos" class="login__input" required>
                <input type="text" id="nombres" name="nombres" placeholder="Nombres" class="login__input" required>
                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" class="login__input"
                    required>
                <input type="text" id="celular" name="celular" placeholder="Celular" class="login__input"
                    pattern="[0-9]{9}" title="Ingrese un Celular válido de 9 dígitos como máximo" required>
                <input type="text" id="direccion" name="direccion" placeholder="Dirección" class="login__input"
                    required>
                <input type="text" id="distrito" name="distrito" placeholder="Distrito" class="login__input" required>
                <input type="text" id="provincia" name="provincia" placeholder="Provincia" class="login__input"
                    required>
                <input type="text" id="departamento" name="departamento" placeholder="Departamento" class="login__input"
                    required>
                <input type="text" id="celemergencia" name="celEmergencia" placeholder="Celular de Emergencia"
                    pattern="[0-9]{9}" title="Ingrese un Celular válido de 9 dígitos como máximo" class="login__input"
                    required>
                <div class="login__input-file">
                    <label for="foto" class="login__labelFile">Foto</label>
                    <input type="file" id="foto" name="foto" required>
                </div>

                <button type="submit" class="login__button">Registrar</button>
            </form>
        </div>
    </section>

</body>

</html>