@extends("app.main")

{{-- Cabecera --}}
@section("title","BoletasLiquidaciones")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css">
</style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","BoletasLiquidaciones")
@section("breadcrumb")
    <li class="breadcrumb-item active">BoletasLiquidaciones</li>
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
			    <a href="{{ route('boletasliquidaciones.create') }}" class="btn btn-info" >Añadir BoletasLiquidaciones</a>
			</div>
		</div>
            <nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active" id="nav-boletas-tab" data-toggle="tab" href="#nav-boletas" role="tab" aria-controls="nav-boletas" aria-selected="true">Boletas</a>
			    <a class="nav-item nav-link" id="nav-liquidacion-tab" data-toggle="tab" href="#nav-liquidacion" role="tab" aria-controls="nav-liquidacion" aria-selected="false">Liquidacion</a>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
			  <div class="tab-pane fade show active" id="nav-boletas" role="tabpanel" aria-labelledby="nav-boletas-tab">
			  	{{-- nav boleta --}}
			  	<div class="col-md-12 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-body">
			<br>
			<div class="pull-left"><h3>Boletas</h3></div>
            <div class="table-container">
            <table id="tabla-boleta" class="table table-bordred table-striped">
            	<thead>
               		<th>Nombre del trabajador</th>
               		<th>Descripción</th>
               		<th>Monto total</th>
               		<th>Monto líquido</th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
                @if($boletas->count())  
                @foreach($boletas as $boletaliquidacion)  
                <tr>
                <td>{{ucfirst($boletaliquidacion->trabajador->nombres)}} {{ucfirst($boletaliquidacion->trabajador->apellidoP)}}</td>
                <td>{{$boletaliquidacion->descripcion}}</td>
                <td>{{(number_format($boletaliquidacion->monto_total))}}</td>
                <td>{{(number_format($boletaliquidacion->monto_liquido))}}</td>
                <td><a class="btn btn-primary" href="{{action('BoletaLiquidacionController@edit', $boletaliquidacion->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                <form action="{{action('BoletaLiquidacionController@destroy', $boletaliquidacion->id)}}" method="post">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
			  	{{-- fin nav boleta --}}
			  </div>
			  <div class="tab-pane fade" id="nav-liquidacion" role="tabpanel" aria-labelledby="nav-liquidacion-tab">
			  	{{-- nav liquidacion --}}
			  	<div class="col-md-12 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-body">
			<br>
			<div class="pull-left"><h3>Liquidaciones</h3></div>
            <div class="table-container">
            <table id="tabla-liquidacion" class="table table-bordred table-striped">
            	<thead>
               		<th>Nombre trabajador</th>
               		<th>Descripción</th>
               		<th>Monto total</th>
               		<th>Monto líquido</th>
               		<th>Información</th>
               		<th>Editar</th>
               		<th>Eliminar</th>
            	</thead>
            <tbody>
                @if($liquidaciones->count())  
                @foreach($liquidaciones as $boletaliquidacion)  
                <tr>
                <td>{{ucfirst($boletaliquidacion->trabajador->nombres)}} {{ucfirst($boletaliquidacion->trabajador->apellidoP)}}</td>
                <td>{{$boletaliquidacion->descripcion}}</td>
                <td>{{(number_format($boletaliquidacion->monto_total))}}</td>
                <td>{{(number_format($boletaliquidacion->monto_liquido))}}</td>
                <td><a data-boletaliquidacion="{{json_encode($boletaliquidacion)}}" href="#" class="btn btn-info" data-toggle="modal" data-target="#mas_info">más info</a></td>
                <td><a class="btn btn-primary" href="{{action('BoletaLiquidacionController@edit', $boletaliquidacion->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                <form action="{{action('BoletaLiquidacionController@destroy', $boletaliquidacion->id)}}" method="post">
                {{csrf_field()}}
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
			          		    <th>Sueldo base:</th>
			          		    <td class="sueldo_base"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Gratificaciones:</th>
			          		    <td  class="gratificaciones"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Dias trabajados:</th>
			          		    <td class="dias_trabajados"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Descuento isapre:</th>
			          		    <td class="desc_isapre"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Descuento afp:</th>
			          		    <td class="desc_afp"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Descuento seguro de cesantia:</th>
			          		    <td class="desc_seguro_cesantia"></td>
			          		  </tr>
			          		  <tr>
			          		    <th>Descuento impuesto unico:</th>
			          		    <td class="impuesto_unico"></td>
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
 {{-- fin nav liquidacion --}}
			  </div>
			</div>
@endsection
@push("scripts")
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  var datatable_tabla1 = $("#tabla-boleta").dataTable({
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
    datatable_tabla1.fnFilter(this.value);
});
</script>
<script>
  var datatable_tabla2 = $("#tabla-liquidacion").dataTable({
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
    datatable_tabla2.fnFilter(this.value);
});
</script>
<script type="text/javascript"> 
	$("body").on("click", "[data-target='#mas_info']", function(){
		let boletaliquidacion=$(this).data("boletaliquidacion");
		for (var key in boletaliquidacion) {
			$("#mas_info ."+key).text(boletaliquidacion[key]);
		}
	})

</script>
@endpush