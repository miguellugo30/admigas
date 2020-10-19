@extends('adminlte::master')

@section('adminlte_css')
    @stack('css')
    @yield('css')
     <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/auth_client.css') }}">
@stop

@section('classes_body', 'register-page')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ $dashboard_url }}"><img src="{{ config('adminlte.logo_img') }}" alt="{{ config('adminlte.logo_img_alt') }}" style="width: 60%;margin-top: 15px;"></a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __('adminlte::adminlte.register_message') }}</p>
            <form action="{{ route('registro_cliente_form') }}" method="post">
                {{ csrf_field() }}

                <div class="input-group mb-3">
                    <input type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" value="{{ old('code') }}"
                           placeholder="Codigo de verificación" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-barcode"></span>
                        </div>
                    </div>

                    @if ($errors->has('code'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('code') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}"
                           placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}"
                           placeholder="{{ __('adminlte::adminlte.email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="{{ __('adminlte::adminlte.password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                           placeholder="{{ __('adminlte::adminlte.retype_password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </div>
                    @endif
                </div>
                                <div class="col">
                    <div class="icheck-primary">
                        <input type="checkbox" class="terms" id="agreeContract" name="terms" value="agree">
                        <label for="agreeContract">
                            Acepto <a href="{{ \Storage::url('terminos\Contrato_2G') }}.pdf" target="_blank">Contrato de Condomino</a>
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="icheck-primary">
                        <input type="checkbox" class="terms" id="agreeTerms" name="terms" value="agree">
                        <label for="agreeTerms">
                            Acepto <a href="{{ \Storage::url('terminos\Aviso_de_Privacidad_-_Protección_de_Datos') }}.pdf"  target="_blank">Aviso de privacidad</a>
                        </label>
                    </div>
                </div>
                <button type="submit" id="register" class="btn btn-primary btn-block btn-flat" disabled>
                    {{ __('adminlte::adminlte.register') }}
                </button>
            </form>
            <p class="mt-2 mb-1">
                <a href="{{ route('login_cliente')  }}">
                    {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                </a>
            </p>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
        <script>
        var checkboxes = document.getElementsByClassName('terms');
        [...checkboxes].map( e => e.addEventListener("click", terms));

        function terms() {
            var suma=0;
            for (var i = 0; i < checkboxes.length; i++)
                if(checkboxes[i].checked != true)
                    suma=suma+1;
                    if ( suma == 0 ) {
                        document.getElementById("register").disabled = false;
                    }else{
                        document.getElementById("register").disabled = true;
                    }
        }

        terms();
    </script>
@stop
