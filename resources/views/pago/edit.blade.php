@extends("app.main")

{{-- Cabecera --}}
@section("title","Pagos")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Pagos")
@section("breadcrumb")
    <li class="breadcrumb-item">Pagos</li>
    <li class="breadcrumb-item active">Editar Pago</li>
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
					<h3 class="panel-title">Editar Pago</h3>
				</div>
				<div class="panel-body">					
					<div class="table-container">
						<form method="POST" action="{{ route('pagos.update',$pago->id) }}"  role="form">
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="PATCH">
							<div class="row">
               				 <div class="col-xs-6 col-sm-6 col-md-6">
               				   <div class="form-group">
               				   	<label>Id Fatura</label>
               				     <input type="text" name="factura_id" id="factura_id" class="form-control input-sm" value="{{$pago->factura_id}}">
               				   </div>
               				 </div>
                       <div class="col-xs-6 col-sm-6 col-md-6">
                         <div class="form-group">
                          <label>Id boleta/liquidacion</label>
                           <input type="text" name="boleta_liquidacion_id" id="boleta_liquidacion_id" class="form-control input-sm" value="{{$pago->boleta_liquidacion_id}}">
                         </div>
                       </div>
                       <div class="col-xs-6 col-sm-6 col-md-6">
                          <div class="form-group">
                            <label>ingreso/egreso</label>
                            <select name="ine" id="ine" class="form-control input-sm">
                                 <option>{{$pago->ine}}</option>
                                 <option value="ingreso">ingreso</option>
                                 <option value="egreso">egreso</option>
                               </select>
                          </div>
                        </div>
               				 <div class="col-xs-6 col-sm-6 col-md-6">
               				   <div class="form-group">
               				   	<label>Fecha de pago</label>
               				     <input type="date" name="fecha_pago" id="fecha_pago" class="form-control input-sm" value="{{$pago->fecha_pago}}">
               				   </div>
               				 </div>
               				 <div class="col-xs-6 col-sm-6 col-md-6">
               				   <div class="form-group">
               				   	<label>Monto</label>
               				     <input type="text" name="monto" id="monto" class="form-control input-sm" value="{{$pago->monto}}">
               				   </div>
               				 </div>
               				 <div class="col-xs-6 col-sm-6 col-md-6">
               				   <div class="form-group">
               				   	<label>Monto total de transferencia</label>
               				     <input type="text" name="monto_total_transf" id="monto_total_transf" class="form-control input-sm" value="{{$pago->monto_total_transf}}">
               				   </div>
               				 </div>
               				 <div class="col-xs-6 col-sm-6 col-md-6">
               				   <div class="form-group">
               				   	<label>Descripción de Movimiento</label>
               				     <input type="text" name="descrip_movimiento" id="descrip_movimiento" class="form-control input-sm" value="{{$pago->descrip_movimiento}}">
               				   </div>
               				 </div>
              				</div>
              				<br>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
									<a href="{{ route('pagos.index') }}" class="btn btn-info btn-block" >Atrás</a>
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