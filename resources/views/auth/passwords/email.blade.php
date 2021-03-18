@extends('app.nside')
@section("title","- Recuperar contraseña")
@section('content')
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-6" style="margin-top: 20px;">
        <div class="card">
            <h4 class="card-header" style="background: #1E88E5; color: #fff;">Recuperar contraseña</h4>
            <div class="card-block">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="control-label">E-Mail</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                        <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary">
                            Enviar enlace de recuperación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection