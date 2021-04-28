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
                  <label>Folio de la factura</label>
                  @php
                   $facturas_id= $pago->facturas->pluck('id')->toArray();
                  @endphp
                  <select name="factura_id[]" id="factura_id" class="form-control input-sm select2 select2-multiple fid" multiple>
                    @foreach ($facturas_clientes as $factura)
                    <option value="{{ $factura->id }}" {{in_array($factura->id, $facturas_id)?'selected':''}}>{{ $factura->folio}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Descripción de la boleta/liquidacion</label>
                  @php
                   $boletas_id= $pago->boletas->pluck('id')->toArray();
                  @endphp
                  <select name="boleta_liquidacion_id[]" id="boleta_liquidacion_id" class="form-control input-sm select2 select2-multiple fid" multiple>
                      @foreach ($boletasliquidaciones as $boliq)
                          <option value="{{ $boliq->id }}" {{in_array($boliq->id, $boletas_id)?'selected':''}}>{{ $boliq->descripcion}}</option>
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
     				      <input type="date" name="fecha" id="fecha" class="form-control input-sm" value="{{$pago->fecha}}">
     				    </div>
     				  </div>
     				  <div class="col-xs-6 col-sm-6 col-md-6">
     				    <div class="form-group">
     				    	<label>Monto del pago</label>
     				      <input type="number" name="monto" id="monto" class="form-control input-sm" value="{{$pago->monto}}">
     				    </div>
     				  </div>
     				  <div class="col-xs-6 col-sm-6 col-md-6">
     				    <div class="form-group">
     				    	<label>Descripción del movimiento</label>
     				      <input type="text" name="descrip_movimiento" id="descrip_movimiento" class="form-control input-sm" value="{{$pago->descrip_movimiento}}">
     				    </div>
     				  </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Número de documento</label>
                  <input type="text" name="n_doc" id="n_doc" class="form-control input-sm" value="{{$pago->n_doc}}">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label>Sucursal</label>
                  <input type="text" name="sucursal" id="sucursal" class="form-control input-sm" value="{{$pago->sucursal}}">
                </div>
              </div>





              {{-- <div class="col-xs-6 col-sm-6 col-md-6">
              <div class="form-group">
                <font size="5">Facturas Relacionadas</font>
                <table id="table_1" class="table-striped" border="1" width="100%">
                  <thead class="table-primary">
                    <th></th>
                    <th>Folio</th>
                    <th>Tipo de DTE</th>
                    <th>Fecha de emisión</th>
                    <th>Monto Neto</th>
                    <th>Monto Exento</th>
                    <th>Monto del Iva</th>
                    <th>Monto Total</th>
                    <th>Estado</th>
                    <th></th>
                  </thead>
                  <tbody>
                    @if($facturas->count()) 
                      @foreach($pago->facturas as $factura)
                      <tr>
                        <td><i class="fa fa-arrow-circle-left move-left" alt='MoveLeft' aria-hidden="true"></i></td>
                        <td>{{$factura->folio}}</td>
                        <td>{{$factura->tipo_dte}}</td>
                        <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
                        <td>{{(number_format($factura->total_neto))}}</td>
                        <td>{{(number_format($factura->total_exento))}}</td>
                        <td>{{(number_format($factura->total_iva))}}</td>
                        <td>{{(number_format($factura->total_monto_total))}}</td>
                        <td>{{$factura->estado}}</td>
                        <td><i class="fa fa-arrow-circle-right move-right" alt='MoveRight' aria-hidden="true"></i></td>
                      </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <font size="5">Facturas para agregar</font>
                  <table id="table_2" class="table-striped" border="1"  width="100%">
                    <thead class="table-primary" >
                      <th></th>
                      <th>Folio</th>
                      <th>Tipo de DTE</th>
                      <th>Fecha de emisión</th>
                      <th>Monto Neto</th>
                      <th>Monto Exento</th>
                      <th>Monto del Iva</th>
                      <th>Monto Total</th>
                      <th>Estado</th>
                      <th></th>
                    </thead>
                    <tbody>
                      @if($facturas->count())  
                        @foreach($facturas as $factura)  
                          <tr>
                            <td><i class="fa fa-arrow-circle-left move-left" alt='MoveLeft' aria-hidden="true"></i></td>
                            <td>{{$factura->folio}}</td>
                            <td>{{$factura->tipo_dte}}</td>
                            <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
                            <td>{{(number_format($factura->total_neto))}}</td>
                            <td>{{(number_format($factura->total_exento))}}</td>
                            <td>{{(number_format($factura->total_iva))}}</td>
                            <td>{{(number_format($factura->total_monto_total))}}</td>
                            <td>{{$factura->estado}}</td>
                            <td><i class="fa fa-arrow-circle-right move-right" alt='MoveRight' aria-hidden="true"></i></td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div --}}>




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
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script type="text/javascript"> 
  $(".select2").select2();
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#table_1").on("click","i.move-right", function() {
        var tr = $(this).closest("tr").remove().clone();
        tr.find("i.move-right")
            .attr("alt", "MoveRight");
        $("#table_2 tbody").append(tr);
    });
    $("#table_2").on("click","i.move-left", function() {
        var tr = $(this).closest("tr").remove().clone();
        tr.find("i.move-left")
            .attr("alt", "MoveLeft");
        $("#table_1 tbody").append(tr);
    });
});
</script>
@endpush