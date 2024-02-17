@extends('layouts.app')

@section('content')
    {{-- Agrega los estilos y scripts de DataTables --}}
    <style>
        /* Estilos personalizados */
        #dataTable_wrapper .dataTable thead th,
        #dataTable_wrapper .dataTable thead td {
            border: none;
            background-color: #f2f2f2;
            border-radius: 0;
        }

        #dataTable_filter input {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            background-color: #f2f2f2;
        }

        .bg-teal {
            background-color: #4FD1C5;
        }

        .text-teal {
            color: #4FD1C5;
        }

        .btn-teal {
            background-color: #ffffff;
            color: #0f0f0f;
        }

        .btn-teal:hover {
            background-color: #3CB3A6;
        }

        #dataTable tbody td {
            border: none;
        }
    </style>

    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-lg font-semibold text-white">Formatos de recibo</h3>
                <button type="button" class="btn btn-teal btn-sm rounded-md" data-bs-toggle="modal"
                    data-bs-target="#createReceiptModal">
                    Crear nuevo recibo
                </button>
            </div>

            <div class="p-4">
                <div class="table-responsive">
                    <table class="w-full table table-hover shadow-md" id="dataTable">
                        <thead class="bg-teal text-teal">
                            <tr>
                                @foreach (['Número de formato', 'Fecha', 'Origen', 'Cliente', 'Código del Cliente', 'Conductor', 'Placa', 'Impronta', 'Acciones'] as $header)
                                    <th class="py-3 px-4">{{ $header }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @for ($i = 0; $i < 8; $i++)
                                    <th class="py-3 px-4">
                                        <input type="text" class="form-control filter-input"
                                            data-column="{{ $i }}" placeholder="Filtrar">
                                    </th>
                                @endfor
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recibos as $recibo)
                                <tr data-recibo="{{ $recibo->order_num }}">
                                    @foreach ([$recibo->order_num, $recibo->delivery_date, $recibo->origin, $recibo->customer, $recibo->code_customer, $recibo->driver, $recibo->plate, $recibo->num_vehicle] as $data)
                                        <td class="py-2 px-4">{{ $data }}</td>
                                    @endforeach
                                    <td>
                                        <a href="{{ route('productos.index', ['order_num' => $recibo->order_num]) }}"
                                            class="btn btn-info btn-sm rounded">Detalles</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-2 px-4">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createReceiptModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createReceiptModalLabel">Crear un nuevo recibo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePdfModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('recibo.form') <!-- Asegúrate de tener un formulario aquí -->
                </div>
            </div>
        </div>
    </div>

    {{-- Inicializa DataTables para tu tabla --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
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
            });

            // Configurar los filtros de DataTables
            table.columns().every(function() {
                var that = this;

                $('input', this.header()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('js/Modals.js') }}"></script>
@endsection
