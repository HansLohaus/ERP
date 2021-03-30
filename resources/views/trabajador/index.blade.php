@extends("app.main")

{{-- Cabecera --}}
@section("title","Trabajadores")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css">
</style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","Trabajadores")
@section("breadcrumb")
    <li class="breadcrumb-item active">Trabajadores</li>
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
        	<div class="pull-left"><h3>Trabajadores</h3></div>
			<div class="pull-right">
	            <div class="btn-group">
	            	<a href="{{ route('trabajadores.create') }}" class="btn btn-info" >Añadir Trabajadores</a>
	            </div>
            </div>
            <div class="table-container">
            <table id="tabla-logs" class="table table-bordred table-striped">
            	<thead>
               		<th>Nombres</th>
               		<th>Apellido Paterno</th>
               		<th>Apellido Materno</th>
               		<th>Rut</th>
               		<th>Cargo</th>
               		<th>Teléfono</th>
               		<th>Email</th>
{{--                		<th>Sueldo</th>
               		<th>Fecha_contrato</th>
               		<th>Email Alternativo</th>
               		<th>Numero cuenta bancaria</th>
               		<th>Titular de la cuenta</th>
               		<th>Banco</th>
               		<th>Tipo_cuenta</th>
               		<th>AFP</th>
               		<th>prevision</th> --}}
               		<th>Informacion</th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
                @if($trabajadores->count())  
                @foreach($trabajadores as $trabajador)  
                <tr>
                <td>{{$trabajador->nombres}}</td>
                <td>{{$trabajador->apellidoP}}</td>
                <td>{{$trabajador->apellidoM}}</td>
                <td>{{$trabajador->rut}}</td>
                <td>{{$trabajador->cargo}}</td>
                <td>{{$trabajador->fono}}</td>
                <td>{{$trabajador->email}}</td>
{{--                 <td>{{(number_format($trabajador->sueldo))}}</td>
                <td>{{ date_format(date_create($trabajador->fecha_contrato),"d-m-Y") }}</td>
                <td>{{$trabajador->email_alt}}</td>
                <td>{{$trabajador->numero_cuenta_banc}}</td>
                <td>{{$trabajador->titular_cuenta_banc}}</td>
                <td>{{$trabajador->banco}}</td>
                <td>{{$trabajador->tipo_cuenta}}</td>
                <td>{{$trabajador->afp}}</td>
                <td>{{$trabajador->prevision}}</td> --}}
                
                <td><a data-trabajador="{{json_encode($trabajador)}}" href="#" class="btn btn-info" data-toggle="modal" data-target="#mas_info">más info</a></td>
                <td><a class="btn btn-primary" href="{{action('TrabajadorController@edit', $trabajador->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                <form action="{{action('TrabajadorController@destroy', $trabajador->id)}}" method="post">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todas las boletas o liquidaciones asociados al trabajador, ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
                </form>
                </td>
                </tr>
                @endforeach
                @endif
            </tbody>
          	</table>
          	{{-- popup --}}
				<div class="modal fade" id="mas_info">
           <div class="modal-dialog modal-l">
              	<div class="modal-content">
                   <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">
                   <span>×</span>
                   </button>
                   <h4>Cerrar</h4>
                   </div>
                   <div class="modal-body">
       			    <form role="form">
			          	{{ csrf_field() }}
			          	<input name="_method" type="hidden" value="PATCH">
			          	<div class="row">
			          		<table class="table">
			          		<tr>
			          		  <th>Profesion:</th>
			          		  <td class="profesion"></td>
			          		</tr>
			          		<tr>
			          		  <th>Fecha de nacimiento:</th>
			          		  <td class="fecha_nac"></td>
			          		</tr>
			          		<tr>
			          		  <th>Dirección</th>
			          		  <td class="direccion"></td>
			          		</tr>
			          		<tr>
			          		  <th>Sueldo:</th>
			          		  <td class="sueldo"></td>
			          		</tr>
			          		<tr>
			          		  <th>Fecha decontrato:</th>
			          		  <td class="fecha_contrato"></td>
			          		</tr>
			          		<tr>
			          		  <th>Email Alternativo:</th>
			          		  <td class="email_alt"></td>
			          		</tr>
			          		<tr>
			          		  <th>Numero cuenta bancaria:</th>
			          		  <td class="numero_cuenta_banc"></td>
			          		</tr>
			          		<tr>
			          		  <th>Titular:</th>
			          		  <td class="titular_cuenta_banc"></td>
			          		</tr>
			          		<tr>
			          		  <th>Banco:</th>
			          		  <td class="banco"></td>
			          		</tr>
			          		<tr>
			          		  <th>Tipo de cuenta:</th>
			          		  <td class="tipo_cuenta"></td>
			          		</tr>
			          		<tr>
			          		  <th>AFP:</th>
			          		  <td class="afp"></td>
			          		</tr>
			          		<tr>
			          		  <th>prevision:</th>
			          		  <td class="prevision"></td>
			          		</tr>
			          		</table>
			          	</div>
			          </form>
              </div>
            </div>
          </div>
        </div>
           		{{-- fin popup --}}
        	</div>
      	</div>
      	{{ $trabajadores->links() }}
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
    datatable_tabla.fnFilter(this.value);
});
</script>
<script type="text/javascript"> 
	$("body").on("click", "[data-target='#mas_info']", function(){
		let trabajador=$(this).data("trabajador");
		for (var key in trabajador) {
			$("#mas_info ."+key).text(trabajador[key]);
		}
	})
</script>
@endpush