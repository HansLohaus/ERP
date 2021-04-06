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
    <li class="breadcrumb-item active">Nuevo Factura</li>
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
          <h3 class="panel-title">Nuevo Factura</h3>
        </div>
        <div class="panel-body">          
          <div class="table-container">
            <form method="POST" action="{{ route('facturas.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Cliente</label>
                    <select name="tipo_entidad_id" id="tipo_entidad_id" class="form-control input-sm">
                      <option value="" disabled hidden>Seleccione cliente</option>
                      @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->entidad->nombre_fantasia }}</option>
                      @endforeach
                    </select>
                    {{-- <label>Id del Cliente</label>
                    <input type="text" name="tipo_entidad_id" id="tipo_entidad_id" class="form-control input-sm"> --}}

                  </div>
                </div>


               <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Servicio</label>
                    <select name="servicio_id" id="servicio_id" class="form-control input-sm">
                      <option value="" disabled hidden>Seleccione Servicio</option>
                      @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                {{-- <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>id del servicio</label>
                    <input type="text" name="servicio_id" id="servicio_id" class="form-control input-sm">
                  </div>
                </div> --}}
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Folio</label>
                    <input type="text" name="folio" id="folio" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Tipo de DTE</label>
                    <input type="text" name="tipo_dte" id="tipo_dte" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Fecha de emisión</label>
                    <input type="date" name="fecha_emision" id="fecha_emision" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto Neto</label>
                    <input type="text" name="total_neto" id="total_neto" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto Exento</label>
                    <input type="text" name="total_exento" id="total_exento" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto del Iva</label>
                    <input type="text" name="total_iva" id="total_iva" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto Total</label>
                    <input type="text" name="total_monto_total" id="total_monto_total" class="form-control input-sm">
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Estado</label>
                    <select name="estado" id="estado" class="form-control input-sm" >
                         <option value="pagado">pagado</option>
                         <option value="impago">impago</option>
                         <option value="abono">abono</option>
                         <option value="anulado">anulado</option>
                       </select>
                    {{-- <input type="text" name="estado" id="estado" class="form-control input-sm" placeholder="estado del servicio"> --}}
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                  <input type="submit"  value="Guardar" class="btn btn-success btn-block">
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