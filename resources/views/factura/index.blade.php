@extends("app.main")

{{-- Cabecera --}}
@section("title","Facturas")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Facturas")
@section("breadcrumb")
    <li class="breadcrumb-item active">Factura</li>
@endsection
{{-- Contenido --}}
@section("content")
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"><span class="fa fa-filter"></span></span>
    </div>
    <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
</div>
<br>
   <div class="pull-right">
    <div class="btn-group">
      <a href="{{ route('facturas.create') }}" class="btn btn-info" >Añadir Facturas</a>
    </div>
    <div class="btn-group">
      <a href="#" class="btn btn-info" data-toggle="modal" data-target="#masivo">Carga Masiva</a>
      {{-- popup masivo--}}
      <div class="modal fade" id="masivo">
          <div class="modal-dialog modal-xl">
               <div class="modal-content">
                  <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">
                  <span>×</span>
                  </button>
                  <h4>Cerrar</h4>
                  </div>
                  <div class="modal-body">
                  </div>
              </div>
          </div>
      </div>
     {{-- fin popup masivo--}}
    </div>
 </div>
          {{-- <div class="table-container">
            <table id="tabla-logs" class="table table-bordred table-striped" cellspacing="0">
            	<thead>
               		<th>id del cliente</th>
               		<th>id del servicio</th>
               		<th>folio</th>
               		<th>tipo de dte</th>
               		<th>fecha de emision</th>
               		<th>total monto neto</th>
               		<th>total monto exento</th>
               		<th>total del iva</th>
                  <th>monto total</th>
                  <th>estado</th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
              @if($facturas->count())  
              @foreach($facturas as $factura)  
              <tr>
              	<td>{{$factura->tipo_entidad_id}}</td>
                <td>{{$factura->servicio_id}}</td>
                <td>{{$factura->folio}}</td>
                <td>{{$factura->tipo_dte}}</td>
                <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
                <td>{{(number_format($factura->total_neto))}}</td>
                <td>{{(number_format($factura->total_exento))}}</td>
                <td>{{(number_format($factura->total_iva))}}</td>
                <td>{{(number_format($factura->total_monto_total))}}</td>
                <td>{{$factura->estado}}</td>
                <td><a class="btn btn-primary" href="{{action('FacturaController@edit', $factura->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('FacturaController@destroy', $factura->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
                 </td>
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div> --}}
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-cliente-tab" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente" aria-selected="true">Cliente</a>
    <a class="nav-item nav-link" id="nav-proveedor-tab" data-toggle="tab" href="#nav-proveedor" role="tab" aria-controls="nav-proveedor" aria-selected="false">Proveedor</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
    {{-- nav clientes --}}
    <div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Facturas</h3></div>
    <div class="table-container">
            <table id="tabla-cliente" class="table table-bordred table-striped" cellspacing="0">
              <thead>
                  <th>Cliente</th>
                  <th>id del servicio</th>
                  <th>folio</th>
                  <th>tipo de dte</th>
                  <th>fecha de emision</th>
                  <th>total monto neto</th>
                  <th>total monto exento</th>
                  <th>total del iva</th>
                  <th>monto total</th>
                  <th>estado</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($facturas_clientes->count())  
              @foreach($facturas_clientes as $factura)  
              <tr>
                <td>{{$factura->cliente->entidad->razon_social}}</td>
                <td>{{$factura->servicio_id}}</td>
                <td>{{$factura->folio}}</td>
                <td>{{$factura->tipo_dte}}</td>
                <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
                <td>{{(number_format($factura->total_neto))}}</td>
                <td>{{(number_format($factura->total_exento))}}</td>
                <td>{{(number_format($factura->total_iva))}}</td>
                <td>{{(number_format($factura->total_monto_total))}}</td>
                <td>{{$factura->estado}}</td>
                <td><a class="btn btn-primary" href="{{action('FacturaController@edit', $factura->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('FacturaController@destroy', $factura->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todos los pagos asociados a la factura, ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
                 </td>
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        </div>
    </div>
  </div>
  {{-- fin nav clientes --}}
  </div>
  <div class="tab-pane fade" id="nav-proveedor" role="tabpanel" aria-labelledby="nav-proveedor-tab">
    {{-- nav proveedor --}}
    <div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Facturas</h3></div>
    <div class="table-container">
            <table id="tabla-proveedor" class="table table-bordred table-striped" cellspacing="0">
              <thead>
                  <th>Proveedor</th>
                  <th>id del servicio</th>
                  <th>folio</th>
                  <th>tipo de dte</th>
                  <th>fecha de emision</th>
                  <th>total monto neto</th>
                  <th>total monto exento</th>
                  <th>total del iva</th>
                  <th>monto total</th>
                  <th>estado</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($facturas_proveedores->count())  
              @foreach($facturas_proveedores as $factura)  
              <tr>
                <td>{{$factura->proveedor->entidad->razon_social}}</td>
                <td>{{$factura->servicio_id}}</td>
                <td>{{$factura->folio}}</td>
                <td>{{$factura->tipo_dte}}</td>
                <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
                <td>{{(number_format($factura->total_neto))}}</td>
                <td>{{(number_format($factura->total_exento))}}</td>
                <td>{{(number_format($factura->total_iva))}}</td>
                <td>{{(number_format($factura->total_monto_total))}}</td>
                {{--  <td>{{(number_format(($factura->total_neto)+($factura->total_iva)))}}</td> --}}
                <td>{{$factura->estado}}</td>
                <td><a class="btn btn-primary" href="{{action('FacturaController@edit', $factura->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('FacturaController@destroy', $factura->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todos los pagos asociados a la factura, ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
                 </td>
               </tr>
               @endforeach 
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
        </div>
    </div>
  </div>
  {{-- fin nav proveedor --}}
  </div>
</div>
@endsection
@push("scripts")
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  var datatable_tabla1 = $("#tabla-cliente").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay facturas en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran facturas para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});

var datatable_tabla2 = $("#tabla-proveedor").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay facturas en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran facturas para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});
// Evento para el filtro
  $("#tabla-filtro").on("keyup change",function(){
    datatable_tabla1.fnFilter(this.value);
});

  $("#tabla-filtro").on("keyup change",function(){
    datatable_tabla2.fnFilter(this.value);
});
</script>
<script type="text/javascript">
@endpush