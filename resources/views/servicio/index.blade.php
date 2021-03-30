@extends("app.main")

{{-- Cabecera --}}
@section("title","Servicios")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Servicios")
@section("breadcrumb")
    <li class="breadcrumb-item active">Servicio</li>

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
    <a href="{{ route('servicios.create') }}" class="btn btn-info" >Añadir Servicios</a>
  </div>
</div>
  <nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-cliente-tab" data-toggle="tab" href="#nav-cliente" role="tab" aria-controls="nav-cliente" aria-selected="true">Cliente</a>
    <a class="nav-item nav-link" id="nav-proveedor-tab" data-toggle="tab" href="#nav-proveedor" role="tab" aria-controls="nav-proveedor" aria-selected="false">Proveedor</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
    {{-- nav cliente --}}
    <div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Servicios Clientes</h3></div>
          <div class="table-container">
            <table id="tabla-cliente" class="table table-bordred table-striped">
              <thead>
                  <th>Cliente</th>
                  <th>Servicio</th>
                  <th>Fecha de inicio</th>
                  <th>Fecha de fin</th>
                  <th>Tipo de servicio</th>
                  <th>Estado del servicio</th>
                  <th>Numero de propuesta</th>
                  <th>Condicion de pago</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($servicios_clientes->count())  
              @foreach($servicios_clientes as $servicio)  
              <tr>
                <td>{{$servicio->cliente->entidad->nombre_fantasia}}</td>
                <td>{{$servicio->nombre}}</td>
                <td>{{ date_format(date_create($servicio->fecha_inicio),"d-m-Y") }}</td>
                <td>{{ date_format(date_create($servicio->fecha_fin),"d-m-Y") }} </td>
                <td>{{$servicio->tipo}}</td>
                <td>{{$servicio->estado}}</td>
                <td>{{$servicio->numero_propuesta}}</td>
                <td>{{$servicio->condicion_pago}}</td>
                <td><a class="btn btn-primary" href="{{action('ServicioController@edit', $servicio->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('ServicioController@destroy', $servicio->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todas las facturas asociados al servicio ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
    {{-- fin nav cliente --}}
  </div>
  <div class="tab-pane fade" id="nav-proveedor" role="tabpanel" aria-labelledby="nav-proveedor-tab">
    {{-- nav proveedor --}}
    <div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Servicios Proveedores</h3></div>
          <div class="table-container">
            <table id="tabla-proveedor" class="table table-bordred table-striped">
              <thead>
                  <th>Proveedor</th>
                  <th>Servicio</th>
                  <th>Fecha de inicio</th>
                  <th>Fecha de fin</th>
                  <th>Tipo de servicio</th>
                  <th>Estado del servicio</th>
                  <th>Numero de propuesta</th>
                  <th>Condicion de pago</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($servicios_proveedores->count())  
              @foreach($servicios_proveedores as $servicio)
              <tr>
                <td>{{$servicio->proveedor->entidad->nombre_fantasia}}</td>
                <td>{{$servicio->nombre}}</td>
                <td>{{ date_format(date_create($servicio->fecha_inicio),"d-m-Y") }}</td>
                <td>{{ date_format(date_create($servicio->fecha_fin),"d-m-Y") }} </td>
                <td>{{$servicio->tipo}}</td>
                <td>{{$servicio->estado}}</td>
                <td>{{$servicio->numero_propuesta}}</td>
                <td>{{$servicio->condicion_pago}}</td>
                <td><a class="btn btn-primary" href="{{action('ServicioController@edit', $servicio->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('ServicioController@destroy', $servicio->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todas las facturas asociados al servicio ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
  var datatable_tabla1 = $("#tabla-cliente").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay servicios en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran servicios para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});
// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
    datatable_tabla1.fnFilter(this.value);
});
</script>
<script>
  var datatable_tabla2 = $("#tabla-proveedor").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay servicios en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran servicios para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});
// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
    datatable_tabla2.fnFilter(this.value);
});
</script>
<script type="text/javascript"> 
</script>
@endpush

