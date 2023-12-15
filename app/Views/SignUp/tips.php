<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    header("Location: ../Home/Home.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Chincha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="../../../styles/index.css" rel="stylesheet" />
</head>

<body>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="slide__container">
                    <img src="../../../assets/policias.png" class="slide__image" alt="Policias">
                    <h3>Bienvenido a Alerta Chincha</h3>
                    <p class="slide__text">Tu seguridad es nuestra prioridad. Alerta Chincha te ofrece una solución
                        rápida y eficiente para
                        reportar emergencias.</p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide__container">
                    <img src="../../../assets/policias.png" class="slide__image" alt="Policias">
                    <p class="slide__text">Con Alerta Chincha, puedes reportar emergencias con solo unos pocos
                        toques. Desde robos hasta accidentes automovilísticos, nuestra aplicación simplifica el proceso
                        de alerta.</p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="slide__container">
                    <img src="../../../assets/policias.png" class="slide__image" alt="Policias">
                    <p class="slide__text">Únete a nuestra comunidad de usuarios comprometidos con la seguridad y
                        contribuye a construir un entorno más seguro para todos</p>
                    <br>
                    <form action="" method="post">
                        <button type="submit" class="login__button">Siguiente</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../../scripts/swiper.js"></script>
</body>

</html>