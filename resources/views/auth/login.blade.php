@extends('layouts.app')

@section('content')
<div class="login-register" style="background-image: url('/images/background-login-image.jpg');"">
    <div class="login-box card">
        <div class="card-body sombra p-4">
            <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
                @csrf
                <h3 class="box-title m-b-20 text-center">Iniciar sesión</h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="d-flex no-block align-items-center">
                        <div class="checkbox checkbox-primary p-t-0">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember"> Recordarme </label>
                        </div> 
                    </div>
                    {{-- <div class="d-flex justify-content-center mt-4">
                        <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock m-r-5"></i> ¿Olvidaste tu contraseña?</a> 
                    </div> --}}
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: #184587;">Acceder</button>
                    </div>
                </div>
            </form>
            @if (Route::has('password.request'))
                <form method="POST" class="form-horizontal form-material" id="recoverform" action="#">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="d-flex flex-row justify-content-between">
                                <h3>Recuperar contraseña</h3>
                                <div style="cursor: pointer" onclick="closeRecoverPassword()"><i class="bi bi-x-lg"></i></div>
                            </div>    
                            <p class="text-muted">Ingresa tu email y te enviaremos las instrucciones</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" required placeholder="Email"> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: #184587;">Restablecer</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    function closeRecoverPassword() {
        $("#loginform").css("display", "block");
        $("#recoverform").css("display", "none");
    }
    $(".invalid-feedback").css("display", "block");
</script>
@endsection
