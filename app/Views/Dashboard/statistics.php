<?php
include '../../database/database.php';

$consultaRobos = "SELECT COUNT(*) as totalRobos FROM Alertas WHERE IdTipoEmergencia = '1'";
$resultadoRobos = $conexion->query($consultaRobos);
$datosRobos = $resultadoRobos->fetch_assoc();
$totalRobos = $datosRobos['totalRobos'];

$consultaIncendios = "SELECT COUNT(*) as totalIncendios FROM Alertas WHERE IdTipoEmergencia = '2'";
$resultadoIncendios = $conexion->query($consultaIncendios);
$datosIncendios = $resultadoIncendios->fetch_assoc();
$totalIncendios = $datosIncendios['totalIncendios'];

$consultaAccidentes = "SELECT COUNT(*) as totalAccidentes FROM Alertas WHERE IdTipoEmergencia = '3'";
$resultadoAccidentes = $conexion->query($consultaAccidentes);
$datosAccidentes = $resultadoAccidentes->fetch_assoc();
$totalAccidentes = $datosAccidentes['totalAccidentes'];

$consultaOtrasEmergencias = "SELECT COUNT(*) as totalOtrasEmergencias FROM Alertas WHERE IdTipoEmergencia = '4'";
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