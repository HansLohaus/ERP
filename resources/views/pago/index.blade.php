@extends('app.main')

{{-- Cabecera --}}
@section('title', 'Pagos')
@push('header')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <style type="text/css"></style>
@endpush
{{-- Breadcrumb --}}
@section('breadcrumb-title', 'Pagos')
@section('breadcrumb')
    <li class="breadcrumb-item active">Pago</li>
@endsection
{{-- Contenido --}}
@section('content')


    <div class="row">
        <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="small-box bg-green text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumingreso">0</span>
                    </h3>
                    <p>Total de Ingresos</p>
                    <h5 class="count" id="ingreso">0</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="small-box bg-red text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumegreso">0</span>
                    </h3>
                    <p>Total de Egresos</p>
                    <h5 class="count" id="egreso">0</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="utilidad">0</span>
                    </h3>
                    <p>Utilidad</p>
                    <h5 class="count" id="total">0</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><span class="fa fa-filter"></span></span>
        </div>
        <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
    </div>


    <div class="pull-right">
        <div class="btn-group">
            <a href="{{ route('pagos.create') }}" class="btn btn-info">Añadir Pagos</a>
        </div>
        <div class="btn-group">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#masivo">Carga Masiva</a>
        </div>
        {{-- popup masivo --}}
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
                        <form action="{{ route('pagos.import') }}" method="POST" enctype="multipart/form-data">
                            <h4>Cargar Datos:</h4>
                            <input type="file" class="form-control" name="file" accept=".csv" required>
                            <label>.</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                    role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 100%">100%</div>
                            </div>
                            <br>
                            <div class="pull-right"><button class="btn btn-info" type="submit">Cargar Datos</button></div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- fin popup masivo --}}
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-ingreso-tab" data-toggle="tab" href="#nav-ingreso" role="tab"
                aria-controls="nav-ingreso" aria-selected="true" onclick="actualizarContadores('ingreso')">Ingreso</a>
            <a class="nav-item nav-link" id="nav-egreso-tab" data-toggle="tab" href="#nav-egreso" role="tab"
                aria-controls="nav-egreso" aria-selected="false" onclick="actualizarContadores('egreso')">Egreso</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-ingreso" role="tabpanel" aria-labelledby="nav-ingreso-tab">
            {{-- nav ingreso --}}
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="pull-left">
                            <h3>Ingresos</h3>
                        </div>
                        <div class="table-container">
                            <table id="tabla-ingreso" class="table table-bordred table-striped">
                                <thead>
                                    <th>Folio de la factura</th>
                                    <th>Boleta/liquidacion</th>
                                    <th>Fecha de pago</th>
                                    <th>Monto del pago</th>
                                    <th>Descripcion de movimiento</th>
                                    <th>Número del documento</th>
                                    <th>Sucursal</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($pagos_ingresos->count())
                                        @foreach ($pagos_ingresos as $pago)
                                            <tr>
                                                <td>{{ implode(', ', $pago->facturas->pluck('folio')->toArray()) }}</td>
                                                <td>{{ implode(', ', $pago->boletas->pluck('descripcion')->toArray()) }}</td>
                                                <td>{{ date_format(date_create($pago->fecha), 'd-m-Y') }}</td>
                                                <td>{{ number_format($pago->monto) }}</td>
                                                <td>{{ $pago->descrip_movimiento }}</td>
                                                <td>{{ $pago->n_doc }}</td>
                                                <td>{{ $pago->sucursal }}</td>
                                                <td><a class="btn btn-primary"
                                                        href="{{ action('PagoController@edit', $pago->id) }}"><i
                                                            class="bi bi-pencil"></i></a></td>
                                                <td>
                                                    <form action="{{ action('PagoController@destroy', $pago->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('¿Seguro que quieres eliminar?')"><i
                                                                class="bi bi-trash"></i></button>
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
            {{-- fin nav ingreso --}}
        </div>
        <div class="tab-pane fade" id="nav-egreso" role="tabpanel" aria-labelledby="nav-egreso-tab">
            {{-- nav egreso --}}
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="pull-left">
                            <h3>Egresos</h3>
                        </div>
                        <div class="table-container">
                            <table id="tabla-egreso" class="table table-bordred table-striped">
                                <thead>
                                    <th>Folio de la factura</th>
                                    <th>Descripción de la boleta/liquidacion</th>
                                    <th>Fecha de pago</th>
                                    <th>Monto del pago</th>
                                    <th>Descripcion de movimiento</th>
                                    <th>Número del documento</th>
                                    <th>Sucursal</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($pagos_egresos->count())
                                        @foreach ($pagos_egresos as $pago)
                                            <tr>
                                                <td>{{ implode(', ', $pago->facturas->pluck('folio')->toArray()) }}</td>
                                                <td>{{ implode(', ', $pago->boletas->pluck('descripcion')->toArray()) }}
                                                </td>
                                                <td>{{ date_format(date_create($pago->fecha), 'd-m-Y') }}</td>
                                                <td>{{ number_format($pago->monto) }}</td>
                                                <td>{{ $pago->descrip_movimiento }}</td>
                                                <td>{{ $pago->n_doc }}</td>
                                                <td>{{ $pago->sucursal }}</td>
                                                <td><a class="btn btn-primary"
                                                        href="{{ action('PagoController@edit', $pago->id) }}"><i
                                                            class="bi bi-pencil"></i></a></td>
                                                <td>
                                                    <form action="{{ action('PagoController@destroy', $pago->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('¿Seguro que quieres eliminar?')"><i
                                                                class="bi bi-trash"></i></button>
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
            {{-- fin nav egreso --}}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        var datatable_tabla1 = $("#tabla-ingreso").dataTable({
            "order": [
                [0, "desc"]
            ],
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": true,
            "iDisplayLength": 10,
            "language": {
                "emptyTable": "No hay pagos en el sistema",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Filtrar por :",
                "zeroRecords": "No se encuentran pagos para la busqueda solicitada"
            },
            "dom": "<'table-responsive'tr>p",
        });
        // Evento para el filtro
        $("#tabla-filtro").on("keyup change", function() {
            datatable_tabla1.fnFilter(this.value);
        });
    </script>
    <script>
        var datatable_tabla2 = $("#tabla-egreso").dataTable({
            "order": [
                [0, "desc"]
            ],
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": true,
            "iDisplayLength": 10,
            "language": {
                "emptyTable": "No hay pagos en el sistema",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Filtrar por :",
                "zeroRecords": "No se encuentran pagos para la busqueda solicitada"
            },
            "dom": "<'table-responsive'tr>p",
        });
        // Evento para el filtro
        $("#tabla-filtro").on("keyup change", function() {
            datatable_tabla2.fnFilter(this.value);
        });
    </script>
    <script type="text/javascript">
        // Filtros
        function update_datatable() {
            $.ajax({
                url: "{{ route('pagos.index') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    datatable_tabla1.clear();
                    datatable_tabla2.clear();
                    if (response.hasOwnProperty('pagos_ingresos')) {
                        $.each(response.pago_ingresos, function() {
                            datatable_tabla1.row.add([
                                this.factura.folio,
                                this.boletaliquidacion.descripcion,
                                this.fecha_pago,
                                this.monto,
                                this.monto_total_transf,
                                this.descrip_movimiento,
                                this.edit,
                                this.delete
                            ]);
                        });
                        datatable_tabla1.draw();
                    }
                    if (response.hasOwnProperty('pagos_egresos')) {
                        $.each(response.pago_egresos, function() {
                            datatable_tabla2.row.add([
                                this.factura.folio,
                                this.boletaliquidacion.descripcion,
                                this.fecha_pago,
                                this.monto,
                                this.monto_total_transf,
                                this.descrip_movimiento,
                                this.edit,
                                this.delete
                            ]);
                        });
                        datatable_tabla2.draw();
                    }
                }
            })
        }

        function actualizarContadores(tipo) {
            $.ajax({
                url: "{{ route('pagos.index') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    totales: tipo
                },
                success: function(response) {
                    $('#total').html(response.pagos);
                    $('#ingreso').html(response.pagos_ingresos);
                    $('#egreso').html(response.pagos_egresos);
                    $('#sumingreso').html(response.format_ingresos);
                    $('#sumegreso').html(response.format_egresos);
                    $('#utilidad').html(response.format_utilidades);


                }
            });
        }
        actualizarContadores('ingreso');
    </script>
@endpush
