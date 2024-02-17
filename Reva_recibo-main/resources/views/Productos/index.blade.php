@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5 mb-5">
    <div class="bg-white rounded-md overflow-hidden shadow-md">
        <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
            <h3 class="text-lg font-semibold text-white">Tabla de productos</h3>
            <div class="flex">
                <button type="button" class="btn btn-teal ml-2" data-bs-toggle="modal" data-bs-target="#createProductsModal">
                    Crear nuevo producto
                </button>
                <button type="button" class="btn btn-teal ml-2" onclick="exportToCSV()">
                    Exportar a CSV
                </button>
                <a href="{{ route('recibo.index') }}" class="btn btn-secondary btn-sm ml-2">Volver Atrás</a>
            </div>
        </div>

        <div class="p-4">
            <div class="table-responsive">
                <table class="w-full table table-bordered table-striped table-hover" id="productsTable">
                    <thead class="bg-teal text-white">
                        <tr>
                            <th>supplier_code</th>
                            <th>order_num</th>
                            <th>Notes</th>
                            <th>delivery_date</th>
                            <th>sku</th>
                            <th>requested_quantity</th>
                            <th>criterium</th>
                            <th>Descripción</th>
                            <th>Unidad de Medida</th>
                            <th>Cantidad</th>
                            <th>Peso Bruto</th>
                            <th>Peso de Empaque</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                        <tr>
                            <td>{{ optional($producto->recibo)->code_customer }}</td>
                            <td>{{ optional($producto->recibo)->order_num }}</td>
                            <td>{{ $producto->notes }}</td>
                            <td>{{ optional($producto->recibo)->delivery_date }}</td>
                            <td>{{ $producto->sku }}</td>
                            <td>{{ $producto->net_weight }}</td>
                            <td>{{ $producto->criterium }}</td>
                            <td>{{ $producto->description }}</td>
                            <td>{{ $producto->unit_measurement }}</td>
                            <td>{{ $producto->amount }}</td>
                            <td>{{ $producto->gross_weight }}</td>
                            <td>{{ $producto->packaging_weight }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12">No hay datos disponibles</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createProductsModal" tabindex="-1" role="dialog" aria-labelledby="createProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-teal text-white">
                <h1 class="modal-title">Crear Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closecreateProductsModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('productos.form')
            </div>
        </div>
    </div>
</div>

<!-- Incluye el archivo de estilos -->
<link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/table-styles.css') }}">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#productsTable').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            pageLength: 30,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                info: "Mostrando _START_ al _END_ de _TOTAL_ registros",
                lengthMenu: "Mostrar _MENU_ registros por página",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                },
            },
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.header()))
                        .on('keyup change', function() {
                            column.search($(this).val(), false, false, true).draw();
                        });
                });
            },
            "paging": true,
            "ordering": true,
            "info": true,
            "border": false,
        });

        // Elimina los bordes de las columnas
        $('#productsTable').find('thead th').removeClass('sorting sorting_asc sorting_desc');
    });

    function exportToCSV() {
        // Crear un objeto para almacenar datos agregados por SKU y order_num
        var aggregatedData = {};

        // Iterar a través de las filas de la tabla y agregar datos
        $('#productsTable tbody tr').each(function(index, row) {
            var orderNum = $(row).find('td:nth-child(2)').text();
            var sku = $(row).find('td:nth-child(5)').text();
            var netWeight = parseFloat($(row).find('td:nth-child(6)').text()) || 0;

            if (!aggregatedData[orderNum + sku]) {
                // Si orderNum + sku no está en aggregatedData, inicializarlo
                aggregatedData[orderNum + sku] = {
                    supplier_code: $(row).find('td:nth-child(1)').text(),
                    order_num: orderNum,
                    notes: $(row).find('td:nth-child(3)').text(),
                    delivery_date: $(row).find('td:nth-child(4)').text(),
                    sku: sku,
                    requested_quantity: netWeight,
                    criterium: $(row).find('td:nth-child(7)').text(),
                };
            } else {
                // Si ya existe, actualizar requested_quantity sumando netWeight
                aggregatedData[orderNum + sku].requested_quantity += netWeight;
            }
        });

        // Convertir los datos agregados a un array
        var aggregatedArray = Object.values(aggregatedData);

        // Convertir los datos al formato CSV utilizando PapaParse
        var csv = Papa.unparse(aggregatedArray, {
            columns: ["supplier_code", "order_num", "notes", "delivery_date", "sku", "requested_quantity", "criterium"]
        });

        // Crear un Blob e iniciar la descarga
        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement('a');
        var url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', 'productos.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>

@endsection
