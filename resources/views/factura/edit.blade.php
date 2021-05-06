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
                      <label>Cliente</label>
                      <select name="tipo_entidad_id" id="tipo_entidad_id" class="form-control input-sm">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{$cliente->id==$factura->tipo_entidad_id ?'selected':''}}>{{  ucfirst($cliente->entidad->nombre_fantasia) }}</option>
                        @endforeach
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{$proveedor->id==$factura->tipo_entidad_id ?'selected':''}}>{{  ucfirst($proveedor->entidad->nombre_fantasia) }}</option>
                        @endforeach
                      </select>
	             			</div>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label>Servicio</label>
                      <select name="servicio_id" id="servicio_id" class="form-control input-sm">
                        <option value="" hidden>Seleccione Servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}" {{$servicio->id==$factura->servicio_id ?'selected':''}}>{{  ucfirst($servicio->nombre)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
       					  <div class="col-xs-6 col-sm-6 col-md-6">
       					    <div class="form-group">
                    <label>Folio</label>
       					    <input type="number" name="folio" id="folio" class="form-control input-sm" value="{{$factura->folio}}">
       					    </div>
       					  </div>
         					<div class="col-xs-6 col-sm-6 col-md-6">
         					  <div class="form-group">
                      <label>Fecha de emisión</label>
         					    <input type="date" name="fecha_emision" id="fecha_emision" class="	form-control input-sm" value="{{$factura->fecha_emision}}">
         					  </div>
         					</div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <label>Estado</label>
                    <select name="estado" id="estado" class="form-control input-sm" >
                      <option value="pagado" {{$factura->estado=='pagado' ?'selected':''}}>Pagado</option>
                      <option value="impago" {{$factura->estado=='impago' ?'selected':''}}>Impago</option>
                      <option value="abono" {{$factura->estado=='abono' ?'selected':''}}>Abono</option>
                      <option value="anulado" {{$factura->estado=='anulado' ?'selected':''}}>Anulado</option>
                    </select>
                  </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label>Tipo de DTE</label>
                      <select name="tipo_dte" id="tipo_dte" class="form-control input-sm" onChange="pagoOnChange(this)">
                        <option value="33" {{$factura->tipo_dte==33 ?'selected':''}}>33</option>
                        <option value="34" {{$factura->tipo_dte==34 ?'selected':''}}>34</option>
                      </select>
                    </div>
                  </div>
                  <div id="neto" style="display:none;" class="col-xs-6 col-sm-6 col-md-6">
             				<div class="form-group">
                      <label>Monto Neto</label>
             					<input type="number" min="0" max="999999999999" name="total_neto" id="total_neto" class="form-control 	input-sm sumar" value="{{$factura->total_neto}}">
             				</div>
             			  <div class="form-group">
                      <label>Monto del Iva</label>
                      <input type="number" min="0" max="999999999999" name="total_iva" id="total_iva" class="form-control input-sm sumar" value="{{$factura->total_iva}}">
                    </div> 
                  </div>
                  <div id="exento" style="display:none;"  class="col-xs-6 col-sm-6 col-md-6">
             				<div class="form-group">
                      <label>Monto Exento</label>
                      <input type="number" min="0" max="999999999999" name="total_exento" id="total_exento" class="form-control input-sm sumar" value="{{$factura->total_exento}}">
                    </div>
                  </div>                                   
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                      <label>Monto Total</label>
                      <input type="number" min="0" max="999999999999" name="total_monto_total" id="total_monto_total" class=" form-control input-sm" value="{{$factura->total_monto_total}}" readonly>
                    </div>
                  </div>
              	</div>
                <br>
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
  function pagoOnChange(sel) {
      if (sel.value=="33"){

        $("#neto").show();
        $("#exento").hide();

      }else if(sel.value=="34"){

           $("#neto").hide();
        $("#exento").show();
      }
      $('#total_neto').val(0);
      $('#total_iva').val(0);
      $('#total_exento').val(0);
      $('#total_monto_total').val(0);
}
</script>
<script>
//suma
$('.sumar').on('change', function(event){
  var s =$(this).val();
  var n =$('#total_monto_total').val();
  s =parseInt(s !== '' ? s : '0');
  n =parseInt(n !== '' ? n : '0');
  $('#total_monto_total').val(s + n);
});
// items = document.getElementsByClassName("sumar")
// for (var i = 0; i < items.length; i++) {
//  items[i].addEventListener('change', function() {
//   n = document.getElementById("total_monto_total");
//   n.value = parseInt("0"+n.value) + parseInt("0"+this.value) - parseInt("0"+this.defaultValue);
//  this.defaultValue = this.value;
//  });
// };
</script>
@endpush