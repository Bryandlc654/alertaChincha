function toggleActive(element, tipo) {
    element.classList.toggle("active");

    if (element.classList.contains("active")) {
        // Si el elemento está activo, mostrar el modal y actualizar los inputs
        document.getElementById('myModal').style.display = 'flex';
        document.getElementById('btnSeleccionado').value = tipo;
    }
}

function closeModal() {
    // Cerrar el modal y restablecer los valores
    document.getElementById('myModal').style.display = 'none';
    document.getElementById('btnSeleccionado').value = '';
}

