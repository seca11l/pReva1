@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-5 mb-5">
        <div class="bg-white rounded-md overflow-hidden shadow-md">
            <div class="p-4 flex justify-between items-center bg-teal rounded-t-md">
                <h3 class="text-lg font-semibold text-white">Listado de Etiquetas</h3>
                <div class="flex">
                    <button type="button" class="btn btn-teal ml-2" data-bs-toggle="modal"
                        data-bs-target="#createTagsModal">
                        Nueva etiqueta
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm ml-2">Volver Atrás</a>
                </div>
            </div>

            <div class="p-4">
                <div class="table-responsive">
                    <table class="w-full table table-bordered table-striped table-hover" id="etiquetaTable">
                        <thead class="bg-teal text-white">
                            <tr>
                                <th>Consecutivo</th>
                                <th>Número de Orden</th>
                                <th>Código del Producto</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Cantidad</th>
                                <th>Peso</th>
                                <th>Tipo</th>
                                <th>Contenido</th>
                                <th>Estado del Producto</th>
                                <th>Color</th>
                                <th>Código de Barras</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($etiquetas as $etiqueta)
                                <tr>
                                    <td>{{ $etiqueta->id_tag }}</td>
                                    <td>{{ $etiqueta->order_num }}</td>
                                    <td>{{ $etiqueta->sku }}</td>
                                    <td>{{ $etiqueta->description }}</td>
                                    <td>{{ $etiqueta->delivery_date }}</td>
                                    <td>{{ $etiqueta->customer }}</td>
                                    <td>{{ $etiqueta->amount }}</td>
                                    <td>{{ $etiqueta->weight }}</td>
                                    <td>{{ $etiqueta->type }}</td>
                                    <td>{{ $etiqueta->content }}</td>
                                    <td>{{ $etiqueta->product_status }}</td>
                                    <td>{{ $etiqueta->color }}</td>
                                    <td>
                                        {!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128') !!}
                                        {{ $etiqueta->barcode }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)"
                                            onclick="openPdfModal('{{ route('etiquetas.imprimir', ['id_tag' => $etiqueta->id_tag]) }}')"
                                            class="btn btn-info btn-sm btn-teal">Imprimir</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14">No hay datos disponibles</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title">Vista previa del PDF</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closePdfModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" width="100%" height="600px" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createTagsModal" tabindex="-1" role="dialog" aria-labelledby="createTagsModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h1 class="modal-title">Crear Etiqueta</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closecreateTagsModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('etiquetas.form')
                </div>
            </div>
        </div>
    </div>

    {{-- Inicializa DataTables para tu tabla --}}
    <script>
        $(document).ready(function() {
            $('#etiquetaTable').DataTable({
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
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.header()))
                            .on('keyup change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    });
                },
                "paging": true,
                "ordering": true,
                "info": true,
                "border": false,
            });
        });
    </script>
@endsection
