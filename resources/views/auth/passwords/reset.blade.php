@extends('app.nside')
@section("title","- Cambiar contraseña")
@section('content')
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6" style="margin-top: 20px;">
        <div class="card">
            <h4 class="card-header" style="background: #1E88E5; color: #fff;">Iniciar Sesión</h4>
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
                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="control-label">E-mail</label>
                        <input id="email" type="text" class="form-control" name="email" value="{{ $email or old('email') }}" required>
                        @if ($errors->has('email'))
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="password" class="control-label">Nueva Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                        <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                        <label for="password_confirmation" class="control-label">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        @if ($errors->has('password_confirmation'))
                        <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">
                            Registrar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $('#password,#password_confirmation').on("keyup", function () {
        var parent = $('#password,#password_confirmation').parents(".form-group");
        var pass  = $("#password").val();
        var npass = $("#password_confirmation").val();
        if (pass !== "") {
            if (pass == npass) {
                if (!parent.hasClass("has-success")) {
                    parent.removeClass("has-error");
                    parent.addClass("has-success");
                    $('#password,#password_confirmation').css({"background-color":"#B5EBAA"});
                }
            } else {
                if (!parent.hasClass("has-error")) {
                    parent.removeClass("has-success");
                    parent.addClass("has-error");
                    $('#password,#password_confirmation').css({"background-color":"#FDCDCD"});
                }
            }
        } else {
            parent.removeClass("has-success").removeClass("has-error");
            $('#password,#password_confirmation').css({"background-color":""});
        }
    });
</script>
@endpush