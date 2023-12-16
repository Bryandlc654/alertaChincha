<?php
include '../../database/database.php';

$consultaRobos = "SELECT COUNT(*) as totalRobos FROM Alertas WHERE TipoAlerta = 'Robo'";
$resultadoRobos = $conexion->query($consultaRobos);
$datosRobos = $resultadoRobos->fetch_assoc();
$totalRobos = $datosRobos['totalRobos'];

$consultaIncendios = "SELECT COUNT(*) as totalIncendios FROM Alertas WHERE TipoAlerta = 'Incendio'";
$resultadoIncendios = $conexion->query($consultaIncendios);
$datosIncendios = $resultadoIncendios->fetch_assoc();
$totalIncendios = $datosIncendios['totalIncendios'];

$consultaAccidentes = "SELECT COUNT(*) as totalAccidentes FROM Alertas WHERE TipoAlerta = 'Accidente'";
$resultadoAccidentes = $conexion->query($consultaAccidentes);
$datosAccidentes = $resultadoAccidentes->fetch_assoc();
$totalAccidentes = $datosAccidentes['totalAccidentes'];

$consultaOtrasEmergencias = "SELECT COUNT(*) as totalOtrasEmergencias FROM Alertas WHERE TipoAlerta = 'Emergencia'";
$resultadoOtrasEmergencias = $conexion->query($consultaOtrasEmergencias);
$datosOtrasEmergencias = $resultadoOtrasEmergencias->fetch_assoc();
$totalOtrasEmergencias = $datosOtrasEmergencias['totalOtrasEmergencias'];

$consultaTotalAlertas = "SELECT COUNT(*) as totalAlertas FROM Alertas";
$resultadoTotalAlertas = $conexion->query($consultaTotalAlertas);
$datosTotalAlertas = $resultadoTotalAlertas->fetch_assoc();
$totalAlertas = $datosTotalAlertas['totalAlertas'];

$porcentajeRobos = ($totalRobos / $totalAlertas) * 100;
$porcentajeIncendios = ($totalIncendios / $totalAlertas) * 100;
$porcentajeAccidentes = ($totalAccidentes / $totalAlertas) * 100;
$porcentajeOtrasEmergencia = ($totalOtrasEmergencias / $totalAlertas) * 100;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Alerta Chincha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .container__charts {
            width: 22rem!important;
            height: 17rem!important;
            object-fit: contain;
            margin: 0 auto;
        }
        

        @media screen and (min-width:768px) {
            .container__charts {
            width: 40rem!important;
            height: 35rem!important;
            object-fit: contain;
            margin: 0 auto;
        }
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
            <a href="../Home/Home.php"
                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"><i
                    class="bi bi-house-door"></i></a>
        </div>
    </div>

    <div class="">
        <h2 class="mx-10 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"> Total de
            Alertas:
            <?php echo $totalAlertas; ?>
        </h2>
        <div>
            <div>
                <canvas id="myChart" class="container__charts"></canvas>
            </div>
        </div>
        <div class="container__charts">
            <div>
                <canvas class="container__charts" id="myDoughnut"></canvas>
            </div>
            <br>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Robos', 'Incendios', 'Accidentes', 'Otras Emergencias'],
                datasets: [{
                    label: 'N° de Emergencias',
                    data: [<?php echo $totalRobos; ?>, <?php echo $totalIncendios; ?>, <?php echo $totalAccidentes; ?>, <?php echo $totalOtrasEmergencias; ?>],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        const datad = {
            labels: [
                'Robos',
                'Incendios',
                'Accidentes',
                'Otras Emergencias'
            ],
            datasets: [{
                label: 'Porcentaje del Total',
                data: [<?php echo $porcentajeRobos; ?>, <?php echo $porcentajeIncendios; ?>, <?php echo $porcentajeAccidentes; ?>, <?php echo $porcentajeOtrasEmergencia; ?>],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75,192,192)'
                ],
                hoverOffset: 4
            }]
        };

        const doughnut = document.getElementById('myDoughnut');

        new Chart(doughnut, {
            type: 'doughnut',
            data: datad,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '% Por Tipo de alerta'
                    }
                }
            },
        });


    </script>


    <script src="../../scripts/datetime.js"></script>

</body>

</html>