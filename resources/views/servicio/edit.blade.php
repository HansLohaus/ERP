@extends("app.main")

{{-- Cabecera --}}
@section("title","Servicios")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Servicios")
@section("breadcrumb")
    <li class="breadcrumb-item">Servicios</li>
    <li class="breadcrumb-item active">Editar Servicio</li>
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
					<h3 class="panel-title">Editar Servicio</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('servicios.update',$servicio->id) }}"  role="form">
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="PATCH">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<div class="form-group">
										<input type="text" name="cliente_id" id="cliente_id" class="form-control input-sm" value="{{$servicio->cliente_id}}">
									</div>
										{{-- <select name="cliente_id" id="cliente_id" class="form-control input-sm" required="required" value="{{$servicio->cliente_id}}">
											@foreach ($clientes->get())
												<option value="{{$clientes}}"></option>
											@endforeach
										</select> --}}
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="nombre" id="nombre" class="form-control input-sm" value="{{$servicio->nombre}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control input-sm" value="{{$servicio->fecha_inicio}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="date" name="fecha_fin" id="fecha_fin" class="form-control input-sm" value="{{$servicio->fecha_fin}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="tipo" id="tipo" class="form-control input-sm" value="{{$servicio->tipo}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<select name="estado" id="estado" class="form-control input-sm" >
										<option >{{$servicio->estado}}</option>
  										   <option value="activo">activo</option>
  										   <option value="inactivo">inactivo</option>
  										 </select>
									{{-- <div class="form-group">
										<input type="text" name="estado" id="estado" class="form-control input-sm" value="{{$servicio->estado}}">
									</div> --}}
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="numero_propuesta" id="numero_propuesta" class="form-control input-sm" value="{{$servicio->numero_propuesta}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<input type="text" name="condicion_pago" id="condicion_pago" class="form-control input-sm" value="{{$servicio->condicion_pago}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
									<a href="{{ route('servicios.index') }}" class="btn btn-info btn-block" >Atrás</a>
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