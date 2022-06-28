@extends('app.main')

{{-- Cabecera --}}
@section('title', 'Gastos')
@push('header')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <style type="text/css"></style>
@endpush

{{-- Breadcrumb --}}
@section('breadcrumb-title', 'Gastos')
@section('breadcrumb')
    <li class="breadcrumb-item active">Gastos</li>
@endsection
{{-- Contenido --}}
@section('content')
    <div class="row">
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumatotalesSA">0</span>
                    </h3>
                    <p>Total de Facturas</p>
                    <h4 class="count" id="totalesSA">0</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="filtrarPor('totales')">Mostrar todo <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumapagada">0</span>
                    </h3>
                    <p>Facturas pagadas</p>
                    <h4 class="count" id="pagada">0</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="filtrarPor('pagados')">Filtrar <i
                        class="fa fa-filter"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-yellow text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumapendiente">0</span>
                    </h3>
                    <p>Facturas pendientes</p>
                    <h4 class="count" id="pendiente">0</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="filtrarPor('pendientes')">Filtrar <i
                        class="fa fa-filter"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red text-center">
                <div class="inner">
                    <h3 class="count">
                        $<span id="sumaanulada">0</span>
                    </h3>
                    <p>Facturas anuladas</p>
                    <h4 class="count" id="anulada">0</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="filtrarPor('anuladas')">Filtrar <i
                        class="fa fa-filter"></i></a>
            </div>
        </div>
    </div>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><span class="fa fa-filter"></span></span>
        </div>
        <input type="text" id="tabla-filtro" class="form-control" placeholder="Filtrar por...">
    </div>
    <br>
    <div class="pull-right">
        <div class="btn-group">
            <a href="{{ route('gastos.create') }}" class="btn btn-info">Añadir Gastos</a>
        </div>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-cliente-tab" data-toggle="tab" href="#nav-cliente" role="tab"
                aria-controls="nav-cliente" aria-selected="true" onclick="actualizarContadores('cliente')">Trabajador</a>
            <a class="nav-item nav-link" id="nav-proveedor-tab" data-toggle="tab" href="#nav-proveedor" role="tab"
                aria-controls="nav-proveedor" aria-selected="false" onclick="actualizarContadores('proveedor')">Clientes</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-cliente" role="tabpanel" aria-labelledby="nav-cliente-tab">
            {{-- nav clientes --}}
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="pull-left">
                            <h3>Gastos</h3>
                        </div>
                        <div class="table-container">
                            <table id="tabla-cliente" class="table table-bordred table-striped" cellspacing="0">
                                <thead>
                                    <th>Nombre Trabajador</th>
                                    <th>Monto Total</th>
                                    <th>Descripción</th>
                                    <th>Reembolsable</th>
                                    <th>Fecha de emisión</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($gastos_trabajador->count())
                                        @foreach ($gastos_trabajador as $gt)
                                            <tr>
                                                <td>{{ $gt->nombres }} {{ $gt->apellidoP }}</td>
                                                <td>${{ $gt->gastos->monto }}</td>
                                                <td>{{ $gt->gastos->descrip }}</td>
                                                <td>{{ $gt->gastos->reembolso ? 'SI' : 'NO' }}</td>
                                                <td data-order="{{ $gt->gastos->fecha_gasto }}">
                                                    {{ date_format(date_create($gt->gastos->fecha_gasto), 'd-m-Y') }}</td>
                                                <td><a class="btn btn-primary"
                                                        href="{{ action('GastoController@edit', $gt->gastos->id) }}"><i
                                                            class="bi bi-pencil"></i></a></td>
                                                <td>
                                                    <form
                                                        action="{{ action('GastoController@destroy', $gt->gastos->id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Se eliminaran todos los pagos asociados a la factura, ¿Seguro que quieres eliminar?')"><i
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
            {{-- fin nav clientes --}}
        </div>
        <div class="tab-pane fade" id="nav-proveedor" role="tabpanel" aria-labelledby="nav-proveedor-tab">
            {{-- nav proveedor --}}
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="pull-left">
                            <h3>Gastos</h3>
                        </div>
                        <div class="table-container">
                            <table id="tabla-proveedor" class="table table-bordred table-striped" cellspacing="0">
                                <thead>
                                    <th>Cliente</th>
                                    <th>Monto Total</th>
                                    <th>Descripción</th>
                                    <th>Reembolsable</th>
                                    <th>Fecha de emisión</th>
                                    <th>Editar</th>
                                    <th>Eliminar</th>
                                </thead>
                                <tbody>
                                    @if ($gastos_cliente->count())
                                        @foreach ($gastos_cliente as $gc)
                                            <tr>
                                                <td>{{ $gc->nombre_fantasia }}</td>
                                                <td>${{ $gc->gastos->monto }}</td>
                                                <td>{{ $gc->gastos->descrip }}</td>
                                                <td>{{ $gc->gastos->reembolso ? 'SI' : 'NO' }}</td>
                                                <td data-order="{{ $gc->gastos->fecha_gasto }}">
                                                    {{ date_format(date_create($gc->gastos->fecha_gasto), 'd-m-Y') }}
                                                </td>
                                                <td><a class="btn btn-primary"
                                                        href="{{ action('GastoController@edit', $gc->gastos->gastable_id) }}"><i
                                                            class="bi bi-pencil"></i></a></td>
                                                <td>
                                                    <form
                                                        action="{{ action('GastoController@destroy', $gc->gastos->gastable_id) }}"
                                                        method="post">
                                                        {{ csrf_field() }}
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Se eliminaran todos los pagos asociados a la factura, ¿Seguro que quieres eliminar?')"><i
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
            {{-- fin nav proveedor --}}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script>
        var datatable_tabla1 = $("#tabla-cliente").DataTable({
            "order": [
                [4, "desc"]
            ],
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": true,
            "iDisplayLength": 1000,
            "language": {
                "emptyTable": "No hay facturas en el sistema",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Filtrar por :",
                "zeroRecords": "No se encuentran facturas para la busqueda solicitada"
            },
            "dom": "<'table-responsive'tr>p",
        });

        var datatable_tabla2 = $("#tabla-proveedor").DataTable({
            "order": [
                [4, "desc"]
            ],
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": true,
            "iDisplayLength": 1000,
            "language": {
                "emptyTable": "No hay facturas en el sistema",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "search": "Filtrar por :",
                "zeroRecords": "No se encuentran facturas para la busqueda solicitada"
            },
            "dom": "<'table-responsive'tr>p",
        });
        // Evento para el filtro
        $("#tabla-filtro").on("keyup change", function() {
            datatable_tabla1.search(this.value).draw();
        });

        $("#tabla-filtro").on("keyup change", function() {
            datatable_tabla2.search(this.value).draw();
        });
    </script>
    <script type="text/javascript">
        // Filtros
        var filtro_array = {
            "pagados": false,
            "pendientes": false,
            "anuladas": false
        };
        // Funcion para filtrar
        function filtrarPor(tipo, valor) {
            // console.log(filtro_array);
            if (typeof valor == 'undefined') {
                if (tipo !== 'totales') {
                    if (filtro_array.hasOwnProperty(tipo)) {
                        filtro_array[tipo] = !filtro_array[tipo];
                        update_datatable();
                    }
                } else {
                    filtro_array.pagados = false;
                    filtro_array.pendientes = false;
                    filtro_array.anuladas = false;
                    update_datatable();
                }
            }
        };

        function update_datatable() {
            $.ajax({
                url: "{{ route('facturas.index') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filtros: filtro_array
                },
                success: function(response) {
                    datatable_tabla1.clear();
                    datatable_tabla2.clear();
                    if (response.hasOwnProperty('facturas_clientes')) {
                        $.each(response.facturas_clientes, function() {
                            var fila = '<tr>' +
                                '<td>' + this.cliente.entidad.nombre_fantasia + '</td>' +
                                '<td>' + (this.servicio ? this.servicio.nombre : '') + '</td>' +
                                '<td>' + this.folio + '</td>' +
                                '<td>' + this.tipo_dte + '</td>' +
                                '<td data-order="' + this.fecha_emision_o + '">' + this.fecha_emision +
                                '</td>' +
                                '<td>' + this.total_neto + '</td>' +
                                '<td>' + this.total_exento + '</td>' +
                                '<td>' + this.total_iva + '</td>' +
                                '<td>' + this.total_monto_total + '</td>' +
                                '<td>' + this.estado + '</td>' +
                                '<td>' + this.edit + '</td>' +
                                '<td>' + this.delete + '</td>' +
                                '</tr>';
                            fila = $.parseHTML(fila)[0];
                            datatable_tabla1.row.add(fila);
                        });
                        datatable_tabla1.draw();
                    }
                    if (response.hasOwnProperty('facturas_proveedores')) {
                        $.each(response.facturas_proveedores, function() {
                            var fila = '<tr>' +
                                '<td>' + this.proveedor.entidad.nombre_fantasia + '</td>' +
                                '<td>' + (this.servicio ? this.servicio.nombre : '') + '</td>' +
                                '<td>' + this.folio + '</td>' +
                                '<td>' + this.tipo_dte + '</td>' +
                                '<td data-order="' + this.fecha_emision_o + '">' + this.fecha_emision +
                                '</td>' +
                                '<td>' + this.total_neto + '</td>' +
                                '<td>' + this.total_exento + '</td>' +
                                '<td>' + this.total_iva + '</td>' +
                                '<td>' + this.total_monto_total + '</td>' +
                                '<td>' + this.estado + '</td>' +
                                '<td>' + this.edit + '</td>' +
                                '<td>' + this.delete + '</td>' +
                                '</tr>';
                            fila = $.parseHTML(fila)[0];
                            datatable_tabla2.row.add(fila);
                        });
                        datatable_tabla2.draw();
                    }
                }
            })
        }

        function actualizarContadores(tipo) {
            $.ajax({
                url: "{{ route('facturas.index') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    totales: tipo
                },
                success: function(response) {
                    $('#total').html(response.facturas);
                    $('#pagada').html(response.pagadas);
                    $('#pendiente').html(response.pendientes);
                    $('#anulada').html(response.anuladas);
                    $('#totalesSA').html(response.totalesSA);
                    $('#sumatotal').html(response.format_totales);
                    $('#sumapagada').html(response.format_pagadas);
                    $('#sumapendiente').html(response.format_pendientes);
                    $('#sumaanulada').html(response.format_anuladas);
                    $('#sumatotalesSA').html(response.format_sumatotalesSA);


                }
            });
        }
        actualizarContadores('cliente');
    </script>
@endpush
