@extends("app.main")

{{-- Cabecera --}}
@section("title","Trabajadores")
@push("header")
<style type="text/css"></style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","Trabajadores")
@section("breadcrumb")
    <li class="breadcrumb-item">Trabajadores</li>
    <li class="breadcrumb-item active">Editar trabajador</li>
@endsection
{{-- Contenido --}}
@section("content")
	<div class="col-md-12 col-md-offset-2">
	@if (count($errors) > 0)
	<div class="alert alert-danger">
	<strong>Error!</strong> Revise los campos obligatorios.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
	</div>
	@endif 
	  <div class="panel panel-default">
	  	<div class="panel-heading">
	  	<h3 class="panel-title">Editar trabajador</h3>
	  	</div>
	  	<div class="panel-body">					
	  		<div class="table-container">
	  			<form method="POST" action="{{ route('trabajadores.update',$trabajador->id) }}"  role="form">
	  			{{ csrf_field() }}
	  			<input name="_method" type="hidden" value="PATCH">
	  				<div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
              	<div class="form-group">
                 	<label>Nombres:</label>
                 	<input type="text" name="nombres" id="nombres" class="form-control input-sm" value="{{$trabajador->nombres}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Apellido paterno:</label>
                  <input type="text" name="apellidoP" id="apellidoP" class="form-control input-sm" value="{{$trabajador->apellidoP}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>apellido materno:</label>
                  <input type="text" name="apellidoM" id="apellidoM" class="form-control input-sm" value="{{$trabajador->apellidoM}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Rut (Formato: sin puntos con guión. Ejemplo: 12345678-9):</label>
                  <input type="text" name="rut" id="rut" class="form-control input-sm" value="{{$trabajador->rut}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Fecha de nacimiento:</label>
                  <input type="date" name="fecha_nac" id="fecha_nac" class="form-control input-sm" value="{{$trabajador->fecha_nac}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Dirección:</label>
                  <input type="text" name="direccion" id="direccion" class="form-control input-sm" value="{{$trabajador->direccion}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Cargo:</label>
                  <input type="text" name="cargo" id="cargo" class="form-control input-sm" value="{{$trabajador->cargo}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Profesión:</label>
                  <input type="text" name="profesion" id="profesion" class="form-control input-sm" value="{{$trabajador->profesion}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Sueldo:</label>
                  <input type="number" name="sueldo" id="sueldo" class="form-control input-sm" value="{{$trabajador->sueldo}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Fecha de contrato:</label>
                  <input type="date" name="fecha_contrato" id="fecha_contrato" class="form-control input-sm" value="{{$trabajador->fecha_contrato}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Teléfono (Formato sin signo ni separaciones. Ejemplo: 56912341234):</label>
                  <input type="tel" name="fono" id="fono" class="form-control input-sm" value="{{$trabajador->fono}}" pattern="[0-9]{11}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Email:</label>
                  <input type="email" name="email" id="email" class="form-control input-sm" value="{{$trabajador->email}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Email alternativo:</label>
                  <input type="email" name="email_alt" id="email_alt" class="form-control input-sm" value="{{$trabajador->email_alt}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Número cuenta bancaria:</label>
                  <input type="number" name="numero_cuenta_banc" id="numero_cuenta_banc" class="form-control input-sm" value="{{$trabajador->numero_cuenta_banc}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Titular cuenta bancaria:</label>
                  <input type="text" name="titular_cuenta_banc" id="titular_cuenta_banc" class="form-control input-sm" value="{{$trabajador->titular_cuenta_banc}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Banco:</label>
                  <input type="text" name="banco" id="banco" class="form-control input-sm" value="{{$trabajador->banco}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Tipo de cuenta:</label>
                  <input type="text" name="tipo_cuenta" id="tipo_cuenta" class="form-control input-sm" value="{{$trabajador->tipo_cuenta}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Afp:</label>
                  <input type="text" name="afp" id="afp" class="form-control input-sm" value="{{$trabajador->afp}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Previsión:</label>
                  <input type="text" name="prevision" id="prevision" class="form-control input-sm" value="{{$trabajador->prevision}}">
                </div>
              </div>
            </div>
            <br>
	  				<div class="row">
	  					<div class="col-xs-12 col-sm-12 col-md-12">
	  						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
	  						<a href="{{ route('trabajadores.index') }}" class="btn btn-info btn-block" >Atrás</a>
	  					</div>	
	  				</div>
	  			</form>
	  		</div>
	  	</div>
	  </div>
	</div>
@endsection
@push("scripts")
<script type="text/javascript"> 
</script>
@endpush