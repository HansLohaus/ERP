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



<div class="row">
    <div class="col-lg-4 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua text-center">
            <div class="inner">
                <h3 class="count" id="total">0</h3>
                    <p>Total de Facturas</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('totales')">Mostrar todo <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-xs-12">
        <div class="small-box bg-red text-center">
            <div class="inner">
                <h3 class="count" id="pagada">0</h3>
                <p>Facturas pagadas</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('pagados')">Filtrar <i class="fa fa-filter"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6 col-xs-12">
        <div class="small-box bg-yellow text-center">
            <div class="inner">
                <h3 class="count" id="pendiente">0</h3>
                <p>Facturas pendientes</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('pendientes')">Filtrar <i class="fa fa-filter"></i></a>
        </div>
    </div>
</div>




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
    <a class="nav-item nav-link active" id="nav-cliente-tab" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente" aria-selected="true" onclick="actualizarContadores('cliente')">Cliente</a>
    <a class="nav-item nav-link" id="nav-proveedor-tab" data-toggle="tab" href="#nav-proveedor" role="tab" aria-controls="nav-proveedor" aria-selected="false" onclick="actualizarContadores('proveedor')">Proveedor</a>
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
                  <th>Servicio</th>
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
                <td>{{$factura->cliente->entidad->nombre_fantasia}}</td>
                <td>{{$factura->servicio->nombre}}</td>
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
                  </form>
                 </td>
               </tr>
               @endforeach
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
                  <th>Servicio</th>
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
                <td>{{$factura->proveedor->entidad->nombre_fantasia}}</td>
                <td>{{$factura->servicio->nombre}}</td>
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
                 </form>
                 </td>
               </tr>
               @endforeach 
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
  var datatable_tabla1 = $("#tabla-cliente").DataTable({
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

var datatable_tabla2 = $("#tabla-proveedor").DataTable({
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
    datatable_tabla1.search(this.value).draw();
});

  $("#tabla-filtro").on("keyup change",function(){
    datatable_tabla2.search(this.value).draw();
});
</script>
<script type="text/javascript">
// Filtros
var filtro_array = {
    "pagados" : false,
    "pendientes" : false
};
// Funcion para filtrar
function filtrarPor(tipo, valor) {
    if (typeof valor == 'undefined'){
      if (tipo !=='totales'){
        if (filtro_array.hasOwnProperty(tipo)){
          filtro_array[tipo]= !filtro_array[tipo];
          update_datatable();
        }
      }else{
        filtro_array.pagados=false;
        filtro_array.pendientes=false;
        update_datatable();
      }
    }
};

function update_datatable(){
  $.ajax({
    url: "{{route('facturas.index')}}",
    type: 'GET',
    dataType: 'json',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      filtros: filtro_array
    },
    success: function(response){
      datatable_tabla1.clear();
      datatable_tabla2.clear();
      if (response.hasOwnProperty('facturas_clientes')){
        $.each(response.facturas_clientes, function(){
          datatable_tabla1.row.add([
            this.cliente.entidad.nombre_fantasia,
            this.servicio.nombre,
            this.folio,
            this.tipo_dte,
            this.fecha_emision,
            this.total_neto,
            this.total_exento,
            this.total_iva,
            this.total_monto_total,
            this.estado,
            this.edit,
            this.delete
          ]);
        });
        datatable_tabla1.draw();
      }
      if (response.hasOwnProperty('facturas_proveedores')){
        $.each(response.facturas_proveedores, function(){
          datatable_tabla2.row.add([
            this.proveedor.entidad.nombre_fantasia,
            this.servicio.nombre,
            this.folio,
            this.tipo_dte,
            this.fecha_emision,
            this.total_neto,
            this.total_exento,
            this.total_iva,
            this.total_monto_total,
            this.estado,
            this.edit,
            this.delete
          ]);
        });
        datatable_tabla2.draw();
      }
    }
  })
}
function actualizarContadores(tipo){
    $.ajax({
        url: "{{route('facturas.index')}}",
        type: 'GET',
        dataType: 'json',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          totales: tipo
        },
        success: function(response){
            $('#total').html(response.facturas);
            $('#pagada').html(response.pagadas);
            $('#pendiente').html(response.pendientes);
        }
    });
}

actualizarContadores('cliente');
</script>

@endpush