$(document).ready(function () {
    // Agregar evento para hacer clic en las flechas de paginación
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        // Obtener la URL de la página siguiente/anterior
        var url = $(this).attr('href');

        // Realizar la solicitud AJAX
        $.ajax({
            url: url,
            success: function (data) {
                // Log para verificar si los datos se están recuperando correctamente
                console.log(data);

                // Actualizar el contenido de la tabla con los resultados paginados
                $('#etiquetaTableBody').html(data);

                // Ajustar el tamaño de las flechas de paginación después de la carga
                adjustPaginationArrows();
            },
            error: function (xhr, status, error) {
                // Log de errores para ayudar a identificar problemas
                console.error(xhr.responseText);
            }
        });
    });

    // Ajustar el tamaño de las flechas de paginación al cargar la página
    adjustPaginationArrows();
});

// Función para ajustar el tamaño de las flechas de paginación
function adjustPaginationArrows() {
    // Establecer el tamaño deseado para las flechas
    var arrowSize = '1rem'; // Puedes ajustar este valor según tus preferencias

    // Aplicar el tamaño a las flechas de paginación
    $('.pagination li a').css('font-size', arrowSize);
}
