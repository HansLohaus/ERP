@extends("app.main")

{{-- Cabecera --}}
@section("title","Proveedores")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Proveedores")
@section("breadcrumb")
    <li class="breadcrumb-item">Proveedores</li>
    <li class="breadcrumb-item active">Nuevo Proveedor</li>
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
					<h3 class="panel-title">Nuevo Cliente</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('proveedores.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Rut</label>
										<input type="text" name="rut" id="rut" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Razón Social</label>
										<input type="text" name="razon_social" id="razon_social" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nmombre de fantasia</label>
										<input type="text" name="nombre_fantasia" id="nombre_fantasia" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre contacto financiero</label>
										<input type="text" name="nombre_contacto_fin" id="nombre_contacto_fin" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre contacto técnico</label>
										<input type="text" name="nombre_contacto_tec" id="nombre_contacto_tec" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Teléfono contacto financiero</label>
										<input type="text" name="fono_contacto_fin" id="fono_contacto_fin" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Teléfono contacto técnico</label>
										<input type="text" name="fono_contacto_tec" id="fono_contacto_tec" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Email contacto financiero</label>
										<input type="text" name="email_contacto_fin" id="email_contacto_fin" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Email contacto técnico</label>
										<input type="text" name="email_contacto_tec" id="email_contacto_tec" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Activo</label>
										<input type="text" name="activo" id="activo" class="form-control input-sm">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
									<a href="{{ route('proveedores.index') }}" class="btn btn-info btn-block" >Atrás</a>
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