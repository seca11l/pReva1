<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />

<div class="container mt-5">
    <form id="productoForm" method="POST" action="{{ route('productos.store') }}" class="formulario-estilos row g-3">
        @csrf

        <!-- Filtrar Número de recibo -->
        <div class="col-md-6">
            <label for="inputFiltrarOrderNum" class="form-label">Filtrar Número de recibo</label>
            <input type="number" class="form-control" id="inputFiltrarOrderNum" placeholder="Buscar recibo">
        </div>

        <!-- Número de recibo -->
        <div class="col-md-6">
            <label for="inputOrderNum" class="form-label">Número de recibo</label>
            <select class="form-control" name="orden_num" id="inputOrderNum" required>
                <option disabled selected value="">Selecciona un recibo</option>
                @foreach ($recibos as $recibo)
                    <option value="{{ $recibo->order_num }}">{{ $recibo->order_num }}</option>
                @endforeach
            </select>
        </div>

        <!-- Fecha de Entrega -->
        <div class="col-md-6">
            <label for="inputDeliveryDate" class="form-label">Fecha de Entrega</label>
            <input type="date" class="form-control" id="inputDeliveryDate" name="delivery_date" readonly
                max="<?php echo date('Y-m-d'); ?>">
            <input type="hidden" name="hidden_delivery_date" id="hiddenDelivery_date" required>
        </div>

        <!-- Código de Cliente -->
        <div class="col-md-6">
            <label for="inputCodeCustomer" class="form-label">Código de Cliente</label>
            <input type="text" class="form-control" id="inputCodeCustomer" name="code_customer" readonly>
            <input type="hidden" name="hidden_code_customer" id="hiddenCode_customer" required>
        </div>

        <!-- Filtrar Descripción -->
        <div class="col-md-6">
            <label for="inputFiltrarDescripcion" class="form-label">Filtrar Descripción</label>
            <input type="text" class="form-control" id="inputFiltrarDescripcion" placeholder="Buscar Descripción">
        </div>

        <!-- Descripción -->
        <div class="col-md-6">
            <label for="inputDescripcion" class="form-label">Descripción</label>
            <select class="form-control" id="inputDescripcion" name="description" required>
                <option value="" selected>Selecciona una descripción</option>
                @foreach ($descripciones as $descripcion)
                    <option value="{{ $descripcion }}">{{ $descripcion }}</option>
                @endforeach
            </select>
            <div id="descripcionError" class="text-danger"></div>
            <input type="hidden" name="hidden_description" id="hiddenDescripcion" required>
        </div>

        <!-- SKU -->
        <div class="col-md-6">
            <label for="inputSku" class="form-label">SKU</label>
            <input type="text" class="form-control" id="inputSku" name="sku" readonly>
        </div>


        <!-- Criterium -->
        <div class="col-md-6">
            <label for="inputcriterium" class="form-label">Criterium</label>
            <input type="text" class="form-control" id="inputcriterium" name="criterium" required>
            <div id="criteriumError" class="text-danger"></div>
        </div>

        <!-- Notas -->
        <div class="mb-4">
            <label for="notes" class="block text-sm font-medium text-gray-600">Notas:</label>
            <textarea id="notes" name="notes" class="form-input"></textarea>
        </div>

        <!-- Unidad de medida básica -->
        <div class="col-md-6">
            <label for="inputumb" class="form-label">Unidad de medida básica</label>
            <input type="text" class="form-control" id="inputumb" name="unit_measurement" required>
            <div id="umbError" class="text-danger"></div>
        </div>

        <!-- Cantidad -->
        <div class="col-md-6">
            <label for="inputcantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="inputcantidad" name="amount" required>
            <div id="cantidadError" class="text-danger"></div>
        </div>

        <!-- Peso Bruto -->
        <div class="col-md-4">
            <label for="inputbruto" class="form-label">Peso Bruto</label>
            <input type="number" step="any" class="form-control" id="inputbruto" name="gross_weight"
                oninput="actualizarPesoNeto()" required>
            <div id="brutoError" class="text-danger"></div>
        </div>

        <!-- Peso de empaque -->
        <div class="col-md-4">
            <label for="inputEmpaque" class="form-label">Peso de empaque</label>
            <input type="number" step="any" class="form-control" id="inputEmpaque" name="packaging_weight"
                oninput="actualizarPesoNeto()" required>
            <div id="empaqueError" class="text-danger"></div>
        </div>

        <!-- Peso Neto -->
        <div class="col-md-4">
            <label for="inputNeto" class="form-label">Peso neto</label>
            <label id="resultadoNeto" class="form-control" for="inputNeto"></label>
            <div id="netoError" class="text-danger"></div>
            <input type="hidden" name="net_weight" id="inputNeto" required>
        </div>

        <!-- Botones -->
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2" id="enviarBtn">Enviar</button>
            <button type="button" class="btn btn-danger mx-2" id="limpiarBtn">Limpiar</button>
        </div>
    </form>
</div>

<!-- Script JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Evento para la selección de la descripción
        $('#inputDescripcion').on('change', function() {
            var descripcion = $(this).val().trim();
            var $skuInput = $('#inputSku');

            if (descripcion !== '') {
                obtenerSkuPorDescripcion(descripcion, $skuInput);
            } else {
                limpiarSku($skuInput);
            }
        });
    });

    function obtenerSkuPorDescripcion(descripcion, $skuInput) {
        $.ajax({
            url: '{{ route('obtenerSkuPorDescripcion') }}',
            method: 'POST',
            data: {
                descripcion: descripcion,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Actualiza el campo SKU con el valor obtenido
                $skuInput.val(response.sku);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud Ajax:', textStatus, errorThrown);
                // Manejar el error si es necesario
            }
        });
    }

    function limpiarSku($skuInput) {
        $skuInput.val('');
    }
    $(document).ready(function() {
        // Evento para la entrada en el campo de filtrado de Descripción
        $('#inputFiltrarDescripcion').on('input', function() {
            filtrarDescripciones($(this).val());
        });
    });

    function filtrarDescripciones(filtro) {
        filtro = filtro.trim().toLowerCase();
        var $select = $('#inputDescripcion');

        $select.find('option').filter(function() {
            var optionText = $(this).text().toLowerCase();
            $(this).toggle(optionText.indexOf(filtro) > -1);
        });

        var opcionesVisibles = $select.find('option:visible');
        if (opcionesVisibles.length === 1) {
            opcionesVisibles.prop('selected', true);
        }
    }
</script>
<script>
    $(document).ready(function() {
        // Evento para el cambio en el número de recibo
        $('#inputOrderNum').on('change', function() {
            obtenerInfoRecibo($(this).val());
        });

        // Evento para la entrada en el campo de filtrado de número de orden
        $('#inputFiltrarOrderNum').on('input', function() {
            filtrarOrdenes($(this).val());
        });

        // Evento para la entrada en el campo de filtrado de SKU y cambio en el campo SKU
        $('#inputFiltrarSku, #inputSku').on('input change', function() {
            filtrarOpciones($('#inputFiltrarSku'), $('#inputSku'));

            var sku = $('#inputSku').val().trim();
            var $descripcionSelect = $('#inputDescripcion');

            if (sku !== '') {
                obtenerDescripcionPorSku(sku, $descripcionSelect);
            } else {
                limpiarDescripcion($descripcionSelect);
            }
        });

        // Botón Limpiar
        $('#limpiarBtn').on('click', function() {
            limpiarFormulario();
        });
    });

    function limpiarFormulario() {
        // Restablecer el formulario a su estado original
        $('#productoForm')[0].reset();

        // Ocultar mensajes de error
        $('#consecutivoError, #descripcionError, #umbError, #cantidadError, #brutoError, #empaqueError, #netoError')
            .text('');

        // Deshabilitar select de descripción
        limpiarDescripcion($('#inputDescripcion'));

        // Restablecer el resultado de Peso Neto
        $('#resultadoNeto').text('');

        // Restablecer el valor del campo oculto de Peso Neto
        $('#inputNeto').val('');

        // Restablecer el valor del campo oculto de Descripción
        $('#hiddenDescripcion').val('');
    }

    function filtrarOrdenes(filtro) {
        filtro = filtro.trim().toLowerCase();
        var $select = $('#inputOrderNum');

        $select.find('option').filter(function() {
            var optionText = $(this).text().toLowerCase();
            $(this).toggle(optionText.indexOf(filtro) > -1);
        });

        var opcionesVisibles = $select.find('option:visible');
        if (opcionesVisibles.length === 1) {
            opcionesVisibles.prop('selected', true);
        }
    }

    function filtrarOpciones(inputFiltrar, selectDestino) {
        var filtro = inputFiltrar.val().trim().toLowerCase();
        var $select = selectDestino;

        $select.find('option').filter(function() {
            var optionText = $(this).text().toLowerCase();
            $(this).toggle(optionText.indexOf(filtro) > -1);
        });

        var opcionesVisibles = $select.find('option:visible');
        if (opcionesVisibles.length === 1) {
            opcionesVisibles.prop('selected', true);
        }
    }


    function limpiarDescripcion($descripcionSelect) {
        $descripcionSelect.prop('disabled', true).html('<option value="" selected>Selecciona un SKU primero</option>');
    }

    function actualizarPesoNeto() {
        var bruto = parseFloat($('#inputbruto').val()) || 0;
        var empaque = parseFloat($('#inputEmpaque').val()) || 0;
        var pesoNeto = bruto - empaque;
        $('#resultadoNeto').text(pesoNeto.toFixed(2));
        $('#inputNeto').val(pesoNeto.toFixed(2));
    }

    function obtenerInfoRecibo(orderNum) {
        $.ajax({
            url: '{{ route('obtenerInfoRecibo') }}',
            method: 'POST',
            data: {
                order_num: orderNum,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#inputDeliveryDate').val(response.data.delivery_date);
                    $('#inputCodeCustomer').val(response.data.code_customer);
                } else {
                    alert('No se pudo obtener la información del recibo.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud Ajax:', textStatus, errorThrown);
                alert('Error al realizar la solicitud.');
            }
        });
    }
</script>
