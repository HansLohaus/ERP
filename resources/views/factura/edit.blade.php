@extends("app.main")

{{-- Cabecera --}}
@section("title","Facturas")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Facturas")
@section("breadcrumb")
    <li class="breadcrumb-item">Facturas</li>
    <li class="breadcrumb-item active">Editar Factura</li>
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
					<h3 class="panel-title">Editar Factura</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('facturas.update',$factura->id) }}"  role="form">
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="PATCH">
								<div class="row">
             						<div class="col-xs-6 col-sm-6 col-md-6">
             					   		<div class="form-group">
             					     	<input type="text" name="cliente_id" id="cliente_id" class="form-control 	input-sm" value="{{$factura->cliente_id}}">
	             					</div>
                  					 </div>
             					 	<div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="servicio_id" id="servicio_id" class="form-control 	input-sm" value="{{$factura->servicio_id}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="folio" id="folio" class="form-control input-sm" value="{{$factura->folio}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="tipo_dte" id="tipo_dte" class="form-control input-sm" value="{{$factura->tipo_dte}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="date" name="fecha_emision" id="fecha_emision" class="	form-control input-sm" value="{{$factura->fecha_emision}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="total_neto" id="total_neto" class="form-control 	input-sm" value="{{$factura->total_neto}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="total_exento" id="total_exento" class="form-control input-sm" value="{{$factura->total_exento}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="total_iva" id="total_iva" class="form-control 	input-sm" value="{{$factura->total_iva}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					   <div class="form-group">
             					     <input type="text" name="total_monto_total" id="total_monto_total" class="	form-control input-sm" value="{{$factura->total_monto_total}}">
             					   </div>
             					 </div>
             					 <div class="col-xs-6 col-sm-6 col-md-6">
             					 	<select name="estado" id="estado" class="form-control input-sm" >
										<option >{{$factura->estado}}</option>
  										   <option value="pagado">pagado</option>
  										   <option value="impago">impago</option>
  										   <option value="abono">abono</option>
  										 </select>
             					   {{-- <div class="form-group">
             					     <input type="text" name="estado" id="estado" class="form-control input-sm" value="{{$factura->estado}}">
             					   </div> --}}
             					 </div>
              				</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
									<a href="{{ route('facturas.index') }}" class="btn btn-info btn-block" >Atrás</a>
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