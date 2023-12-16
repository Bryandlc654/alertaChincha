<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alerta Chincha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clifford: '#da373d',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }

    .input_filter{
        width: 10rem;
    }

    .container-filters{
        flex-wrap: wrap;
    }
   
  </style>
</head>

<body>
    <div class="lg:flex lg:items-center lg:justify-between p-10 sm:p-6 ">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Alerta
                Chincha</h2>
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex gap-3">
                        <div class="date">
                            <span id="weekDay" class="weekDay"></span>,
                            <span id="day" class="day"></span> de
                            <span id="month" class="month"></span> del
                            <span id="year" class="year"></span>
                        </div>
                        <div class="clock">
                            <span id="hours" class="hours"></span> :
                            <span id="minutes" class="minutes"></span> :
                            <span id="seconds" class="seconds"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 flex lg:ml-4 lg:mt-0 gap-3 container-filters">
            <form action="" method="post" class="flex gap-3">
                <span>
                    <select name="operaciones"
                        class="input_filter inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <option value="Todos"> Todos</option>
                        <option value="Robos"> Robos</option>
                        <option value="Incendios"> Incendios</option>
                        <option value="Accidentes"> Accidentes</option>
                        <option value="Otras"> Otras Emergencias</option>
                    </select>
                </span>

                <span class="sm:ml-3">
                    <button type="submit" value="Todos" name="operaciones"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Filtrar
                    </button>
                </span>
            </form>
            <form action="" method="post" class="flex gap-3">
                <span>
                    <input type="date" name="date"
                        class="input_filter inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                </span>
                <span>
                    <button type="submit" value="Fecha" name="operaciones"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Filtrar
                    </button>
                </span>
            </form>
            <form action="" method="post" class="flex gap-3">
                <span>
                    <input type="text" name="user" placeholder="Ingresar Dni"
                        class="input_filter inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                </span>
                <span>
                    <button type="submit" value="usuario" name="operaciones"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Filtrar
                    </button>
                </span>
            </form>
            <a href="../Home/Home.php" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"><i class="bi bi-house-door"></i></a>
        </div>
    </div>

    <ul role="list" class="divide-y divide-gray-100 px-12">
        <?php
        include '../../database/database.php';
        $fecha = '';
        $user = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fecha = isset($_POST['date']) ? $_POST['date'] : '';
            $user = isset($_POST['user']) ? $_POST['user'] : '';

            if (!empty($fecha)) {
                // Formatea la fecha al formato deseado (yyyy-mm-dd)
                $fecha = date('Y-m-d', strtotime($fecha));
            }
        }

        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Todos') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario`";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }

        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Robos') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and c.TipoAlerta ='Robo'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }
        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Incendios') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and c.TipoAlerta ='Incendio'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }

        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Accidentes') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and c.TipoAlerta ='Accidente'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }

        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Otras') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and c.TipoAlerta ='Emergencia'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }
        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'Fecha') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and c.Fecha like '$fecha%'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }
        if (isset($_POST['operaciones'])) {
            if ($_POST['operaciones'] == 'usuario') {
                $consulta = "SELECT * FROM Usuarios  AS u, Alertas AS c WHERE 
                c.`IdUsuario`=u.`IdUsuario` and u.Dni='$user'";
                if ($resultado = $conexion->query($consulta)) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo '
                <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="' . $fila['RutaFoto'] . '"
                        alt="">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">' . $fila['Nombre'] . ' ' . $fila['Apellido'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Dni: ' . $fila['Dni'] . '</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">Direccion: ' . $fila['Direccion'] . '</p>
                    </div>
                </div>
                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                    <p class="text-sm leading-6 text-gray-900"> ' . $fila['TipoAlerta'] . '</p>
                    <p class="mt-1 text-xs leading-5 text-gray-500">' . $fila['Fecha'] . '</p>
                </div>
            </li>
                ';
                    }
                } else {
                    echo "Si esta";
                }
            }
        }
        ?>
    </ul>
    <script src="../../scripts/datetime.js"></script>

</body>

</html>