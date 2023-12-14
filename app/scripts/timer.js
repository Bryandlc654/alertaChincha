// Función para formatear el tiempo en minutos y segundos
function formatoTiempo(tiempo) {
    var minutos = Math.floor(tiempo / 60);
    var segundos = tiempo % 60;
    return minutos + ":" + (segundos < 10 ? "0" : "") + segundos;
}

// Función para iniciar la cuenta atrás
function iniciarCuentaAtras(tiempoEnSegundos) {
    var tiempoRestante = tiempoEnSegundos;
    var contador = setInterval(function () {
        tiempoRestante--;
        document.getElementById("tiempo-restante").innerText = formatoTiempo(tiempoRestante);

        // Verificar si el tiempo ha llegado a cero
        if (tiempoRestante <= 0) {
            clearInterval(contador); // Detener el contador
            window.location.href = '../../../index.php'; // Redirigir a login.php
        }
    }, 1000); // Actualizar cada segundo
}