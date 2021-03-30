@extends("app.main")

{{-- Cabecera --}}
@section("title","Clientes")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Clientes")
@section("breadcrumb")
    <li class="breadcrumb-item">Clientes</li>
    <li class="breadcrumb-item active">Editar Cliente</li>
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
					<h3 class="panel-title">Editar Cliente</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('clientes.update',$cliente->id) }}"  role="form">
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="PATCH">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>RUT</label>
										<input type="text" name="rut" id="rut" class="form-control input-sm" value="{{$cliente->entidad->rut}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Razón Social</label>
										<input type="text" name="razon_social" id="razon_social" class="form-control input-sm" value="{{$cliente->entidad->razon_social}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre de fantasía</label>
										<input type="text" name="nombre_fantasia" id="nombre_fantasia" class="form-control input-sm" value="{{$cliente->entidad->nombre_fantasia}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre contacto financiero</label>
										<input type="text" name="nombre_contacto_fin" id="nombre_contacto_fin" class="form-control input-sm" value="{{$cliente->entidad->nombre_contacto_fin}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre contacto técnico</label>
										<input type="text" name="nombre_contacto_tec" id="nombre_contacto_tec" class="form-control input-sm" value="{{$cliente->entidad->nombre_contacto_tec}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Teléfono contacto financiero</label>
										<input type="text" name="fono_contacto_fin" id="fono_contacto_fin" class="form-control input-sm" value="{{$cliente->entidad->fono_contacto_fin}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Teléfono contacto técnico</label>
										<input type="text" name="fono_contacto_tec" id="fono_contacto_tec" class="form-control input-sm" value="{{$cliente->entidad->fono_contacto_tec}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Email contacto financiero</label>
										<input type="text" name="email_contacto_fin" id="email_contacto_fin" class="form-control input-sm" value="{{$cliente->entidad->email_contacto_fin}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Email contacto técnico</label>
										<input type="text" name="email_contacto_tec" id="email_contacto_tec" class="form-control input-sm" value="{{$cliente->entidad->email_contacto_tec}}">
									</div>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="activo" id="flexRadioDefault1" value="1" checked>
								  <label class="form-check-label" for="flexRadioDefault1">
								    activo
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="activo" value="0" id="flexRadioDefault2">
								  <label class="form-check-label" for="flexRadioDefault2">
								    inactivo
								  </label>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
									<a href="{{ route('clientes.index') }}" class="btn btn-info btn-block" >Atrás</a>
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