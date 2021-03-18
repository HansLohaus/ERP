@extends("pdf.informeMain")
@section("page")
<div class="header">
  <div style="width: 100%; margin: 0;">
	<div style="float: left;">
	  <span>Informe de Inspección <b>#{{ $datos->id }}</b> - 
	  @if (!isset($periodo))
	  Estructura <b>{{ $datos->estructura->num_estructura }}</b>
	  @else
	  Periodo <b>{{ $datos->periodo->nombre }}</b>
	  @endif
		</span>
	</div>
	<div style="float: right;">
	  <span>Fecha de Inspección: {{ $datos->fecha }} {{ $datos->hora }}</span>
	</div>
	<div style="clear: both;"></div>
  </div>
</div>
<div style="width: 100%; margin: 0;">
  <div style="width: 45.4%; float: left;">
	<table style="margin-right: 5px; ">
			<tr>
				<td colspan="2" class="bg-headers" style="text-align: center; font-weight: bold;">INFORMACIÓN GENERAL</td>
			</tr>
			<tr>
				<th>Prioridad</th>
				<td>{{ $datos->prioridad }}</td>
			</tr>
			<tr>
				<th>Instalación (línea/alimentador)</th>
				<td>{{ $datos->estructura->alimentador->nombre }}</td>
			</tr>
			<tr>
				<th>Número de Estructura</th>
				<td>{{ $datos->estructura->num_estructura }}</td>
			</tr>
			<tr>
				<th>Número de Placa</th>
				<td>{{ $datos->nombre }}</td>
			</tr>
			<tr>
				<th>Estructuras en Vano</th>
				<td>{{ $datos->num_estructura_vano }}</td>
			</tr>
			<tr>
				<th>Altura Vano</th>
				<td>{{ $datos->altura_vano }}</td>
			</tr>
			<tr>
				<th>Responsable de la inspección</th>
				<td>{{ $datos->responsable }}</td>
			</tr>
			<tr>
				<th>Establecimiento</th>
				<td>{{ $datos->establecimiento }}</td>
			</tr>
			<tr>
				<th>CECO</th>
				<td>{{ $datos->ceco }}</td>
			</tr>
			<tr>
				<th>Sector</th>
				<td>{{ strtoupper($datos->sector) }}</td>
			</tr>
			<tr>
				<th>Comuna</th>
				<td>{{ $datos->comuna }}</td>
			</tr>
			<tr>
				<th>Zona</th>
				<td>{{ $datos->zona }}</td>
			</tr>
			<tr>
				<th>Tipo de Inspección</th>
				<td>{{ $datos->tipo_inspeccion }}</td>
			</tr>
			<tr>
				<th>OT(s)</th>
				<td>{{ $datos->ot1 }} {{ $datos->ot2 }} {{ $datos->ot3 }}</td>
			</tr>
		</table>
		<table style="margin-right: 5px; border-radius: 5px 5px 0 0;">
			<tr>
				<td colspan="2" class="bg-headers" style="text-align: center; font-weight: bold;">DATOS TÉCNICOS</td>
			</tr>
			<tr>
				<th>Nivel de Tensión</th>
				<td>{{ $datos->tension }}</td>
			</tr>
			<tr>
				<th>Tipo de Línea</th>
				<td>{{ $datos->tipo_linea }}</td>
			</tr>
			<tr>
				<th>Tipo de Estructura</th>
				<td>{{ $datos->tipo_estructura }}</td>
			</tr>
			<tr>
				<th>Tipo de Poste</th>
				<td>
				@php
					switch($datos->tipo_poste) {
						case "H" : echo "Hormigón"; break;
						case "M" : echo "Madera"; break;
						case "F" : echo "Fierro"; break;
						case "T" : echo "Tubular"; break;
					}
				@endphp
				</td>
			</tr>
			<tr>
				<th>Cruceta</th>
				<td>
				@php
					switch($datos->cruceta) {
						case "H" : echo "Hormigón"; break;
						case "M" : echo "Madera"; break;
						case "F" : echo "Fierro"; break;
						case "T" : echo "Tubular"; break;
					}
				@endphp
				</td>
			</tr>
		</table>
		<table style="border-radius: 0 0 5px 5px; margin-right: 5px;" class="intercalar">
			<tr>
				<td colspan="4" style="background-color: #BDBDBD; text-align: center; font-weight: bold;">Cruces de Líneas</td>
			</tr>
			<tr>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">AT</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">MT</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">BT</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Corrientes débiles</td>
			</tr>
			<tr style="text-align: center;">
				<td>{{ $datos->crucesAT }}</td>
				<td>{{ $datos->crucesMT }}</td>
				<td>{{ $datos->crucesBT }}</td>
				<td>{{ $datos->cant_corrientes_debiles }}</td>
			</tr>
			<tr>
				<td colspan="2" style="background-color: #DADADA; text-align: center; font-weight: bold;">Ferrocarriles</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Caminos</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Fluvial</td>
			</tr>
			<tr style="text-align: center;">
				<td colspan="2">{{ $datos->cant_ferrocarriles }}</td>
				<td>{{ $datos->cant_caminos }}</td>
				<td>{{ $datos->cant_fluvial }}</td>
			</tr>
		</table>
  </div>
  <div style="width: 54.6%; float: right;">
	@if(isset($imagen))
		<img src="{{ $imagen }}" style="width: 100%; height: auto;">
	@else
		<img src="../public/uploads/{{ $datos->id }}/imagen1.jpg" style="width: 100%; height: auto;">
	@endif
	<table style="margin-top: 5px;">
			<tr>
				<td colspan="2" class="bg-headers" style="text-align: center; font-weight: bold;">DATOS DE LA PROPIEDAD</td>
			</tr>
			<tr>
				<th>Nombre del Propietario</th>
				<td>{{ ($datos->propietario == '') ? "No se ha ingresado propietario" : $datos->propietario }}</td>
			</tr>
			<tr>
				<th>Dirección del Propietario</th>
				<td>{{ ($datos->propietario_dir == '') ? "No se ha ingresado dirección" : $datos->propietario_dir }}</td>
			</tr>
			<tr>
				<th>Autorización Propietraio</th>
				<td>{{ $datos->autorizacion_cliente }}</td>
			</tr>
			<tr>
				<th>Ubicación de la red</th>
				<td>{{ $datos->ubicacion_red }}</td>
			</tr>
			<tr>
				<th>Tipo de sector</th>
				<td>{{ $datos->tipo_sector }}</td>
			</tr>
			<tr>
				<th>Factibilidad de ingreso camión</th>
				<td>{{ $datos->ingreso_camion }}</td>
			</tr>
			<tr>
				<th>Contaminación</th>
				<td>{{ $datos->contaminacion }}</td>
			</tr>
		</table>
		<table class="intercalar">
			<tr>
				<td colspan="3" class="bg-headers" style="text-align: center; font-weight: bold;">HALLAZGOS EXTERNOS</td>
			</tr>
			<tr>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Árbol/es</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Construcción</td>
				<td style="background-color: #DADADA; text-align: center; font-weight: bold;">Elemento extraño sobre la red</td>
			</tr>
			<tr style="text-align: center;">
				<td>{{ ($datos->arboles !== "") ? $datos->arboles : "No Existe" }}</td>
				<td>{{ ($datos->construccion !== "") ? $datos->construccion : "No Existe" }}</td>
				<td>{{ $datos->objeto_externo }}</td>
			</tr>
		</table>
  </div>
  <div style="clear: both;"></div>
</div>
<div class="footer">
	<span>Linea : {{ $datos->estructura->alimentador->nombre }} - 
	@if (!isset($periodo))
  Estructura <b>{{ $datos->estructura->num_estructura }}</b>
  @else
  Periodo <b>{{ $datos->periodo->nombre }}</b>
  @endif
	</span>
</div>
<div class="page-break"></div>
<div class="header">
  <div style="width: 100%; margin: 0;">
	<div style="float: left;">
	  <span>Informe de Inspección <b>#{{ $datos->id }}</b> - 
		@if (!isset($periodo))
	  Estructura <b>{{ $datos->estructura->num_estructura }}</b>
	  @else
	  Periodo <b>{{ $datos->periodo->nombre }}</b>
	  @endif
	  </span>
	</div>
	<div style="float: right;">
	  <span>Fecha de Inspección: {{ $datos->fecha }} {{ $datos->hora }}</span>
	</div>
	<div style="clear: both;"></div>
  </div>
</div>
<div style="width: 100%; margin: 0;">
	<table style="border-radius: 5px 5px 0 0; text-align: center;" class="intercalar fix-pad">
	<tr>
	  <td colspan="15" class="bg-headers" style="text-align: center; font-weight: bold;">HALLAZGOS INTERNOS</td>
	</tr>
	<tr>
			<td colspan="15" style="background-color: #BDBDBD; text-align: center; font-weight: bold;">Estado de las Estructuras y Conductores</td>
		</tr>
	<tr>
	  <th></th>
	  <th>Poste</th>
	  <th>Cruceta</th>
	  <th>Aislación</th>
	  <th>Herraje</th>
	  <th>Conductor</th>
	  <th>Altura</th>
	  <th>Placa</th>
	  <th>Número</th>
	  <th>Tirante</th>
	  <th>Letrero Peligro</th>
	  <th>Anti trepado</th>
	  <th>Protección Antipájaros</th>
	  <th>Fundación</th>
	  <th>Stud</th>
	</tr>
	<tr>
		<th>Bueno</th>
		<?php
		if($datos->e_poste == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_cruceta == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_aislacion == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_herraje == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_conductor == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_flecha == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_placa == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_numero == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_tirante == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_letrero_peligro == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antiescalamiento == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antipajaros == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_fundacion == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_stud == 'Bueno')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		?>
	</tr>
	<tr>
		<th>Malo</th>
		<?php
		if($datos->e_poste == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_cruceta == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_aislacion == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_herraje == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_conductor == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_flecha == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_placa == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_numero == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_tirante == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_letrero_peligro == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antiescalamiento == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antipajaros == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_fundacion == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_stud == 'Malo')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		?>
	</tr>
	<tr>
		<th>Regular</th>
		<?php
		if($datos->e_poste == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_cruceta == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_aislacion == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_herraje == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_conductor == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_flecha == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_placa == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_numero == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_tirante == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_letrero_peligro == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antiescalamiento == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antipajaros == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_fundacion == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_stud == 'Regular')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		?>
	</tr>
	<tr>
		<th>No&nbsp;Posee</th>
		<?php
		if($datos->e_poste == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_cruceta == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_aislacion == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_herraje == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_conductor == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_flecha == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_placa == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_numero == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_tirante == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_letrero_peligro == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antiescalamiento == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antipajaros == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_fundacion == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_stud == 'No Posee')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		?>
	</tr>
	<tr>
		<th>No&nbsp;Aplica</th>
		<?php
		if($datos->e_poste == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_cruceta == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_aislacion == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_herraje == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_conductor == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_flecha == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_placa == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_numero == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_tirante == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_letrero_peligro == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antiescalamiento == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_antipajaros == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_fundacion == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		if($datos->e_stud == 'No Aplica')
			echo "<td><div class='circle'></div></td>";
		else
			echo "<td></td>";
		?>
	</tr>
	</table>
	<table style="border-radius: 0 0 5px 5px; text-align: center; width: 100%;">
		<tr>
			<td rowspan="2" style="background-color: #BDBDBD; text-align: center; font-weight: bold; vertical-align: middle;">N°Fases</td>
			<td colspan="10" style="background-color: #BDBDBD; text-align: center; font-weight: bold;">Información por Fase</td>
		</tr>
		<tr>
			<th>Fases</th>
			<th>Nombre</th>
			<th>Discos Buenos</th>
			<th>Linepost Buenos</th>
			<th>Discos Malos</th>
			<th>Linepost Malos</th>
			<th>Discos Totales</th>
			<th>Linepost Totales</th>
			<th>Uniones Vano</th>
			<th>Estado Ferretería</th>
		</tr>
	  @if ($datos->n_fases >= 1)
		<tr>
			<th rowspan="{{ $datos->n_fases }}" style="vertical-align: middle;text-align: center;">{{ $datos->n_fases }}</th>
			<th>Fase 1</th>
			<td><?php echo $datos->fase1; ?></td>
			<td><?php echo $datos->fase1db; ?></td>
			<td><?php echo $datos->fase1avb; ?></td>
			<td><?php echo $datos->fase1dm; ?></td>
			<td><?php echo $datos->fase1avm; ?></td>
			<td><?php
				if (is_numeric($datos->fase1db) && is_numeric($datos->fase1dm)) {
					echo ($datos->fase1db+$datos->fase1dm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php
				if (is_numeric($datos->fase1avb) && is_numeric($datos->fase1avm)) {
					echo ($datos->fase1avb+$datos->fase1avm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php echo $datos->fase1uv; ?></td>
			<td><?php 
			if ($datos->fase1e_ferreteria == '0'){
					echo "Bueno";
				}
				if ($datos->fase1e_ferreteria == '1'){
					echo "Malo";
				}
				if ($datos->fase1e_ferreteria == '2'){
					echo "Regular";
				}
				if ($datos->fase1e_ferreteria == '3'){
					echo "No aplica";
				}
				if ($datos->fase1e_ferreteria == '4'){
					echo "No posee";
				}  ?></td>
		</tr>
		@endif
		@if ($datos->n_fases >= 2)
		<tr>
			<th>Fase 2</th>
			<td><?php echo $datos->fase2; ?></td>
			<td><?php echo $datos->fase2db; ?></td>
			<td><?php echo $datos->fase2avb; ?></td>
			<td><?php echo $datos->fase2dm; ?></td>
			<td><?php echo $datos->fase2avm; ?></td>
			<td><?php
				if (is_numeric($datos->fase2db) && is_numeric($datos->fase2dm)) {
					echo ($datos->fase2db+$datos->fase2dm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php
				if (is_numeric($datos->fase2avb) && is_numeric($datos->fase2avm)) {
					echo ($datos->fase2avb+$datos->fase2avm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php echo $datos->fase2uv; ?></td>
			<td><?php if ($datos->fase2e_ferreteria == '0'){
					echo "Bueno";
				}
				if ($datos->fase2e_ferreteria == '1'){
					echo "Malo";
				}
				if ($datos->fase2e_ferreteria == '2'){
					echo "Regular";
				}
				if ($datos->fase2e_ferreteria == '3'){
					echo "No aplica";
				}
				if ($datos->fase2e_ferreteria == '4'){
					echo "No posee";
				}  ?></td>
		</tr>
		@endif
		@if ($datos->n_fases >= 3)
		<tr>
			<th>Fase 3</th>
			<td><?php echo $datos->fase3; ?></td>
			<td><?php echo $datos->fase3db; ?></td>
			<td><?php echo $datos->fase3avb; ?></td>
			<td><?php echo $datos->fase3dm; ?></td>
			<td><?php echo $datos->fase3avm; ?></td>
			<td><?php
				if (is_numeric($datos->fase3db) && is_numeric($datos->fase3dm)) {
					echo ($datos->fase3db+$datos->fase3dm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php
				if (is_numeric($datos->fase3avb) && is_numeric($datos->fase3avm)) {
					echo ($datos->fase3avb+$datos->fase3avm); 
				} else {
					echo "-";
				}
			?></td>
			<td><?php echo $datos->fase3uv; ?></td>
			<td><?php if ($datos->fase3e_ferreteria == '0'){
					echo "Bueno";
				}
				if ($datos->fase3e_ferreteria == '1'){
					echo "Malo";
				}
				if ($datos->fase3e_ferreteria == '2'){
					echo "Regular";
				}
				if ($datos->fase3e_ferreteria == '3'){
					echo "No aplica";
				}
				if ($datos->fase3e_ferreteria == '4'){
					echo "No posee";
				}  ?></td>
		</tr>
		@endif
	</table>
  <div style="width: 100%; margin: 0;">
	<div style="width: 75%; float: left;">
	  <table style="margin-top: 5px; margin-right: 5px;">
		<tr>
		  <td class="bg-headers" style="text-align: center; font-weight: bold;">OBSERVACIONES</td>
		</tr>
		<tr>
		  <td>{{ ($datos->obs !== "") ? $datos->obs : "Sin observaciones" }}</td>
		</tr>
	  </table>
	</div>
	<div style="width: 25%; float: right;">
		<table style="margin-top: 5px; text-align: center;">
		<tr>
			<td class="bg-headers" style="text-align: center; font-weight: bold;">HEBRAS CORTADAS</td>
		</tr>
		<tr>
			@if ($datos->cant_hebras_cortadas == "0")
				<td>No</td>
			@else
				<td>Si</td>
			@endif
		</tr>
	  </table>
	</div>
	<div style="clear: both;"></div>
  </div>
  @if (count($datos->validacion_supervisor) > 0)
  <div style="width: 100%; margin: 0; position: absolute; bottom: 90px;">
		<div style="position: relative; width: 100%; height: 100%;">
			<div style="float: right; width: 5cm; margin-right: 50px; position: absolute; bottom: 0px;">
			<img src="../storage/app/firmas/{{-- {{ $datos->validacion_supervisor->last()->usuario->id }} --}}22.jpg" style="width: 100%; height: auto;">
		  </div>
		  <div style="float: left; width: 5cm; margin-left: 50px; position: absolute; bottom: 0px;">
			<img src="../storage/app/firmas/{{-- {{ $datos->validacion_contratista->last()->usuario->id }} --}}28.jpg" style="width: 100%; height: auto;">
		  </div>
		  <div style="clear: both;"></div>
		</div>
	</div>
  <div style="width: 100%; margin: 0; position: absolute; bottom: 50px;">
		<div style="float: right; width: 5cm; margin-right: 50px; text-align: center;">
			<span style="font-size: 15px;">{{-- {{ $datos->validacion_supervisor->last()->usuario->name }} --}}Jaime Bertín Ibáñez</span><br>
			<span style="font-size: 15px;">CGE</span>
		</div>
		<div style="float: left; width: 5cm; margin-left: 50px; text-align: center;">
			<span style="font-size: 15px;">{{-- {{ $datos->validacion_contratista->last()->usuario->name }} --}}Patrick Méndez</span><br>
			<span style="font-size: 15px;">RCA</span>
		</div>
		<div style="clear: both;"></div>
	</div>
	@endif
</div>
<div class="footer">
  <span>Linea : {{ $datos->estructura->alimentador->nombre }} - 
	@if (!isset($periodo))
  Estructura <b>{{ $datos->estructura->num_estructura }}</b>
  @else
  Periodo <b>{{ $datos->periodo->nombre }}</b>
  @endif
  </span>
</div>
@endsection