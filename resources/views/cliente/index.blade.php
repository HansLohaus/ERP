@extends("app.main")

{{-- Cabecera --}}
@section("title","Clientes")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css">

</style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Clientes")
@section("breadcrumb")
    <li class="breadcrumb-item active">Clientes</li>
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
          <div class="pull-left"><h3>Lista Clientes</h3></div>
          <div class="pull-right">
	           <div class="btn-group">
	             <a href="{{ route('clientes.create') }}" class="btn btn-info" >Añadir Cliente</a>
	           </div>
          </div>
          <div class="table-container">
            <table id="tabla-logs" class="table table-bordred table-striped">
             <thead>
               <th>Rut</th>
               <th>Razon social</th>
               <th>Nombre de fantasia</th>
               <th>Editar</th>
               <th>Eliminar</th>
             </thead>
             <tbody>
              @if($clientes->count())  
              @foreach($clientes as $cliente)  
              <tr>
                <td>{{Rut::parse($cliente->entidad->rut)->format()}}</td>
                <td>{{$cliente->entidad->razon_social}}</td>
                <td>{{$cliente->entidad->nombre_fantasia}}</td>
                <td><a data-cliente="{{json_encode($cliente)}}" href="#" class="btn btn-info" data-toggle="modal" data-target="#mas_info">más info</a></td>
                <td><a class="btn btn-primary" href="{{action('ClienteController@edit', $cliente->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('ClienteController@destroy', $cliente->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('Se eliminaran todos los servicios y facturas asociados al cliente, ¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
			          		    <th>Nombre contacto financiero:</th>
			          		    <td class="nombre_contacto_fin"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Nombre contacto tecnico:</th>
			          		    <td  class="nombre_contacto_tec"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Fono contacto financiero:</th>
			          		    <td class="fono_contacto_fin"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Fono contacto tecnico:</th>
			          		    <td class="fono_contacto_tec"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Email contacto financiero:</th>
			          		    <td class="email_contacto_fin"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Email contacto tecnico:</th>
			          		    <td class="email_contacto_tec"></td>
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
    datatable_tabla.fnFilter(this.value);
});
</script>
<script type="text/javascript"> 
	$("body").on("click", "[data-target='#mas_info']", function(){
		let cliente=$(this).data("cliente");
		for (var key in cliente.entidad) {
			$("#mas_info ."+key).text(cliente.entidad[key]);
		}
	})

</script>
@endpush