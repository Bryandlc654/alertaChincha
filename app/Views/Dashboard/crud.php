<?php
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
$flag = '';


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
    $flag = isset($_POST['flag']) ? $_POST['flag'] : '';


    if (isset($_POST['operaciones'])) {
        if ($_POST['operaciones'] == 'Buscar') {
            if ($conexion) {
                $consulta = $conexion->query("SELECT * FROM Usuarios WHERE Dni='$dni'");

                if ($datos = $consulta->fetch_assoc()) {
                    $id = $datos['IdUsuario'];
                    $dni = $datos['Dni'];
                    $nombres = $datos['Nombre'];
                    $apellidos = $datos['Apellido'];
                    $celular = $datos['Celular'];
                    $direccion = $datos['Direccion'];
                    $distrito = $datos['Distrito'];
                    $provincia = $datos['Provincia'];
                    $departamento = $datos['Departamento'];
                    $celEmergencia = $datos['CelEmergencia'];
                    $foto = $datos['RutaFoto'];
                    $flag = $datos['Flag'];
                }
            }
            $conexion->close();
        }
        if ($_POST['operaciones'] == 'Eliminar') {
            if ($conexion) {
                $consulta = $conexion->query("DELETE FROM Usuarios  WHERE Dni='$dni'");
                echo "<script>alert('Usuario Eliminado')</script>";
            }
            $conexion->close();
        }
        if ($_POST['operaciones'] == 'Actualizar') {
            if ($conexion) {
                $consulta = $conexion->query("UPDATE Usuarios SET Dni='$dni',Nombre='$nombres',Apellido='$apellidos',Celular='$celular',Direccion='$direccion',Distrito='$distrito',Provincia='$provincia',Departamento='$departamento',CelEmergencia='$celEmergencia',RutaFoto='$foto',Flag='$flag'  WHERE Dni='$dni'");
                echo "<script>alert('Usuario Actualizado')</script>";
            }
            $conexion->close();
        }
        if ($_POST['operaciones'] == 'Registrar') {
            $consultaExisteUsuario = $conexion->query("SELECT COUNT(*) as totalUsuarios FROM Usuarios WHERE Dni = '$dni'");
            $datosExisteUsuario = $consultaExisteUsuario->fetch_assoc();
            $totalUsuarios = $datosExisteUsuario['totalUsuarios'];
            if ($totalUsuarios > 0) {
                echo "<script>alert('Error: El usuario con el DNI ingresado ya existe.')</script>";
            } else {
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
                if ($conexion) {
                    $consulta = $conexion->query("INSERT INTO Usuarios (Dni,Nombre,Apellido,Celular,Direccion,Distrito,Provincia,Departamento,CelEmergencia,RutaFoto,Flag) VALUES('$dni','$nombres','$apellidos','$celular','$direccion','$distrito','$provincia','$departamento','$celEmergencia','$foto','$flag')");
                    echo "<script>alert('Usuario Registrado')</script>";
                }
            }
            $conexion->close();
        }



    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alerta Chincha</title>
    <link href="../../../styles/index.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <section class="p__section-register ">
        <div class="login__container-register">
            <header class="login__header">
                <a href="./dashboard.php" class="login__back"><i class="bi bi-chevron-left"></i></a>
                <h1 class="login__title">Gestión de usuarios</h1>
                <form action="">
                </form>
                <hr>
            </header>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" id="dni" name="dni" placeholder="Ingrese DNI de 8 dígitos" pattern="[0-9]{8}"
                    title="Ingrese un DNI válido de 8 dígitos" class="login__input" value="<?php echo $dni ?>">
                <input type="text" id="nombres" name="nombres" placeholder="Nombres" class="login__input"
                    value="<?php echo $nombres ?>">
                <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" class="login__input"
                    value="<?php echo $apellidos ?>">
                <input type="text" id="celular" name="celular" placeholder="Celular" class="login__input"
                    pattern="[0-9]{9}" title="Ingrese un Celular válido de 9 dígitos como máximo"
                    value="<?php echo $celular ?>">
                <input type="text" id="direccion" name="direccion" placeholder="Dirección" class="login__input"
                    value="<?php echo $direccion ?>">
                <input type="text" id="distrito" name="distrito" placeholder="Distrito" class="login__input"
                    value="<?php echo $distrito ?>">
                <input type="text" id="provincia" name="provincia" placeholder="Provincia" class="login__input"
                    value="<?php echo $provincia ?>">
                <input type="text" id="departamento" name="departamento" placeholder="Departamento"
                    value="<?php echo $departamento ?>" class="login__input">
                <input type="text" id="celemergencia" name="celEmergencia" placeholder="Celular de Emergencia"
                    value="<?php echo $celEmergencia ?>" pattern="[0-9]{9}"
                    title="Ingrese un Celular válido de 9 dígitos como máximo" class="login__input">
                <div class="login__input-file">
                    <label for="foto" class="login__labelFile">Foto</label>
                    <input type="file" id="foto" name="foto" value="<?php echo $foto ?>">
                </div>
                <input type="text" id="flag" name="flag" placeholder="0 para desactivar / 1 para activar"
                    value="<?php echo $flag ?>" class="login__input">

                <input type="submit" class="login__button" name="operaciones" value="Registrar"></input>
                <input type="submit" class="login__button" name="operaciones" value="Eliminar"></input>
                <input type="submit" class="login__button" name="operaciones" value="Actualizar"></input>
                <input type="submit" class="login__button" name="operaciones" value="Buscar"></input>
            </form>
        </div>
    </section>

</body>

</html>