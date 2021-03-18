{{-- Modal para agregar o editar un usuario --}}
@push("modals")
<div class="modal fade" id="modal-usuario" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-usuario" action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="modal-header">
                    <h4 class="modal-title">Crear Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal"><span class="fa fa-times" style="font-size: 19px;"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="group-foto">
                                <label class="control-label" for="usuario-foto">Foto de perfil</label>
                                <input type="file" id="usuario-foto" name="foto" class="dropify" data-allowed-file-extensions="jpg" data-default-file=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="usuario-username">Nombre de Usuario (*)</label>
                                <input type="text" class="form-control" id="usuario-username" name="username" required placeholder="Ingrese nombre de usuario...">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="usuario-name">Nombre completo (*)</label>
                                <input type="text" class="form-control" id="usuario-name" name="name" required placeholder="Ingrese nombre completo...">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="usuario-email">Correo (*)</label>
                                <input type="text" class="form-control" id="usuario-email" name="email" required placeholder="Ingrese correo...">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="usuario-rol">Rol</label>
                                <select class="form-control" id="usuario-rol" name="rol">
                                    <option value="" selected disabled hidden>Seleccione rol...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar usuario</button>
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

{{-- Codigo para el modal --}}
@push("scripts")
<script>
</script>
@endpush