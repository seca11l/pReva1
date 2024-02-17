<div class="container mt-5">
    <form method="POST" action="{{ route('recibo.store') }}" class="formulario-estilos row g-3">
        @csrf
        <div class="col-md-6">
            <label for="inputdelivery_date" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="inputdelivery_date" name="delivery_date" required>
        </div>
        <div class="col-md-6">
            <label for="inputorigin" class="form-label">Origen</label>
            <input type="text" class="form-control" id="inputorigin" name="origin">
        </div>
        <div class="col-md-6 d-flex">
            <div class="me-2 flex-grow-1">
                <label for="customerFilter" class="form-label">Buscar</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="customerFilter" placeholder="Buscar clientes">
                </div>
            </div>
            <div class="flex-grow-1">
                <label for="customer" class="form-label">Seleccionar Cliente</label>
                <select class="form-select custom-select" id="customer" name="customer" style="width: 100%;" required>
                    <option value="" disabled selected>Seleccione un cliente</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->name }}" data-code="{{ $supplier->code }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label for="inputcode_customer" class="form-label">Código del cliente</label>
            <input type="text" class="form-control" id="inputcode_customer" name="code_customer" required readonly>
        </div>
        <div class="col-md-4">
            <label for="inputdriver" class="form-label">Nombre del conductor</label>
            <input type="text" class="form-control" id="inputdriver" name="driver" required>
        </div>
        <div class="col-md-4">
            <label for="inputplate" class="form-label">Placa del vehículo</label>
            <input type="text" class="form-control" id="inputplate" name="plate" required>
        </div>
        <div class="col-md-4">
            <label for="inputnum_vehicle" class="form-label">Impronta</label>
            <input type="text" class="form-control" id="inputnum_vehicle" name="num_vehicle">
        </div>
        <div class="col-12 mt-3 text-center">
            <button type="submit" class="btn btn-success mx-2">Enviar</button>
            <button type="reset" class="btn btn-danger mx-2">Limpiar</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Evento para el filtrado de opciones del select
        $('#customerFilter').on('input', function() {
            var filterValue = $(this).val().toLowerCase();

            // Filtrar opciones del select
            $('#customer option').filter(function() {
                var optionText = $(this).text().toLowerCase();
                $(this).toggle(optionText.indexOf(filterValue) > -1);
            });
        });

        // Script para seleccionar automáticamente el código del cliente
        $('#customer').change(function() {
            var selectedCode = $(this).find(':selected').data('code');
            $('#inputcode_customer').val(selectedCode);
        });

        // Seleccionar automáticamente al cargar la página
        var selectedCode = $('#customer').find(':selected').data('code');
        $('#inputcode_customer').val(selectedCode);
    });
</script>

<script>
    // Obtén la referencia al elemento de entrada de fecha
    var inputDeliveryDate = document.getElementById('inputdelivery_date');

    // Obtén la fecha actual en formato ISO (YYYY-MM-DD)
    var currentDate = new Date().toISOString().split('T')[0];

    // Establece la fecha máxima como la fecha actual
    inputDeliveryDate.setAttribute('max', currentDate);
</script>
