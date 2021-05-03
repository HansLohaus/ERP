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
                    <label>Trabajador</label>
                    <select name="trabajador_id" id="trabajador_id" class="form-control input-sm">
                      <option value="" hidden>Seleccione trabajador</option>
                      @foreach ($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}" {{$trabajador->id==$boletaliquidacion->trabajador_id ?'selected':''}}>{{$trabajador->nombres}} {{$trabajador->apellidoP}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descripción</label>
                  <input type="text" name="descripcion" id="descripcion" class="form-control input-sm" value="{{$boletaliquidacion->descripcion}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Monto total</label>
                  <input type="number" min="0" max="999999999999" name="monto_total" id="monto_total" class="form-control input-sm" value="{{$boletaliquidacion->monto_total}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Monto líquido</label>
                  <input type="number" min="0" max="999999999999" name="monto_liquido" id="monto_liquido" class="form-control input-sm" value="{{$boletaliquidacion->monto_liquido}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Tipo</label>
                  <select name="boleta_liq" id="boleta_liq" class="form-control input-sm" >
                    <option value="{{$boletaliquidacion->boleta_liq}}" {{$boletaliquidacion->boleta_liq==$boletaliquidacion->boleta_liq ?'selected':''}} hidden>{{$boletaliquidacion->boleta_liq}}</option>
                      {{-- <option value="{{$boletaliquidacion->boleta_liq}}">{{$boletaliquidacion->boleta_liq}} (Seleccionado)</option> --}}
                         <option value="liquidacion">Liquidación</option>
                         <option value="boleta">Boleta</option>
                       </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Sueldo base</label>
                  <input type="number" min="0" max="999999999999" name="sueldo_base" id="sueldo_base" class="form-control input-sm" value="{{$boletaliquidacion->sueldo_base}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Gratificaciones</label>
                  <input type="number" min="0" max="999999999999" name="gratificaciones" id="gratificaciones" class="form-control input-sm" value="{{$boletaliquidacion->gratificaciones}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Días trabajados</label>
                  <input type="number" min="0" max="999999999999" name="dias_trabajados" id="dias_trabajados" class="form-control input-sm" value="{{$boletaliquidacion->dias_trabajados}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descuento isapre</label>
                  <input type="number" min="0" max="999999999999" name="desc_isapre" id="desc_isapre" class="form-control input-sm" value="{{$boletaliquidacion->desc_isapre}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descuento afp</label>
                  <input type="number" min="0" max="999999999999" name="desc_afp" id="desc_afp" class="form-control input-sm" value="{{$boletaliquidacion->desc_afp}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descuento seguro cesantía</label>
                  <input type="number" min="0" max="999999999999" name="desc_seguro_cesantia" id="desc_seguro_cesantia" class="form-control input-sm" value="{{$boletaliquidacion->desc_seguro_cesantia}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Impuesto único</label>
                  <input type="number" min="0" max="999999999999" name="impuesto_unico" id="impuesto_unico" class="form-control input-sm" value="{{$boletaliquidacion->impuesto_unico}}">
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