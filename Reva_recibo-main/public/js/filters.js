// filters.js

$(document).ready(function () {
    $('#filtroOrden, #filtroCodigoProducto, #filtroFecha').on('input', function () {
        aplicarFiltros();
    });
});

function aplicarFiltros() {
    var filtroOrden = $("#filtroOrden").val().toLowerCase();
    var filtroCodigoProducto = $("#filtroCodigoProducto").val().toLowerCase();
    var filtroFecha = $("#filtroFecha").val();

    // Filtrar la tabla según los valores ingresados
    $("#etiquetaTableBody tr").each(function () {
        var fila = $(this);
        var numeroOrden = fila.find("td:eq(0)").text().toLowerCase();
        var codigoProducto = fila.find("td:eq(1)").text().toLowerCase();
        var fecha = fila.find("td:eq(3)").text(); // Ajusta el índice según la posición real de la fecha en tus datos

        if ((filtroOrden !== "" && numeroOrden.indexOf(filtroOrden) === -1) ||
            (filtroCodigoProducto !== "" && codigoProducto.indexOf(filtroCodigoProducto) === -1) ||
            (filtroFecha !== "" && fecha !== filtroFecha)) {
            fila.hide();
        } else {
            fila.show();
        }
    });
}

function limpiarFiltros() {
    // Limpiar los valores de los campos de filtro
    $("#filtroOrden, #filtroCodigoProducto, #filtroFecha").val('');

    // Mostrar todas las filas nuevamente
    $("#etiquetaTableBody tr").show();
}
