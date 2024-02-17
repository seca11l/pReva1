@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('path/to/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/stylelogin.css') }}">

<section class="d-flex justify-content-center align-items-center">
    <div class="container py-5">
        <div class="card border-0">
            <div class="row g-0">
                <div class="col-md-6 col-lg-5 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('img/2.jpg') }}" alt="formulario de inicio de sesión" class="img-fluid" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                    <div class="card-body p-4 p-lg-5 text-black">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="d-flex align-items-center mb-3 pb-1">
                                <span class="h1 fw-bold mb-0" style="font-size: 3rem;">Iniciar sesión</span>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="email" id="email" class="form-control form-control-lg" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus />
                                <label class="form-label" for="email" style="font-size: 1.5rem;">Correo electrónico</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control form-control-lg"
                                    name="password" required autocomplete="current-password" />
                                <label class="form-label" for="password" style="font-size: 1.5rem;">Contraseña</label>
                            </div>

                            <div class="pt-1 mb-4">
                                <button class="btn btn-dark btn-lg btn-block" type="submit" style="font-size: 1.5rem;">Entrar</button>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember" style="font-size: 1.2rem;">Recordar contraseña</label>
                                    </div>
                                </div>
                                <div class="col-md-8 ">
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size: 1.2rem;">¿Olvidó su
                                        contraseña?</a>
                                </div>
                            </div>
                        </form>

                        <!-- Agrega estilos para la imagen en la esquina inferior derecha -->
                        <div class="position-absolute bottom-0 end-0 p-3">
                            <img src="{{ asset('img/logo_reva-01.png') }}" alt="logo_reva-01" class="img-fluid" style="max-width: 80px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
