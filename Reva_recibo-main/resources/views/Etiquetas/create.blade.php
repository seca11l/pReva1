@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear nueva etiqueta</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('etiquetas.form', ['recibos' => $recibos])
        </div>
    </div>
</div>
@endsection
