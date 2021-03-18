@extends("app.main")

{{-- Cabecera --}}
@section("title","- Ayuda")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<style>
    #tabla-manuales_wrapper {
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
@section("breadcrumb-title","Manuales de Ayuda")
@section("breadcrumb")
    <li class="breadcrumb-item active">Ayuda</li>
@endsection

{{-- Contenido --}}
@section('content')
<div class="table-responsive">
    <table id="tabla-manuales" class="table table-hover display nowrap" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Nombre</th>
                <th style="width: 20%;">Version</th>
                <th>Fecha de Publicación</th>
                <th class="no-sort" style="width: 20px;"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Manual de Plataforma</td>
                <td>1.0</td>
                <td>06-02-2018</td>
                <td><a href="{{ route('manual',["archivo" => "#"]) }}" class="btn btn-success btn-rounded" title="Descargar"><i class="fa fa-arrow-down"></i></a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

{{-- Scripts --}}
@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/Responsive-2.2.0/js/dataTables.responsive.min.js') }}"></script>
<script>
 
    jQuery.extend( jQuery.fn.dataTableExt.oSort,{
        "num-estr-asc": function(a,b) {
            var re = new RegExp("^(\\d*)([a-zA-Z]*)");
            var x = re.exec(a);
            var y = re.exec(b);

            x[1] = parseInt(x[1]);
            y[1] = parseInt(y[1]);

            if (isNaN(x[1])) x[1] = 0;
            if (isNaN(y[1])) y[1] = 0;

            if (x[1] > y[1]) return 1;
            if (x[1] < y[1]) return -1;

            return ((x[2] < y[2]) ? -1 : ((x[2] > y[2]) ? 1 : 0));
        },
        "num-estr-desc": function(a,b) {
            var re = new RegExp("^(\\d*)([a-zA-Z]*)");
            var x = re.exec(a);
            var y = re.exec(b);

            x[1] = parseInt(x[1]);
            y[1] = parseInt(y[1]);

            if (isNaN(x[1])) x[1] = 0;
            if (isNaN(y[1])) y[1] = 0;

            if (x[1] > y[1]) return -1;
            if (x[1] < y[1]) return 1;

            return ((x[2] < y[2]) ? 1 : ((x[2] > y[2]) ? -1 : 0));
        },
        "date-ch-pre": function ( a ) {
            if (a !== "") {
                var fecha = a.split('-');
                return (fecha[2] + fecha[1] + fecha[0]) * 1;
            } else {
                return 0;
            }
        },
        "date-ch-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "date-ch-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

    // asignar datatable a la tabla de usuarios
    var datatable_tabla = $("#tabla-manuales").dataTable({
        responsive: true,
        columnDefs: [{
            sType: 'num-estr',
            targets: 0
        },{
            sType: 'date-chr',
            targets: 2
        },{
            targets: "no-sort",
            orderable: false,
            order: []
        }],
        "order" : [[2,"desc"]],
        "bLengthChange" : false, 
        "bInfo":false,
        "bPaginate":false,
        "bFilter": false,
        "language": {
            "emptyTable": "No hay manuales en el sistema",
            "paginate": {
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
            "search": "Filtrar por :",
            "zeroRecords": "No se encuentran manuales para la busqueda solicitada"
        },
        "dom" : "<'row'<'col-sm-6'f><'col-sm-6'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'l>>",
    });
        
</script>
@endpush