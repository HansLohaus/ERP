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
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="small-box bg-aqua text-center">
            <div class="inner">
              <h3 class="count">
                $<span id="sumatotal">0</span>
              </h3>
              <p>Total de Facturas</p>
              <h4 class="count" id="total">0</h4>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('totales')">Mostrar todo <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="small-box bg-green text-center">
            <div class="inner">
              <h3 class="count">
                $<span id="sumapagada">0</span>
              </h3>
              <p>Facturas pagadas</p>
              <h4 class="count" id="pagada">0</h4>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('pagados')">Filtrar <i class="fa fa-filter"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="small-box bg-yellow text-center">
            <div class="inner">
              <h3 class="count">
                $<span id="sumapendiente">0</span>
              </h3>
              <p>Facturas pendientes</p>
              <h4 class="count" id="pendiente">0</h4>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('pendientes')">Filtrar <i class="fa fa-filter"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-xs-12">
        <div class="small-box bg-red text-center">
            <div class="inner">
              <h3 class="count">
                $<span id="sumaanulada">0</span>
              </h3>
              <p>Facturas anuladas</p>
              <h4 class="count" id="anulada">0</h4>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="filtrarPor('anuladas')">Filtrar <i class="fa fa-filter"></i></a>
        </div>
    </div>
</div>
<div class="input-group">
    <div class="input-group-append">
        <span class="input-group-text"><span class="fa fa-filter"></span></span>
    </div>
    <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
    {{-- <div class="input-group-append">
      <select class="btn btn-success" type="button" name="select">
        <option value="todos">todos</option>
        <option value="2021">2021</option>
        <option value="2020">2020</option>
        <option value="2019">2019</option>
      </select>
    </div> --}}
</div>
<br>
   <div class="pull-right">
    <div class="btn-group">
      <a href="{{ route('facturas.create') }}" class="btn btn-info" >Añadir Factura</a>
    </div>
    {{-- <div class="btn-group">
      <a href="{{ route('facturas.import') }}" class="btn btn-info" >Carga masiva</a>
    </div> --}}
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
                    <form action="{{ route('facturas.import') }}" method="POST" enctype="multipart/form-data">
                      <h4>Cargar Datos:</h4>
                      <input type="file" class="form-control" name="file" accept=".csv" required>
                      <label>.</label>
                      <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                      </div>
                      <br>
                      <div class="pull-right"><button class="btn btn-info" type="submit">Cargar Datos</button></div>
                      {{ csrf_field() }}
                    </form>
                  </div>
              </div>
          </div>
      </div>
     {{-- fin popup masivo--}}
    </div>
    <div class="btn-group">
      <a href="#" class="btn btn-info" data-toggle="modal" data-target="#descarga">Descarga Masiva</a>
      {{-- popup descarga--}}
      <div class="modal fade" id="descarga">
          <div class="modal-dialog modal-xl">
               <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                    </button>
                  <h4>Cerrar</h4>
                  </div>
                  <div class="modal-body">
                    <form action="{{ route('facturas.export') }}" method="POST" >
                      {{ csrf_field() }}
                      <div class="pull-left"><button class="btn btn-info" type="submit">Descargar Clientes</button></div>
                    </form>
                  </div>
              </div>
          </div>
      </div>
     {{-- fin popup descarga--}}
    </div>
 </div>
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
                  <th>Folio</th>
                  <th>Tipo de DTE</th>
                  <th>Fecha de emisión</th>
                  <th>Monto Neto</th>
                  <th>Monto Exento</th>
                  <th>Monto del Iva</th>
                  <th>Monto Total</th>
                  <th>Estado</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($facturas_clientes->count())  
              @foreach($facturas_clientes as $factura)  
              <tr>
                <td>{{$factura->cliente->entidad->nombre_fantasia}}</td>
                <td>{{$factura->servicio ? $factura->servicio->nombre : ''}}</td>
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
                  <th>Folio</th>
                  <th>Tipo de DTE</th>
                  <th>Fecha de emisión</th>
                  <th>Monto Neto</th>
                  <th>Monto Exento</th>
                  <th>Monto del Iva</th>
                  <th>Monto Total</th>
                  <th>Estado</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($facturas_proveedores->count())  
              @foreach($facturas_proveedores as $factura)  
              <tr>
                <td>{{$factura->proveedor->entidad->nombre_fantasia}}</td>
                <td>{{$factura->servicio ? $factura->servicio->nombre : ''}}</td>
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
    "iDisplayLength": 1000,
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
    "iDisplayLength": 1000,
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
    "pendientes" : false,
    "anuladas" : false
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
        filtro_array.anuladas=false;
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
            $('#anulada').html(response.anuladas);
            $('#sumatotal').html(response.format_totales);
            $('#sumapagada').html(response.format_pagadas);
            $('#sumapendiente').html(response.format_pendientes);
            $('#sumaanulada').html(response.format_anuladas);
        }
    });
}
actualizarContadores('cliente');
</script>

@endpush