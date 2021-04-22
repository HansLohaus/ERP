@extends("app.main")

{{-- Cabecera --}}
@section("title","Gastos")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css"></style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","Gastos")
@section("breadcrumb")
    <li class="breadcrumb-item active">Gasto</li>
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
        	<div class="pull-left"><h3>Gastos</h3></div>
			<div class="pull-right">
	            <div class="btn-group">
	            	<a href="{{ route('gastos.create') }}" class="btn btn-info" >Añadir Gastos</a>
	            </div>
            </div>
            <div class="table-container">
            <table id="tabla-gastos" class="table table-bordred table-striped">
            	<thead>
               		<th>Nombre trabajador</th>
               		<th>Monto </th>
               		<th>Descripción </th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
                @if($gastos->count())  
                @foreach($gastos as $gasto)  
                <tr>
                <td>{{$gasto->trabajador_id}}</td>
                <td>{{(number_format($gasto->monto))}}</td>
                <td>{{$gasto->descrip}}</td>
                <td><a class="btn btn-primary" href="{{action('GastoController@edit', $gasto->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                <form action="{{action('GastoController@destroy', $gasto->id)}}" method="post">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit" onclick="return confirm('Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
@endsection
@push("scripts")
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  var datatable_tabla = $("#tabla-gastos").DataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 10,
    "language": {
        "emptyTable": "No hay clientes en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran clientes para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});
// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
     datatable_tabla.search(this.value).draw();
});
</script>