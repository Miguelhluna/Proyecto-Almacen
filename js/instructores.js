function abrirDialog(_deshabilitar) {
    const dialog = document.getElementById(_deshabilitar);
    if (dialog) {
        dialog.showModal();
    }
}

function cerrarDialog(_deshabilitar) {
    const dialog = document.getElementById(_deshabilitar);
    if (dialog) {
        dialog.close();
    }
}
