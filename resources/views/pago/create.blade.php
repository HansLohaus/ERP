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
    <li class="breadcrumb-item active">Nuevo Pago</li>
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
          <h3 class="panel-title">Nuevo Pago</h3>
        </div>
        <div class="panel-body">          
          <div class="table-container">
            <form method="POST" action="{{ route('pagos.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
               <div class="col-xs-6 col-sm-6 col-md-6">
                          <div class="form-group">
                              <label>Folio de la factura</label>
                              <select name="factura_id" id="factura_id" class="form-control input-sm">
                                  <option value="" disabled hidden>Seleccione Folio</option>
                                  @foreach ($facturas as $factura)
                                      <option value="{{ $factura->id }}">{{ $factura->folio}}</option>
                                  @endforeach
                              </select>
                        </div>
                      </div>

                      <div class="col-xs-6 col-sm-6 col-md-6">
                          <div class="form-group">
                              <label>Descripción de la boleta/liquidacion</label>
                              <select name="boleta_liquidacion_id" id="boleta_liquidacion_id" class="form-control input-sm">
                                  <option value="" disabled hidden>Seleccione Folio</option>
                                  @foreach ($boletasliquidaciones as $boliq)
                                      <option value="{{ $boliq->id }}">{{ $boliq->descripcion}}</option>
                                  @endforeach
                              </select>
                        </div>
                      </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Ingreso/Egreso</label>
                    <select name="ine" id="ine" class="form-control input-sm">
                         <option value="ingreso">ingreso</option>
                         <option value="egreso">egreso</option>
                       </select>
                  </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Fecha de pago</label>
                    <input type="date" name="fecha_pago" id="fecha_pago" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto del pago</label>
                    <input type="text" name="monto" id="monto" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto total de transferencia</label>
                    <input type="text" name="monto_total_transf" id="monto_total_transf" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Descripción del movimiento</label>
                    <input type="text" name="descrip_movimiento" id="descrip_movimiento" class="form-control input-sm">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <input type="submit"  value="Guardar" class="btn btn-success btn-block">
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