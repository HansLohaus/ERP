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
    <li class="breadcrumb-item active">Nuevo BoletaLiquidacion</li>
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
          <h3 class="panel-title">Nuevo BoletaLiquidacion</h3>
        </div>
        <div class="panel-body">          
          <div class="table-container">
            <form method="POST" action="{{ route('boletasliquidaciones.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Trabajador</label>
                    <select name="trabajador_id" id="trabajador_id" class="form-control input-sm">
                      <option value=""  hidden>Seleccione trabajador</option>
                      @foreach ($trabajadores as $trabajador)
                        <option value="{{ $trabajador->id }}">{{$trabajador->nombres}} {{$trabajador->apellidoP}}</option>
                      @endforeach
                    </select>
                    {{-- <label>Id del Cliente</label>
                    <input type="text" name="tipo_entidad_id" id="tipo_entidad_id" class="form-control input-sm"> --}}
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto total</label>
                    <input type="number" name="monto_total" id="monto_total" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto líquido</label>
                    <input type="number" name="monto_liquido" id="monto_liquido" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Tipo</label>
                    <select name="boleta_liq" id="boleta_liq" class="form-control input-sm" >
                         <option value="liquidacion">Liquidación</option>
                         <option value="boleta">Boleta</option>
                       </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Sueldo base</label>
                    <input type="number" name="sueldo_base" id="sueldo_base" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Gratificaciones</label>
                    <input type="number" name="gratificaciones" id="gratificaciones" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Días trabajados</label>
                    <input type="number" name="dias_trabajados" id="dias_trabajados" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descuento isapre</label>
                    <input type="number" name="desc_isapre" id="desc_isapre" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descuento afp</label>
                    <input type="number" name="desc_afp" id="desc_afp" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descuento seguro cesantía</label>
                    <input type="number" name="desc_seguro_cesantia" id="desc_seguro_cesantia" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Impuesto único</label>
                    <input type="number" name="impuesto_unico" id="impuesto_unico" class="form-control input-sm">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <input type="submit"  value="Guardar" class="btn btn-success btn-block">
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