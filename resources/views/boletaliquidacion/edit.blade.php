@extends("app.main")

{{-- Cabecera --}}
@section("title","BoletasLiquidaciones")
@push("header")
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","BoletasLiquidaciones")
@section("breadcrumb")
    <li class="breadcrumb-item">BoletasLiquidaciones</li>
    <li class="breadcrumb-item active">Editar boletaliquidacion</li>
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
	  	<h3 class="panel-title">Editar boletaliquidacion</h3>
	  	</div>
	  	<div class="panel-body">					
	  		<div class="table-container">
	  			<form method="POST" action="{{ route('boletasliquidaciones.update',$boletaliquidacion->id) }}"  role="form">
	  			{{ csrf_field() }}
	  			<input name="_method" type="hidden" value="PATCH">
	  				<div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
              	<div class="form-group">
                 	<label>trabajador_id</label>
                 	<input type="text" name="trabajador_id" id="trabajador_id" class="form-control input-sm" value="{{$boletaliquidacion->trabajador_id}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>descripcion</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control input-sm" value="{{$boletaliquidacion->descripcion}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>monto_total</label>
                  <input type="text" name="monto_total" id="monto_total" class="form-control input-sm" value="{{$boletaliquidacion->monto_total}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>monto_liquido</label>
                  <input type="text" name="monto_liquido" id="monto_liquido" class="form-control input-sm" value="{{$boletaliquidacion->monto_liquido}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>boleta_liq</label>
                  <select name="boleta_liq" id="boleta_liq" class="form-control input-sm" >
                    <option>{{$boletaliquidacion->boleta_liq}}</option>
                         <option value="liquidacion">liquidacion</option>
                         <option value="boleta">boleta</option>
                       </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>sueldo_base</label>
                  <input type="text" name="sueldo_base" id="sueldo_base" class="form-control input-sm" value="{{$boletaliquidacion->sueldo_base}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>gratificaciones</label>
                  <input type="text" name="gratificaciones" id="gratificaciones" class="form-control input-sm" value="{{$boletaliquidacion->gratificaciones}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>dias_trabajados</label>
                  <input type="text" name="dias_trabajados" id="dias_trabajados" class="form-control input-sm" value="{{$boletaliquidacion->dias_trabajados}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>desc_isapre</label>
                  <input type="text" name="desc_isapre" id="desc_isapre" class="form-control input-sm" value="{{$boletaliquidacion->desc_isapre}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>desc_afp</label>
                  <input type="text" name="desc_afp" id="desc_afp" class="form-control input-sm" value="{{$boletaliquidacion->desc_afp}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>desc_seguro_cesantia</label>
                  <input type="text" name="desc_seguro_cesantia" id="desc_seguro_cesantia" class="form-control input-sm" value="{{$boletaliquidacion->desc_seguro_cesantia}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>impuesto_unico</label>
                  <input type="text" name="impuesto_unico" id="impuesto_unico" class="form-control input-sm" value="{{$boletaliquidacion->impuesto_unico}}">
                </div>
              </div>
            </div>
            <br>
	  				<div class="row">
	  					<div class="col-xs-12 col-sm-12 col-md-12">
	  						<input type="submit"  value="Actualizar" class="btn btn-success btn-block">
	  						<a href="{{ route('boletasliquidaciones.index') }}" class="btn btn-info btn-block" >Atrás</a>
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