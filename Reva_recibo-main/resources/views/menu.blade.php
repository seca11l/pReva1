<!-- resources/views/menu.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('includes.menu')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <!-- Contenido principal de la vista menu -->
                <div id="toggleMenu">&#9776;</div>

                <div id="sideMenu" class="hidden">
                    <!-- Contenido del menú lateral -->
                    <a href="{{ route('recibo.index') }}">Formato de recibo</a>
                    <a href="{{ route('etiqueta.index') }}">Formato de etiqueta</a>
                    <a href="{{ route('pulpo.index') }}">Formato de recibo pulpo wms</a>
                </div>
        </div>
        </main>
    </div>
    </div>
@endsection
