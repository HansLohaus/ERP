@extends("app.main")

{{-- Cabecera --}}
@section("title","- Logs")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css') }}">
<style>
    #tabla-logs_wrapper {
        padding: 0 !important;
    }
    .dtr-details {
        width: 100%;
    }
    .dtr-title {
        width: 50%;
    }
    .dtr-data {
        width: 50%;
    }
    .dataTables_filter {
        float: left;
    }
</style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Logs")
@section("breadcrumb")
    <li class="breadcrumb-item active">Logs</li>
@endsection

{{-- Contenido --}}
@section('content')
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"><span class="fa fa-filter"></span></span>
    </div>
    <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
</div>
<table id="tabla-logs" class="table table-hover" cellspacing="0" style="table-layout:fixed;width: 100%;">
    <thead>
        <tr>
            <th style="width: 20%;">Fecha</th>
            <th style="width: 20%;">Usuario</th>
            <th>Acción</th>
            <th style="width: 15%;">IP</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td data-order="{{ date_format(date_create($log->fecha),"YmdHis") }}">{{ $log->fecha }}</td>
            <td>{{ $log->usuario->name }}</td>
            <td>{{ $log->accion }}</td>
            <td>{{ $log->ip }}</td>
        </tr>
        @endforeach
    </tbody>
</table> 
@endsection

{{-- Scripts --}}
@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/Responsive-2.2.0/js/dataTables.responsive.min.js') }}"></script>
<script>

// asignar datatable a la tabla de usuarios
var datatable_tabla = $("#tabla-logs").dataTable({
    "order" : [[0,"desc"]],
    "bLengthChange" : false, 
    "bInfo":false, 
    "bPaginate":true,
    "iDisplayLength": 30,
    "language": {
        "emptyTable": "No hay logs en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran logs para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});

// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
    datatable_tabla.fnFilter(this.value);
});
        
</script>
@endpush