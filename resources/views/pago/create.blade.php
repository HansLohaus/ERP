@extends("app.main")

{{-- Cabecera --}}
@section("title","Pagos")
@push("header")
<link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
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
                              <select name="factura_id[]" id="factura_id" class="form-control input-sm select2 select2-multiple fid" multiple>
                                @foreach ($facturas_clientes as $factura)
                                <option value="{{ $factura->id }}">{{ $factura->folio}}</option>
                                @endforeach
                              </select>
                        </div>
                      </div>
                      <div class="col-xs-6 col-sm-6 col-md-6">
                          <div class="form-group">
                              <label>Descripción de la boleta/liquidacion</label>
                              <select name="boleta_liquidacion_id" id="boleta_liquidacion_id" class="form-control input-sm">
                                  @foreach ($boletasliquidaciones as $boliq)
                                      <option value="{{ $boliq->id }}">{{ $boliq->descripcion}}</option>
                                  @endforeach
                              </select>
                        </div>
                      </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Ingreso/Egreso</label>
                  <select name="pago" id="ine" class="form-control input-sm">
                       <option value="A">ingreso</option>
                       <option value="C">egreso</option>
                     </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Fecha de pago</label>
                  <input type="date" name="fecha" id="fecha" class="form-control input-sm">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Monto del pago</label>
                  <input type="number" name="monto" id="monto" class="form-control input-sm">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descripción del movimiento</label>
                  <input type="text" name="descrip_movimiento" id="descrip_movimiento" class="form-control input-sm">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Número de documento</label>
                  <input type="text" name="n_doc" id="n_doc" class="form-control input-sm">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Sucursal</label>
                  <input type="text" name="sucursal" id="sucursal" class="form-control input-sm">
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
  $("#factura_id").on("change", function(){
    let monto = $(this).find('option:selected').data('monto');
    $("#monto").val(monto);
  });
</script>
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script type="text/javascript"> 
  $(".select2").select2();
</script>
<script type="text/javascript">
  $("input[type=submit]").on('click', function(event) {
      $(this).prop("disabled", true);
      $("form").submit();
  });   
</script>
@endpush