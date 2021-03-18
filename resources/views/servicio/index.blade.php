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
<div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="pull-left"><h3>Servicios</h3></div>
          <div class="pull-right">
	           <div class="btn-group">
	             <a href="{{ route('servicios.create') }}" class="btn btn-info" >Añadir Servicios</a>
	           </div>
          </div>
          <div class="table-container">
            <table id="tabla-logs" class="table table-bordred table-striped">
            	<thead>
               		<th>id del cliente</th>
               		<th>nombre</th>
               		<th>fecha de inicio</th>
               		<th>fecha de fin</th>
               		<th>tipo de servicio</th>
               		<th>estado del servicio</th>
               		<th>numero de propuesta</th>
               		<th>condicion de pago</th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
              @if($servicios->count())  
              @foreach($servicios as $servicio)  
              <tr>
              	<td>{{$servicio->tipo_entidad_id}}</td>
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
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
               	</form>
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
      {{ $servicios->links() }}
    </div>
  </div>
@endsection
@push("scripts")
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  var datatable_tabla = $("#tabla-logs").dataTable({
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
    datatable_tabla.fnFilter(this.value);
});
</script>
<script type="text/javascript"> 
</script>
@endpush

