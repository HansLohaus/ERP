@extends("pdf.informeMain")

{{-- Obtener algunos parametros --}}
@php

$fecha_inicio  = null;
$fecha_termino = null;

// prioridades
$no_requiere = 0;
$baja = 0;
$media = 0;
$priorizada = 0;
$inmediata = 0;

// para ver si esta completamente validada
$validacion = true;

// Se obtiene la fecha de inicio y la de termino
foreach ($inspecciones as $inspeccion) {
    
    // Se obtiene la fecha y se crea un dato tipo DateTime
    $fecha_actual = DateTime::createFromFormat("d-m-Y",$inspeccion->fecha);

    // La fecha de inicio debe ser la menor fecha que se encuentre
    if ($fecha_inicio !== null) {
        if ($fecha_actual <= $fecha_inicio) {
            $fecha_inicio = $fecha_actual;
        }
    } else {
        $fecha_inicio = $fecha_actual;
    }

    // La fecha de termino debe ser la mayor
    if ($fecha_termino !== null) {
        if ($fecha_actual >= $fecha_termino) {
            $fecha_termino = $fecha_actual;
        }
    } else {
        $fecha_termino = $fecha_actual;
    }

    // Se obtienen las prioridades
    if ($inspeccion->prioridad == "No Requiere") $no_requiere++;
    else if ($inspeccion->prioridad == "Baja") $baja++;
    else if ($inspeccion->prioridad == "Media") $media++;
    else if ($inspeccion->prioridad == "Priorizada") $priorizada++;
    else if ($inspeccion->prioridad == "Inmediata") $inmediata++;

    // Se obtiene la validacion
    if ($inspeccion->validacion == null) {
        $validacion = false;
    } else if ($inspeccion->validacion->estado !== 1 || $inspeccion->validacion->usuario->rol !== "supervisor") {
        $validacion = false;
    }
}
// Se convierten las fechas a dd:mm:aaaa
if ($fecha_inicio !== null) {
    $fecha_inicio = $fecha_inicio->format("d-m-Y");
}

if ($fecha_termino !== null) {
    $fecha_termino = $fecha_termino->format("d-m-Y");
}

// Se obtiene la linea y la cantidad de km
$linea = $inspecciones[0]->instalacion;

@endphp

@section("page")
<div class="header"></div>
<div style="width: 100%; margin: 0;">
    <table class="tabla-portada">
        <tr>
            <td colspan="3" class="bg-headers" style="text-align: center; font-size: 30px; font-weight: bold;">
                Inspección Pedestre Líneas de Transmisión
            </td>
        </tr>
        <tr>
            <th colspan="2">Instalación</th>
            <td class="col-3">{{ $inspecciones[0]->instalacion }}</td>
        </tr>
        <tr>
            <th colspan="2">CECO</th>
            <td class="col-3">{{ $inspecciones[0]->ceco }}</td>
        </tr>
        <tr>
            <th colspan="2">Zona</th>
            <td class="col-3">{{ $inspecciones[0]->zona }}</td>
        </tr>
        <tr>
            <th colspan="2">Establecimiento</th>
            <td class="col-3">{{ $inspecciones[0]->establecimiento }}</td>
        </tr>
        <tr style="height: 0px;">
            <td colspan="3" class="bg-headers"></td>
        </tr>
        <tr>
            <th colspan="2">Fecha de Inicio</th>
            <td class="col-3">{{ $fecha_inicio }}</td>
        </tr>
        <tr>
            <th colspan="2">Fecha de Término</th>
            <td class="col-3">{{ $fecha_termino }}</td>
        </tr>
        <tr>
            <th colspan="2">Distancia Inspeccionada (KM)</th>
            <td class="col-3">{{ round($distancia_inspeccionada,3) }}</td>
        </tr>
        <tr>
            <th colspan="2">Estructuras Inspeccionadas</th>
            <td class="col-3">{{ count($inspecciones) }}</td>
        </tr>
        <tr>
            <th rowspan="5" style="width: 10%;">Prioridad</th>
            <th style="width: 10%;">No Requiere</th>
            <td class="col-3">{{ $no_requiere }}</td>
        </tr>
        <tr>
            <th>Bajo</th>
            <td class="col-3">{{ $baja }}</td>
        </tr>
        <tr>
            <th>Medio</th>
            <td class="col-3">{{ $media }}</td>
        </tr>
        <tr>
            <th>Priorizada</th>
            <td class="col-3">{{ $priorizada }}</td>
        </tr>
        <tr>
            <th>Inmediata</th>
            <td class="col-3">{{ $inmediata }}</td>
        </tr>
        @if ($validacion == true)
        <tr style="height: 0px;">
            <td colspan="3" class="bg-headers"></td>
        </tr>
        <tr>
            <th colspan="2">Empresa de Inspección</th>
            <td>SOCIEDAD DE MONTAJES ELECTRICOS RCA LTDA</td>
        </tr>
        <tr>
            <th colspan="2">Validador de Inspección</th>
            <td class="col-3">Patrick Méndez</td>
        </tr>
        <tr>
            <th colspan="2">Firma Validador de Inspección</th>
            <td class="col-3" style="height: 60px; background: #fff;"><img src="../storage/app/firmas/28.jpg" style="width: auto; height: 60px;"></td>
        </tr>
        <tr style="height: 0px;">
            <td colspan="3" class="bg-headers"></td>
        </tr>
        <tr>
            <th colspan="2">Empresa Solicitante</th>
            <td>COMPAÑÍA GENERAL DE ELECTRICIDAD S.A.</td>
        </tr>
        <tr>
            <th colspan="2">Validador Solicitante</th>
            <td class="col-3">Jaime Bertín Ibáñez</td>
        </tr>
        <tr>
            <th colspan="2">Firma Validador Solicitante</th>
            <td class="col-3" style="height: 60px; background: #fff;"><img src="../storage/app/firmas/22.jpg" style="width: auto; height: 60px;"></td>
        </tr>
        @endif
    </table>
</div>
<div class="footer" style="margin-bottom: 10px;">
    <div style="width: 100%; margin: 0;">
        <div style="float: left;">
            <span>Sistema de Inspección Pedestre</span>
        </div>
        <div style="float: right;">
            <span><b>www.neering.cl</b></span>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
@endsection