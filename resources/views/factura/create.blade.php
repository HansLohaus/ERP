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
          <h3 class="panel-title">Nuevo Factura</h3>
        </div>
        <div class="panel-body">          
          <div class="table-container">
            <form method="POST" action="{{ route('facturas.store') }}"  role="form">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Cliente/proveedor</label>
                    <select id="select1" class="form-control input-sm" >
                      <option>Seleccione</option>
                         <option value='1'>cliente</option>
                         <option value='2'>proveedor</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>-</label>
                    <select name="tipo_entidad_id" id="select2" class="form-control input-sm">
                      <option value="" hidden>Seleccione</option>
                      @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" data-tag='1'>{{ $cliente->entidad->nombre_fantasia }}</option>
                      @endforeach
                      @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" data-tag='2'>{{ $proveedor->entidad->nombre_fantasia }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
               <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Servicio</label>
                    <select name="servicio_id" id="servicio_id" class="form-control input-sm">
                      <option value="" selected hidden>Seleccione Servicio</option>
                      @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Folio</label>
                    <input type="number" name="folio" id="folio" class="form-control input-sm">
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
                    <label>Estado</label>
                    <select name="estado" id="estado" class="form-control input-sm" >
                         <option value="impago">impago</option>
                         <option value="pagado">pagado</option>
                         <option value="abono">abono</option>
                         <option value="anulado">anulado</option>
                       </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Tipo de DTE</label>
                    <select name="tipo_dte" id="tipo_dte" class="form-control input-sm" onChange="pagoOnChange(this)">
                      <option value="" selected hidden>Seleccione DTE</option>
                      <option value="33">33 (Factura electrónica)</option>
                      <option value="34">34 (Factura exenta electrónica)</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label>Monto Total</label>
                    <input type="number"min="0" max="999999999999" value="0" name="total_monto_total" id="total_monto_total" class="form-control input-sm" readonly>
                  </div>
                </div>
                <div id="neto" style="display:none;" class="col-xs-6 col-sm-6 col-md-6">
                  
                  <div class="form-group">
                    <label>Monto Neto</label>
                    <input type="number" min="0" max="999999999999" value="0" name="total_neto" id="total_neto" class="form-control input-sm sumar">
                  </div>
                
               
                  <div class="form-group">
                    <label>Monto del Iva</label>
                    <input type="number" min="0" max="999999999999" value="0" name="total_iva" id="total_iva" class="form-control input-sm sumar">
                  </div>
                
                </div>
                <div id="exento" style="display:none;"  class="col-xs-6 col-sm-6 col-md-6">
                 
                  <div class="form-group">
                    <label>Monto Exento</label>
                    <input type="number" min="0" max="999999999999" value="0" name="total_exento" id="total_exento" class="form-control input-sm sumar">
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
  $("input[type=submit]").on('click', function(event) {
      $(this).prop("disabled", true);
      $("form").submit();
  });   
</script>
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
  }); 
    $("#select2").val($("#select2 option:visible:first").val());
});
</script>
<script type="text/javascript">
  function pagoOnChange(sel) {
      if (sel.value=="33"){
           divC = document.getElementById("neto");
           divC.style.display="";

           divT = document.getElementById("exento");
           divT.style.display = "none";

      }else if(sel.value=="34"){

           divC = document.getElementById("neto");
           divC.style.display="none";

           divT = document.getElementById("exento");
           divT.style.display = "";
      }
}
</script>
<script>
//suma
items = document.getElementsByClassName("sumar")
for (var i = 0; i < items.length; i++) {
 items[i].addEventListener('change', function() {
  n = document.getElementById("total_monto_total");
  n.value = parseInt("0"+n.value) + parseInt("0"+this.value) - parseInt("0"+this.defaultValue);
 this.defaultValue = this.value;
 });
};
</script>
@endpush