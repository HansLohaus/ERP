@extends("app.main")

{{-- Cabecera --}}
@section("title","Servicios")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Servicios")
{{-- @inject('clientes', 'App\Cliente;') --}}
@section("breadcrumb")
    <li class="breadcrumb-item">Servicio</li>
    <li class="breadcrumb-item active">Nuevo Servicio</li>
@endsection
{{-- Contenido --}}
@section("content")
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
					<h3 class="panel-title">Nuevo Servicio</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('servicios.store') }}"  role="form">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6">
				                  <div class="form-group">
				                    <label>Cliente/proveedor</label>
				                    <select id="select1" class="form-control input-sm" >
				                      <option>Seleccione</option>
				                         <option value='1'>cliente</option>
				                         <option value='2'>proveedor</option>
				                    </select>
				                  </div>
				                </div>
				                <div class="col-xs-6 col-sm-6 col-md-6">
				                  <div class="form-group">
				                    <label>-</label>
				                    <select name="tipo_entidad_id" id="select2" class="form-control input-sm">
				                      <option value=""  hidden>Seleccione</option>
				                      @foreach ($clientes as $cliente)
				                        <option value="{{ $cliente->id }}" data-tag='1'>{{ $cliente->entidad->nombre_fantasia }}</option>
				                      @endforeach
				                      @foreach ($proveedores as $proveedor)
				                        <option value="{{ $proveedor->id }}" data-tag='2'>{{ $proveedor->entidad->nombre_fantasia }}</option>
				                      @endforeach
				                    </select>
				                  </div>
				                </div>
				                <script>
				                  $('#select1').on('change', function() {
				                    var selected = $(this).val();
				                    $("#select2 option").each(function(item){
				                      console.log(selected) ;  
				                      var element =  $(this) ; 
				                      console.log(element.data("tag")) ; 
				                      if (element.data("tag") != selected){
				                        element.hide() ; 
				                      }else{
				                        element.show();
				                      }
				                    }) ; 
				                    $("#select2").val($("#select2 option:visible:first").val());
				                });
				                </script>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Nombre</label>
										<input type="text" name="nombre" id="nombre" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Fecha de inicio del servicio</label>
										<input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>fecha de término del servicio</label>
										<input type="date" name="fecha_fin" id="fecha_fin" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Tipo de servicio</label>
										<select name="tipo" id="tipo" class="form-control input-sm">
  										   <option value="servicio">servicio</option>
  										   <option value="proyecto">proyecto</option>
  										 </select>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Estado del servicio</label>
										<select name="estado" id="estado" class="form-control input-sm">
  										   <option value="activo">activo</option>
  										   <option value="inactivo">inactivo</option>
  										 </select>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Número de propuesta</label>
										<input type="number" name="numero_propuesta" id="numero_propuesta" class="form-control input-sm">
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6">
									<div class="form-group">
										<label>Condición de pago</label>
										<input type="text" name="condicion_pago" id="condicion_pago" class="form-control input-sm">
									</div>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Guardar" class="btn btn-success btn-block">
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