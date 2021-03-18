@extends("app.main")

{{-- Cabecera --}}
@section("title","- Usuarios")
@push("header")
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/dropify/dist/css/dropify.min.css') }}">
<style>
    #tabla-usuarios_wrapper {
        padding: 0 !important;
    }
    .usuario-foto img {
        width: 30px;
        border-radius: 100%;
        vertical-align: middle;
        border-style: none;
    }
    .dataTables_filter {
        float: left;
    }
    .btn-eliminar:hover {
        color: red !important;
    }
    .btn-editar:hover {
        color: blue !important;
    }
    th,td {
        vertical-align: middle !important;
    }
</style>
@endpush

{{-- Breadcrumb --}}
@section("breadcrumb-title","Listado de Usuarios")
@section("breadcrumb")
    <li class="breadcrumb-item active">Usuarios</li>
@endsection

{{-- Contenido --}}
@section('content')
@include("modal.confirm")
@include("modal.user")
<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"><span class="fa fa-filter"></span></span>
    </div>
    <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
    <div class="input-group-append">
        <button id="btn-abrir-modal" class="btn btn-success" type="button" title="Agregar un nuevo usuario"><i class="fa fa-plus"></i> Agregar</button>
    </div>
</div>
<table id="tabla-usuarios" class="table table-hover w-100" cellspacing="0">
    <thead>
        <tr>
            <th class="no-sort">Foto</th>
            <th>Nombre de Usuario</th>
            <th>Nombre</th>
            <th width="150">Rol</th>
            <th width="100">Estado</th>
            <th class="no-sort" width="30"></th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
        <tr usuario="{{ $usuario->id }}">
            <td><div class="usuario-foto">
                @if (File::exists(public_path("assets/images/users/".$usuario->id.".jpg")))
                <img src="{{ asset('assets/images/users/'.$usuario->id.'.jpg') }}" alt="user"/>
                @else
                <img src="{{ asset('assets/images/users/user.png') }}" alt="user"/>
                @endif
            </div></td>
            <td>{{ $usuario->username }}</td>
            <td>{{ $usuario->name }}</td>
            <td>{{ $usuario->role }}</td>
            <td><span style="font-size: 10pt;" class="badge badge-pill badge-{{ (function()use($usuario){
                if ($usuario->estado == 1) return "success";
                else return "secondary";
            })() }}">{{ $usuario->estado_f }}</span></td>
            <td>
                <a class="fa fa-pencil btn-editar pointer" title="Editar Usuario"></a>
                <a class="fa fa-times btn-eliminar pointer" title="Eliminar Usuario"></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<form id="form-hidden" action="" class="d-none" method="POST">
    {{ method_field('DELETE') }}
    {{ csrf_field() }}
</form>
@endsection

{{-- Scripts --}}
@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/Responsive-2.2.0/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script>

// asignar datatable a la tabla de usuarios
var datatable_tabla = $("#tabla-usuarios").dataTable({
    columnDefs: [{
        "className": 'all',
        "targets"  : 'no-sort',
        "orderable": false,
        "order": []
    },{
        className: 'all',
        sType: 'num-estr',
        targets: [1,2,3]
    },{
        className: 'all',
        width: '50px',
        targets: 0
    }],
    "order" : [[1,"asc"]],
    "bLengthChange" : false, 
    "bInfo": false,
    "iDisplayLength": 50,
    "language": {
        "emptyTable": "No hay usuarios en el sistema",
        "paginate": {
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Filtrar por :",
        "zeroRecords": "No se encuentran usuarios para la busqueda solicitada"
    },
    "dom" : "<'table-responsive'tr>p",
});

// Evento para el filtro
$("#tabla-filtro").on("keyup change",function(){
    datatable_tabla.fnFilter(this.value);
});

// Evento para abrir modal para crear usuarios
$("body").on("click","#btn-abrir-modal",function(){

    // Se cambia el texto del boton
    $("#form-usuario button[type=submit]").text("Agregar usuario");
    $("#form-usuario").attr("action","{{ route('usuarios.store') }}");
    $("input[name='_method']").val("POST");

    // Se limpia dropify
    $('.dropify').unbind().removeData();
    $(".dropify-wrapper").remove();
    dropify = {};

    // Se vuelve a cargar
    var dom = dom_inicial;
    dom.removeAttr("data-default-file");
    $("#group-foto").append(dom);
    dropActualizar();

    $("#form-usuario input[type=text]").val("");
    $("#form-usuario select").val("");
    
    $("#modal-usuario").modal("show");
});

// Evento para editar un usario
$("body").on("click",".btn-editar",function(){

    // Se obtiene la fila
    var tr = $(this).parents("tr");

    // Se obtienen algunos parametros del usuario seleccionado
    var id = tr.attr("usuario");

    // Se consultan los datos del usuario
    $.ajax({
        method: "GET",
        url: "{{ url('/usuarios') }}/"+id,
        dataType: "json",
        data: {
            "_token" : $('meta[name="csrf-token"]').attr('content')
        },
        success: function(usuario) {
            if (usuario !== null) {

                // Se llenan los cuadros de texto
                // con los datos del usuario
                $("#usuario-username").val(usuario.username);
                $("#usuario-name").val(usuario.name);
                $("#usuario-email").val(usuario.email);
                $("#usuario-rol").val(usuario.roles[0].name);
                $("input[name='_method']").val("PUT");

                // Se limpia dropify
                $('.dropify').unbind().removeData();
                $(".dropify-wrapper").remove();
                dropify = {};

                // Se vuelve a cargar
                var dom = dom_inicial;

                // Se actualiza la foto
                if (usuario.foto !== null) {
                    dom.attr("data-default-file",usuario.foto);
                } else {
                    dom.removeAttr("data-default-file");
                }

                $("#group-foto").append(dom);
                dropActualizar();

                // Cambia el texto del boton inferior
                $("#form-usuario button[type=submit]").text("Editar usuario");
                $("#form-usuario").attr("action","{{ url('usuarios') }}/"+usuario.id);

                // Se muestra el modal
                $("#modal-usuario").modal("show");
            }
        }
    });
});

// Evento para eliminar un usuario
$("body").on("click",".btn-eliminar",function(){

    // Se obtiene la fila
    var tr = $(this).parents("tr");

    // Se obtienen algunos parametros del usuario seleccionado
    var id = tr.attr("usuario");
    var name = tr.find("td:nth-child(3)").text();
    $("#form-hidden").attr("action","{{ url('usuarios') }}/"+id);
    console.log($("#form-hidden").attr("action"));

    // Mensaje de confirmación
    mensaje_confirmar("Eliminar Inspección","Deseas eliminar al usuario "+name+" ?",
    function(){
        $("#form-hidden").submit();
    });
});

// Dropify
dom_inicial = $('<input type="file" id="usuario-foto" name="foto" class="dropify" data-allowed-file-extensions="jpg" data-default-file=""/>');
var dropify = null;
function dropActualizar() {
    dropify = $('.dropify').dropify({
        messages: {
            default: "Arrastre una imagen o haga click para agregar una foto",
            replace: 'Arrastre una imagen o haga click para reemplazar',
            remove:  'Borrar',
            error:   'El archivo es demasiado grande'
        },
        height: "310px",
    });
}
dropActualizar();
        
</script>
@endpush