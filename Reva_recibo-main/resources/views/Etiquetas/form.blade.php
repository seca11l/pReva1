<div class="container mt-5">
    <form class="formulario-estilos row g-3" id="etiquetaForm" method="POST" action="{{ route('etiqueta.store') }}">
        @csrf

        <!-- Número de recibo y SKU -->
        <div class="form-group row g-2">
            <div class="form-group col-md-6">
                <label for="inputOrderNum">Número de recibo</label>
                <select class="form-control" name="order_num" id="inputOrderNum" required>
                    <option disabled selected value="">Selecciona un recibo</option>
                    @foreach ($recibos as $recibo)
                        <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputSku">Sku</label>
                <select class="form-control" name="sku" id="inputSku" required>
                    <option value="" disabled selected>Seleccionar código del producto</option>
                    <!-- Opciones del SKU se llenarán dinámicamente mediante JavaScript -->
                </select>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-6">
            <label for="inputDescripcion" class="form-label">Descripción</label>
            <select class="form-control" id="inputDescripcion" name="description" disabled required>
                <option value="" selected>Selecciona un SKU primero</option>
            </select>
            <div id="descripcionError" class="text-danger"></div>
            <input type="hidden" name="hidden_description" id="hiddenDescripcion" required>
        </div>

        <!-- Código de barras -->
        <div class="col-md-6">
            <label for="inputBarcode" class="form-label">Código de Barras</label>
            <input type="text" class="form-control" id="inputBarcode" name="barcode" readonly required>
            <div id="barcodeError" class="text-danger"></div>
            <input type="hidden" name="hidden_barcode" id="hiddenBarcode" required>
        </div>

        <!-- Este div mostrará la fecha de entrega -->
        <div class="col-md-6">
            <label for="inputDeliveryDate" class="form-label">Fecha de Entrega</label>
            <input type="date" class="form-control" id="inputDeliveryDate" name="delivery_date" readonly>
            <!-- Campo oculto para almacenar la fecha -->
            <input type="hidden" name="hidden_delivery_date" id="hiddenDelivery_date" required>
        </div>

        <!-- Este div mostrará el código de cliente -->
        <div class="col-md-6">
            <label for="inputCustomer" class="form-label">Cliente</label>
            <input type="text" class="form-control" id="inputCustomer" name="customer" readonly>
            <!-- Campo oculto para almacenar codigo del cliente -->
            <input type="hidden" name="hidden_customer" id="hiddenustomer" required>
        </div>

        <!-- Amount, Peso, Tipo de producto, Contenido, Estado del producto, Color -->
        <div class="col-md-4">
            <label for="inputamount" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="inputamount" name="amount">
            <div id="amountError" class="text-danger"></div>
        </div>

        <div class="col-md-4">
            <label for="inputweight" class="form-label">Peso</label>
            <input type="number" step="any" class="form-control" id="inputweight" name="weight">
            <div id="weightError" class="text-danger"></div>
        </div>

        <div class="col-md-4">
            <label for="inputtype" class="form-label">Tipo de producto</label>
            <select class="form-control" name="type" id="inputtype" required>
                <option value="" disabled selected>Seleccionar tipo de producto</option>
                <option value="rigido_P">Rigido P</option>
                <option value="rigido_G">Rigido G</option>
                <option value="flexible_P">Flexible P</option>
                <option value="flexible_G">Flexible G</option>
                <option value="No_aplica">No aplica</option>
            </select>
            <div id="typeError" class="text-danger"></div>
        </div>

        <div class="col-md-4">
            <label for="inputcontent" class="form-label">Contenido</label>
            <select class="form-control" name="content" id="inputcontent" required>
                <option value="" disabled selected>Seleccionar contenido</option>
                <option value="aderezos">Aderezos</option>
                <option value="limpieza">Limpieza</option>
                <option value="No_aplica">No aplica</option>
            </select>
            <div id="contentError" class="text-danger"></div>
        </div>

        <div class="col-md-4">
            <label for="inputproduct_status" class="form-label">Estado del producto</label>
            <select class="form-control" name="product_status" id="inputproduct_status" required>
                <option value="" disabled selected>Seleccionar estado del producto</option>
                <option value="sucio">Sucio</option>
                <option value="limpio">Limpio</option>
                <option value="No_aplica">No aplica</option>
            </select>
            <div id="productStatusError" class="text-danger"></div>
        </div>

        <div class="col-md-4">
            <label for="inputcolor" class="form-label">Color</label>
            <select class="form-control" name="color" id="inputcolor" required>
                <option value="" disabled selected>Seleccionar color</option>
                <option value="colores">Colores</option>
                <option value="neutro">Neutro</option>
                <option value="No_aplica">No aplica</option>
            </select>
            <div id="colorError" class="text-danger"></div>
        </div>

        <!-- Botones -->
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>

<!-- Script JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Evento para el cambio en el número de recibo
        $('#inputOrderNum').on('change', function() {
            var orderNum = $(this).val();

            // Realizar solicitud AJAX para obtener información de recibo
            $.ajax({
                url: '{{ route('obtenerInfoReciboetiquetas') }}',
                method: 'POST',
                data: {
                    order_num: orderNum,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Rellenar los campos de delivery_date y customer
                        $('#inputDeliveryDate').val(response.data.delivery_date);
                        $('#inputCustomer').val(response.data.customer);
                    } else {
                        // Manejar el caso en que no se encontró la información del recibo
                        alert('No se pudo obtener la información del recibo.');
                    }
                },
                error: function() {
                    // Manejar el error si es necesario
                    alert('Error al realizar la solicitud.');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Almacena las opciones originales del campo SKU y Cliente
        var originalSkuOptions = $('#inputSku').html();
        var originalCustomerOptions = $('#inputCustomer').html();

        // Maneja el cambio en el campo Número de recibo
        $('#inputOrderNum').on('change', function() {
            var selectedOrderNum = $(this).val();

            // Realiza una solicitud Ajax para obtener los SKUs y los Clientes relacionados con el número de recibo seleccionado
            $.ajax({
                url: '{{ route('etiqueta.obtener-skus-y-customer') }}',
                type: 'GET',
                data: {
                    orderNum: selectedOrderNum
                },
                success: function(data) {
                    // Limpia y llena el select de SKU con las opciones obtenidas
                    $('#inputSku').empty();
                    $('#inputSku').append(
                        '<option value="" disabled selected>Seleccionar código del producto</option>'
                    );
                    $.each(data.skus, function(key, value) {
                        $('#inputSku').append('<option value="' + value + '">' +
                            value + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud Ajax (obtener-skus-y-customer):",
                        status, error);
                }
            });
        });

        // Evento para la entrada en el campo Cliente
        $('#inputCustomer').on('change', function() {
            // Agrega tu lógica aquí si es necesario
            var customer = $(this).val().trim();
            var selectedOrderNum = $('#inputOrderNum').val();
        });

        // Evento para la entrada en el campo SKU
        $('#inputSku').on('change', function() {
            var sku = $(this).val().trim();
            var selectedOrderNum = $('#inputOrderNum').val();
            var $descripcionSelect = $('#inputDescripcion');
            var $barcodeInput = $('#inputBarcode');

            if (sku !== '') {
                // Obtener el token CSRF
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Solicitud Ajax al controlador para obtener la descripción
                $.ajax({
                    url: '{{ route('etiqueta.obtener-descripcion-por-sku') }}',
                    method: 'POST',
                    data: {
                        sku: sku,
                        _token: csrfToken
                    },
                    success: function(response) {
                        var descripcion = response.descripcion;

                        // Habilitar el select y actualizar opciones
                        $descripcionSelect.prop('disabled', false);
                        $descripcionSelect.html('<option value="' +
                            descripcion +
                            '" selected>' + descripcion + '</option>');

                        // Almacenar la descripción en el campo oculto
                        $('#hiddenDescripcion').val(descripcion);
                    },
                    error: function(xhr, status, error) {
                        console.error(
                            "Error en la solicitud Ajax (obtener-descripcion-por-sku):",
                            status, error);

                        // Manejar el error si es necesario
                        $descripcionSelect.prop('disabled', true).html(
                            '<option value="" selected>Error al obtener la descripción</option>'
                        );
                    }
                });

                // Solicitud Ajax para obtener el código de barras
                $.ajax({
                    url: '{{ route('etiqueta.obtener-barcode-por-sku') }}',
                    method: 'POST',
                    data: {
                        sku: sku,
                        _token: csrfToken
                    },
                    success: function(response) {
                        console.log('Respuesta exitosa:', response);

                        // Asegúrate de acceder a la propiedad correcta del objeto de respuesta
                        var barcodeValue = response.barcode;

                        // Actualizar el valor del campo Barcode
                        $('#inputBarcode').val(barcodeValue);

                        // Restablecer el mensaje de error
                        $('#barcodeError').text('');
                    },
                    error: function(xhr, status, error) {
                        console.error(
                            "Error en la solicitud Ajax (obtener-barcode-por-sku):",
                            status, error);

                        // Log del contenido de la respuesta del servidor
                        console.log(xhr.responseText);

                        // Manejar el error si es necesario
                        $('#inputBarcode').val('');

                        // Mostrar un mensaje de error
                        $('#barcodeError').text(
                            'Error al obtener el código de barras');
                    }
                });
            } else {
                // Si no hay SKU, deshabilitar el select y mostrar un mensaje predeterminado
                $descripcionSelect.prop('disabled', true).html(
                    '<option value="" selected>Selecciona un SKU primero</option>');
            }
        });

        // Botón Limpiar
        $('#etiquetaForm').on('reset', function() {
            // Restablecer el formulario a su estado original
            $('#inputSku').html(originalSkuOptions);
            $('#inputCustomer').html(originalCustomerOptions);

            // Ocultar mensajes de error
            $('.text-danger').text('');

            // Deshabilitar select de descripción y peso neto
            $('#inputDescripcion').prop('disabled', true).html(
                '<option value="" selected>Selecciona un SKU primero</option>');
        });
    });
</script>
