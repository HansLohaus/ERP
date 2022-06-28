@extends('app.main')

{{-- Cabecera --}}
@section('title', 'Gastos')
@push('header')
    <style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section('breadcrumb-title', 'Gastos')
@section('breadcrumb')
    <li class="breadcrumb-item">Gastos</li>
    <li class="breadcrumb-item active">Editar gasto</li>
@endsection
{{-- Contenido --}}
@section('content')


    <div class="col-md-12 col-md-offset-2">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Editar gasto</h3>
            </div>
            <div class="panel-body">
                <div class="table-container">
                    <form method="POST" action="{{ route('gastos.update', $gasto->id) }}" role="form">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PATCH">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>{{ $gasto->gastable_type == 'cliente' ? 'Cliente' : 'Trabajador' }}</label>
                                    <select name="id" id="id" class="form-control input-sm">
                                        <option value="" disabled hidden>Seleccione trabajador</option>
                                        @foreach ($lista as $col)
                                            <option value="{{ $gasto->id }}">{{ $col->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Monto</label>
                                    <input type="number" name="monto" id="monto" class="form-control input-sm"
                                        value="{{ $gasto->monto }}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Fecha del gasto</label>
                                    <input type="date" name="fecha_gasto" id="fecha_gasto" class="form-control input-sm"
                                        value="{{ $gasto->fecha_gasto }}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <input type="text" name="descrip" id="descrip" class="form-control input-sm"
                                        value="{{ $gasto->descrip }}">
                                </div>
                            </div>
                            <div class="form-check">
                                <label>¿Ha sido reembolsado el gasto?</label>
                                <input class="form-check-input" type="radio" name="reembolso" id="flexRadioDefault1"
                                    value="1" {{$gasto->reembolsable == 1 ?	'checked':null}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Reembolsado
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reembolso" value="0" {{$gasto->reembolsable == 0 ?'checked':null}}
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    No pagado
                                </label>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <input type="submit" value="Actualizar" class="btn btn-success btn-block">
                                <a href="{{ route('gastos.index') }}" class="btn btn-info btn-block">Atrás</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script type="text/javascript">
        function clienteOrTrabajador(select) {
            var cot = {
                !json_encode()
            }
            if (select.value == "cliente") {

                $("#cliente").show();
                $("#trabajador").hide();

            } else if (sel.value == "trabajador") {

                $("#cliente").hide();
                $("#trabajador").show();
            }
        }
    @endpush
