@extends("layouts.base",["sidebar" => false])
@section("title","- Inicio de Sesión")
@section('wrapper')
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6" style="margin-top: 20px;">
        <div class="card card-primary">
            <h4 class="card-header">Iniciar Sesión</h4>
            <div class="card-body">
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{$msg}}">{{Session::get('alert-'.$msg) }}
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>
                        @endif
                    @endforeach
                </div>
                <form method="POST" id="form-login" action="{{ url('/login') }}" style="{{ $errors->has('email') ? 'display:none;' : '' }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                        <label for="username" class="control-label">Usuario</label>
                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>
                        @if ($errors->has('username'))
                        <div class="form-control-feedback">{{ $errors->first('username') }}</div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="control-label">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">
                            Iniciar Sesión
                        </button>

                        <a class="btn btn-link" id="to-recover" href="javascript:void(0)">
                            ¿ Olvidó su contraseña ?
                        </a>
                    </div>
                </form>
                <form method="POST" id="form-recover" action="{{ route('password.email') }}" style="{{ $errors->has('email') ? '' : 'display:none;' }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="control-label">E-mail</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ingrese su E-mail" required>
                        @if ($errors->has('email'))
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">
                            Enviar
                        </button>
                        <a class="btn btn-secondary" id="to-login" href="javascript:void(0)">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#to-recover').on("click", function () {
      $("#form-login").hide();
      $("#form-recover").fadeIn();
    });
    $('#to-login').on("click", function () {
      $("#form-recover").hide();
      $("#form-login").fadeIn();
    });
</script>
@endpush