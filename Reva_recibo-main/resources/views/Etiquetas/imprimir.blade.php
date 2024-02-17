<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Etiqueta</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/imprimir.css') }}" rel="stylesheet">
</head>

<body class="imprimir-font-sans imprimir-bg-gray-100 imprimir-p-20">
    <div
        class="flex flex-col items-center bg-white border border-black-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">

        <div class="flex flex-col justify-between p-4 leading-normal">
            <h1 class="mb-4 text-8xl font-bold tracking-tight text-gray-900 dark:text-white">Etiqueta</h1>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Consecutivo:
                <span class="text-blue-500 text-5xl">{{ $etiqueta->id_tag }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Número de Orden:
                <span class="text-blue-500 text-5xl">{{ $etiqueta->order_num }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Código del Producto:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->sku }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Descripción:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->description }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Fecha:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->delivery_date }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Cliente:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->customer }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Cantidad:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->amount }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Peso:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->weight }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Tipo:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->type }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Contenido:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->content }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Estado del Producto:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->product_status }}</span>
            </p>
            <p class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">Color:
                <span class="text-blue-500 text-4xl">{{ $etiqueta->color }}</span>
            </p>
            <div class="mb-4 text-4xl font-normal text-gray-700 dark:text-gray-400">
                <div class="imprimir-barcode-image max-w-screen-xl mx-auto">
                    {!! DNS1D::getBarcodeHTML($etiqueta->barcode, 'C128', 4, 80) !!}
                    <span class="text-blue-500">{{ $etiqueta->barcode }}</span>
                </div>
            </div>
            <img src="img/logo_reva-01.png" class="card-img w-48 h-auto absolute top-4 right-4" alt="Logo">
        </div>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
