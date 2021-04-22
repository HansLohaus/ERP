<table>
    <thead>
    <tr>
        <th>Tipo entidad</th>
        <th>Cliente/Proveedor</th>
        <th>Servicio</th>
        <th>Folio</th>
        <th>Tipo de DTE</th>
        <th>Fecha de emisión</th>
        <th>Monto Neto</th>
        <th>Monto Exento</th>
        <th>Monto del Iva</th>
        <th>Monto Total</th>
        <th>Estado</th>

    </tr>
    </thead>
    <tbody>
    @foreach($facturas as $factura) 
        <tr>
            <td>{{ucfirst($factura->tipoentidad->tipo)}}</td>
            <td>{{$factura->tipoentidad->entidad->nombre_fantasia}}</td>
            <td>{{$factura->servicio ? $factura->servicio->nombre : ''}}</td>
            <td>{{$factura->folio}}</td>
            <td>{{$factura->tipo_dte}}</td>
            <td>{{ date_format(date_create($factura->fecha_emision),"d-m-Y") }}</td>
            <td>{{(number_format($factura->total_neto))}}</td>
            <td>{{(number_format($factura->total_exento))}}</td>
            <td>{{(number_format($factura->total_iva))}}</td>
            <td>{{(number_format($factura->total_monto_total))}}</td>
            <td>{{$factura->estado}}</td>
        </tr>
    @endforeach
    </tbody>
</table>