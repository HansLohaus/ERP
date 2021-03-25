@extends("app.main")

{{-- Cabecera --}}
@section("title","Pagos")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
<style type="text/css"></style>
@endpush
{{-- Breadcrumb --}}
@section("breadcrumb-title","Pagos")
@section("breadcrumb")
    <li class="breadcrumb-item active">Pago</li>
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
	             <a href="{{ route('pagos.create') }}" class="btn btn-info" >Añadir Pagos</a>
	           </div>
             <div class="btn-group">
               <a href="#" class="btn btn-info" data-toggle="modal" data-target="#masivo">Carga Masiva</a>
             </div>
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



<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-ingreso-tab" data-toggle="tab" href="#nav-ingreso" role="tab" aria-controls="nav-ingreso" aria-selected="true">Ingreso</a>
    <a class="nav-item nav-link" id="nav-egreso-tab" data-toggle="tab" href="#nav-egreso" role="tab" aria-controls="nav-egreso" aria-selected="false">Egreso</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-ingreso" role="tabpanel" aria-labelledby="nav-ingreso-tab">
    {{-- nav ingreso --}}
<div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Ingresos</h3></div>
          <div class="table-container">
            <table id="tabla-ingreso" class="table table-bordred table-striped">
              <thead>
                  <th>id de factura</th>
                  <th>id de boleta/liquidacion</th>
                  <th>ine</th>
                  <th>fecha de pago</th>
                  <th>monto</th>
                  <th>monto total de transferencia</th>
                  <th>descripcion de movimiento</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($pagos->count())  
              @foreach($pagos as $pago)  
              <tr>
                <td>{{$pago->factura_id}}</td>
                <td>{{$pago->boleta_liquidacion_id}}</td>
                <td>{{$pago->ine}}</td>
                <td>{{ date_format(date_create($pago->fecha_pago),"d-m-Y") }}</td>
                <td>{{(number_format($pago->monto))}}</td>
                <td>{{(number_format($pago->monto_total_transf))}}</td>
                <td>{{$pago->descrip_movimiento}}</td>
                <td><a class="btn btn-primary" href="{{action('PagoController@edit', $pago->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('PagoController@destroy', $pago->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
      {{ $pagos->links() }}
    </div>
  </div>
    {{-- fin nav ingreso --}}
  </div>
  <div class="tab-pane fade" id="nav-egreso" role="tabpanel" aria-labelledby="nav-egreso-tab">
    {{-- nav egreso --}}
<div class="col-md-12 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <br>
          <div class="pull-left"><h3>Egresos</h3></div>
          <div class="table-container">
            <table id="tabla-egreso" class="table table-bordred table-striped">
              <thead>
                  <th>id de factura</th>
                  <th>id de boleta/liquidacion</th>
                  <th>ine</th>
                  <th>fecha de pago</th>
                  <th>monto</th>
                  <th>monto total de transferencia</th>
                  <th>descripcion de movimiento</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
              </thead>
            <tbody>
              @if($pagos->count())  
              @foreach($pagos as $pago)  
              <tr>
                <td>{{$pago->factura_id}}</td>
                <td>{{$pago->boleta_liquidacion_id}}</td>
                <td>{{$pago->ine}}</td>
                <td>{{ date_format(date_create($pago->fecha_pago),"d-m-Y") }}</td>
                <td>{{(number_format($pago->monto))}}</td>
                <td>{{(number_format($pago->monto_total_transf))}}</td>
                <td>{{$pago->descrip_movimiento}}</td>
                <td><a class="btn btn-primary" href="{{action('PagoController@edit', $pago->id)}}" ><i class="bi bi-pencil"></i></a></td>
                <td>
                  <form action="{{action('PagoController@destroy', $pago->id)}}" method="post">
                   {{csrf_field()}}
                   <input name="_method" type="hidden" value="DELETE">
                   <button class="btn btn-danger" type="submit" onclick="return confirm('¿Seguro que quieres eliminar?')"><i class="bi bi-trash"></i></button>
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
      {{ $pagos->links() }}
    </div>
  </div>
    {{-- fin nav egreso --}}
  </div>
</div>
@endsection
@push("scripts")
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
  var datatable_tabla1 = $("#tabla-ingreso").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay pagos en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran pagos para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});
// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
    datatable_tabla1.fnFilter(this.value);
});
</script>
<script>
  var datatable_tabla2 = $("#tabla-egreso").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay pagos en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran pagos para la busqueda solicitada"
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