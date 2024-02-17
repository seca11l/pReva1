@extends('layouts.app')

@section('content')
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center rounded" style="min-height: 75vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover rounded" style='background-image: url("img/reva2.jpg");'>
            <span id="blackOverlay" class="w-full h-full absolute opacity-30 bg-black rounded"></span>
        </div>

    </div>


    <section class="pb-20 bg-white -mt-24 rounded-lg">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="lg:pt-12 pt-6 w-full md:w-6/12 px-4 text-center">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg overflow-hidden h-full">
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400">
                                <i class="fas fa-award"></i>
                            </div>
                            <h1 class="text-5xl font-semibold text-green-400">Formato de recibo</h1>
                            <h2 class="text-2xl mt-2 mb-4 text-gray-600">
                                Crear formatos de recibo para registrar información detallada de la recepción de materia
                                prima.
                            </h2>
                            <a href="{{ route('recibo.index') }}"
                                class="btn home bg-green-400 hover:bg-green-500 transition duration-300 ease-in-out rounded-full">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </div>
                    </div>
                </div>

                <div class="pt-12 w-full md:w-6/12 px-4 text-center">
                    <div
                        class="relative flex flex-col min-w-0 break-words bg-white w-full mb-8 shadow-lg rounded-lg overflow-hidden h-full">
                        <div class="px-4 py-5 flex-auto">
                            <div
                                class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 mb-5 shadow-lg rounded-full bg-green-400">
                                <i class="fas fa-award"></i>
                            </div>
                            <h6 class="text-5xl font-semibold text-green-400">Formato de etiquetas</h6>
                            <p class="text-2xl mt-2 mb-4 text-gray-600">
                                Crear formatos de etiquetas para clasificar las estibas correspondientes.
                            </p>
                            <a href="{{ route('etiqueta.index') }}"
                                class="btn home bg-green-400 hover:bg-green-500 transition duration-300 ease-in-out rounded-full">
                                <i class="fas fa-plus-circle mr-2"></i> Crear
                            </a>
                        </div>
                    </div>
                </div>


            </div>
            <div class="flex flex-wrap items-center mt-32">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto">
                    <h3 class="text-5xl mb-2 font-semibold leading-normal text-gray-800">
                        REVA </h3>
                    <p class="text-2xl font-light leading-relaxed mt-4 mb-4 text-gray-700">
                        Juntos podemos marcar la diferencia. Cada pequeña acción cuenta en la protección de nuestro preciado
                        medio ambiente. Reduzcamos, reutilicemos y reciclemos para construir un futuro sostenible. Cuidemos
                        nuestro hogar, porque cada gesto importa. 🌍♻️ </p>
                </div>
                <div class="w-full md:w-4/12 px-4 mr-auto ml-auto">
                    <div class="relative bg-teal-200 text-white w-full mb-6 shadow-lg rounded-lg overflow-hidden">
                        <img alt="..." src="{{ asset('img/reva.jpg') }}"
                            class="w-full align-middle rounded-t-lg object-cover h-64" />
                        <blockquote class="relative p-8 mb-4">
                            <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95"
                                class="absolute left-0 w-full block" style="height: 95px; top: -94px;">
                                <polygon points="-30,95 583,95 583,65" class="text-teal-200 fill-current"></polygon>
                            </svg>
                            <h1 class="text-5xl font-bold text-white">
                                REVA
                            </h1>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function toggleNavbar(collapseID) {
            document.getElementById(collapseID).classList.toggle("hidden");
            document.getElementById(collapseID).classList.toggle("block");
        }
    </script>
@endsection
