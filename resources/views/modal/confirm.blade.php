{{-- Modal para confirmar validacion --}}
@push("modals")
<div class="modal fade" id="modal-confirmar" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times" style="font-size: 19px;"></span></button>
            </div>
            <div class="modal-body">
                <div class="modal-mensaje">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary btn-aceptar">Aceptar</button>
                <button type="button" data-dismiss="modal" class="btn btn-default btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endpush

{{-- Codigo para el modal --}}
@push("scripts")
<script>
//-------------------------------------------------------------------------------
// Para confirmar las validaciones
//-------------------------------------------------------------------------------
function mensaje_confirmar(titulo,mensaje,acepta,cancela)
{
    $("#modal-confirmar .modal-title").html(titulo);
    $("#modal-confirmar .modal-mensaje").html(mensaje);
    $("#modal-confirmar").modal("show");
    // modal_accion = 0;
    if(typeof acepta !== "undefined") {
        $("#modal-confirmar .modal-footer .btn-aceptar").on("click.confirmar",function(){
            $('#modal-confirmar').off('.confirmar');
            $('#modal-confirmar').on('hidden.bs.modal.confirmar', function() {
                acepta();
                $(this).off('.confirmar');
            });
            $(".btn-cancelar,.btn-aceptar").off(".confirmar");
        });
    }
    if(typeof cancela !== "undefined") {
        $("#modal-confirmar .modal-footer .btn-cancelar, #modal-confirmar .modal-header .close, .fade").on("click.confirmar keypress.confirmar",function(){
            $('#modal-confirmar').off('.confirmar');
            $('#modal-confirmar').on('hidden.bs.modal.confirmar', function() {
                cancela();
                $(this).off('.confirmar');
            });
            $(".btn-cancelar,.btn-aceptar").off(".confirmar");
        });
    }
}
</script>
@endpush