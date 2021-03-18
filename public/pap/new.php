<?php
//require_once '../lib/PHPExcel/Classes/PHPExcel.php';
require dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
$dotenv = new Dotenv\Dotenv(dirname(dirname(__DIR__)));
$dotenv->load();

$mysqli = new mysqli(getenv('DB_HOST'),getenv('DB_USERNAME'),getenv('DB_PASSWORD'),getenv('DB_DATABASE'));
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset('utf8');
// Verificar la existencia de variables obligatorias enviadas por la APP
if(!isset($_POST['name']) || 
	!isset($_POST['prioridad']) || 
	!isset($_POST['image']) || 
	!isset($_POST['tension']) || 
	!isset($_POST['n_fases']) || 
	!isset($_POST['tipo_linea']) || 
	!isset($_POST['tipo_poste']) || 
	!isset($_POST['cruceta']) || 
	!isset($_POST['instalacion']) || 
	!isset($_POST['num_estructura']) ||
	!isset($_POST['establecimiento']) ||
	!isset($_POST['alim']) ||
	!isset($_POST['ceco']) ||
	!isset($_POST['recarran']) ||
	!isset($_POST['sector']) || 
	!isset($_POST['comuna']) || 
	!isset($_POST['zona']) ||
	!isset($_POST['ot1']) ||
	!isset($_POST['ot2']) ||
	!isset($_POST['ot3']) ||
	!isset($_POST['ubicacion_red']) || 
	!isset($_POST['autorizacion_cliente']) || 
	!isset($_POST['tipo_sector']) || 
	!isset($_POST['ingreso_camion']) || 
	//!isset($_POST['arboles']) ||
	//!isset($_POST['construccion']) ||
	!isset($_POST['objeto_externo']) || 
	!isset($_POST['tipo_inspeccion']) || 
	!isset($_POST['fecha']) || 
	!isset($_POST['hora'])){
	echo "Faltan variables.";
}
else{

	$inspeccion_existe = $mysqli->query("SELECT * FROM inspeccion WHERE num_estructura = '".trim($_POST['num_estructura'])."' and fecha = '".trim($_POST['fecha'])."' and hora = '".trim($_POST['hora'])."'")->fetch_assoc();
	if ($inspeccion_existe !== null) {
		echo "Enviado";
	} else {
		
		// Variables
		$codigo_establecimiento = trim($_POST['establecimiento']);
		$establecimiento = $mysqli->query("SELECT * FROM establecimiento WHERE codigo = '".trim($_POST['establecimiento'])."'")->fetch_assoc();
		$alimentador = trim($_POST['alim']);
		$tipo_aviso = '';
		// Parsear algunas variables que se reciben como números desde la app pero se ingresan como strings en la base de datos.

		// Parsear prioridad
		if(trim($_POST['prioridad']) == '0'){
			$prioridad = 'No Requiere';
		}
		else if(trim($_POST['prioridad']) == '1'){
			$prioridad = 'Baja';
		}
		else if(trim($_POST['prioridad']) == '2'){
			$prioridad = 'Media';
		}
		else if(trim($_POST['prioridad']) == '3'){
			$prioridad = 'Priorizada';
		}
		else if(trim($_POST['prioridad']) == '4'){
			$prioridad = 'Inmediata';
		}
		// Parsear zona
		if(trim($_POST['zona']) == '0')
			$zona = 'ARICA-IQUIQUE';
		else if(trim($_POST['zona']) == '1')
			$zona = 'ANTOFAGASTA';
		else if(trim($_POST['zona']) == '2')
			$zona = 'ATACAMA';
		else if(trim($_POST['zona']) == '3')
			$zona = 'COQUIMBO-VIÑA';
		else if(trim($_POST['zona']) == '4')
			$zona = 'BIOBIO-ARAUCANIA';
		else if(trim($_POST['zona']) == '5')
			$zona = 'MAULE';
		else if(trim($_POST['zona']) == '6')
			$zona = 'METROPOLITANA';
		else if(trim($_POST['zona']) == '7')
			$zona = 'OHIGGINS';
		// Parsear ubicación red
		if(trim($_POST['ubicacion_red']) == '0')
			$ubicacion_red = 'BNUP';
		else if(trim($_POST['ubicacion_red']) == '1')
			$ubicacion_red = 'Privado';
		// Parsear autorizacion cliente
		if(trim($_POST['autorizacion_cliente']) == '0')
			$autorizacion_cliente = 'Permite';
		else if(trim($_POST['autorizacion_cliente']) == '1')
			$autorizacion_cliente = 'No Permite';
		// Parsear tipo sector
		if(trim($_POST['tipo_sector']) == '0')
			$tipo_sector = 'Rural';
		else if(trim($_POST['tipo_sector']) == '1')
			$tipo_sector = 'Urbano';
		// Parsear ingreso camión
		if(trim($_POST['ingreso_camion']) == '0')
			$ingreso_camion = 'Si';
		else if(trim($_POST['ingreso_camion']) == '1')
			$ingreso_camion = 'No';

		// Se obtiene el ultimo periodo activo
		$periodo_max = $mysqli->query("SELECT MAX(id) as id FROM periodo")->fetch_assoc();

		// Se obtiene la linea asociada a la nueva inspeccion
		$linea = $mysqli->query("SELECT * FROM alimentador WHERE nombre = '".trim($_POST['instalacion'])."'")->fetch_assoc();
		if ($linea !== null) {
			
			// Se verifica si existe el numero de estructura y su alimentador
			$estructura = $mysqli->query("SELECT id FROM estructura WHERE num_estructura = '".trim($_POST['num_estructura'])."' and alimentador_id = '".$linea["id"]."'")->fetch_assoc();

			// Si la estructura no existe se crea
			$estructura_id = null;
			if ($estructura == null) {
				$result = $mysqli->query("INSERT INTO estructura (alimentador_id,num_estructura,kilometro) VALUES (".$linea["id"].",'".trim($_POST['num_estructura'])."',0)");
				if ($result) {
					$estructura_id = $mysqli->insert_id;
				}
			} else {
				$estructura_id = $estructura["id"];
			}

			// Si la estructura se creo, o ya existe
			if ($estructura_id !== null) {

				// Preparar query de insert dejando vacíos campos que se agregaran más adelante en la creación de avisos.
				$query = "INSERT INTO inspeccion(
					num_estructura,
					num_estructura_vano,
					responsable,
					tipo_estructura,
					contaminacion,
					antitrepado,
					propietario,
					propietario_dir,
					altura_vano,
					obs,
					nombre,
					prioridad,
					tension,
					crucesAT,
					crucesMT,
					crucesBT,
					n_fases,
					tipo_linea,
					tipo_poste,
					cruceta,
					instalacion,
					establecimiento,
					ceco,
					recarran,
					sector,
					comuna,
					zona,
					ot1,
					ot2,
					ot3,
					ubicacion_red,
					autorizacion_cliente,
					tipo_sector,
					ingreso_camion,
					arboles,
					construccion,
					objeto_externo,
					e_poste,
					e_cruceta,
					e_aislacion,
					e_herraje,
					e_conductor,
					e_flecha,
					e_placa,
					e_numero,
					e_tirante,
					e_letrero_peligro,
					e_antiescalamiento,
					e_antipajaros,
					e_fundacion,
					e_stud,
					e_ferreteria,
					e_estructura,
					e_conexiones,
					tipo_inspeccion,
					fase1,
					fase1db,
					fase1dm,
					fase1uv,
					fase1e_ferreteria,
					fase1avb,
					fase1avm,
					fase2,
					fase2db,
					fase2dm,
					fase2uv,
					fase2e_ferreteria,
					fase2avb,
					fase2avm,
					fase3,
					fase3db,
					fase3dm,
					fase3uv,
					fase3e_ferreteria,
					fase3avb,
					fase3avm,
					cant_corrientes_debiles,
					cant_ferrocarriles,
					cant_caminos,
					cant_fluvial,
					cant_hebras_cortadas,
					fecha,
					hora,
					latitud,
					longitud,
					direccion_mac,
					estructura_id,
					periodo_id) 
					VALUES (
					'".trim($_POST['num_estructura'])."',
					'".trim($_POST['num_estructura_vano'])."',
					'".trim($_POST['responsable'])."',
					'".trim($_POST['tipo_estructura'])."',
					'".trim($_POST['contaminacion'])."',
					'".trim($_POST['antitrepado'])."',
					'".trim($_POST['propietario'])."',
					'".trim($_POST['propietario_dir'])."',
					'".trim($_POST['altura_vano'])."',
					'".trim($_POST['obs'])."',
					'".trim($_POST['name'])."',
					'".$prioridad."',
					'".trim($_POST['tension'])."',
					'".trim($_POST['crucesAT'])."',
					'".trim($_POST['crucesMT'])."',
					'".trim($_POST['crucesBT'])."',
					'".trim($_POST['n_fases'])."',
					'".trim($_POST['tipo_linea'])."',
					'".trim($_POST['tipo_poste'])."',
					'".trim($_POST['cruceta'])."',
					'".trim($_POST['instalacion'])."',
					'1520',
					'".trim($_POST['ceco'])."',
					'".trim($_POST['recarran'])."',
					'".trim($_POST['sector'])."',
					'".trim($_POST['comuna'])."',
					'".$zona."',
					'".trim($_POST['ot1'])."',
					'".trim($_POST['ot2'])."',
					'".trim($_POST['ot3'])."',
					'".$ubicacion_red."',
					'".$autorizacion_cliente."',
					'".$tipo_sector."',
					'".$ingreso_camion."',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'".trim($_POST['estadoFerreteria'])."',
					'',
					'',
					'".trim($_POST['tipo_inspeccion'])."',
					'".trim($_POST['fase1'])."',
					'".trim($_POST['fase1db'])."',
					'".trim($_POST['fase1dm'])."',
					'".trim($_POST['fase1uv'])."',
					'".trim($_POST['estadoFerreteriaFase1'])."',
					'".trim($_POST['linepost_buenos_fase_1'])."',
					'".trim($_POST['linepost_malos_fase_1'])."',
					'".trim($_POST['fase2'])."',
					'".trim($_POST['fase2db'])."',
					'".trim($_POST['fase2dm'])."',
					'".trim($_POST['fase2uv'])."',
					'".trim($_POST['estadoFerreteriaFase2'])."',
					'".trim($_POST['linepost_buenos_fase_2'])."',
					'".trim($_POST['linepost_malos_fase_2'])."',
					'".trim($_POST['fase3'])."',
					'".trim($_POST['fase3db'])."',
					'".trim($_POST['fase3dm'])."',
					'".trim($_POST['fase3uv'])."',
					'".trim($_POST['estadoFerreteriaFase3'])."',
					'".trim($_POST['linepost_buenos_fase_3'])."',
					'".trim($_POST['linepost_malos_fase_3'])."',
					'".trim($_POST['cantCorrientesDebiles'])."',
					'".trim($_POST['cantFerrocarriles'])."',
					'".trim($_POST['cantCaminos'])."',
					'".trim($_POST['cantFluvial'])."',
					'".trim($_POST['cantHebrasCortadas'])."',
					'".trim($_POST['fecha'])."',
					'".trim($_POST['hora'])."',
					'".trim($_POST['latitude'])."',
					'".trim($_POST['longitude'])."',
					'".trim($_POST['macaddress'])."',
					'".$estructura_id."',
					'".$periodo_max["id"]."'
					)";
				$result = $mysqli->query($query);
				// Si la query no falla, guardar las imagenes enviadas desde la aplicacion (si existen) a la carpeta predeterminada por la id de la inspección recién insertada
				if($result) {
					$target_dir = "../uploads/".$mysqli->insert_id."/";
					if (!file_exists($target_dir)) {
						mkdir($target_dir, 0777, true);
					}
					$file_name1 = 'imagen1.jpg';
					$file_name2 = 'imagen2.jpg';
					$file_name3 = 'imagen3.jpg';
					$file_name4 = 'imagen4.jpg';

					$target_file = $target_dir . $file_name1;
					$decoded_image = base64_decode($_POST['image']);
					if (!file_exists($target_file)) {
						file_put_contents($target_file, $decoded_image);
					}
					$target_file = $target_dir . $file_name2;
					$decoded_image = base64_decode($_POST['image2']);	
					if (!file_exists($target_file)) {
							file_put_contents($target_file, $decoded_image);
					}
					$target_file = $target_dir . $file_name3;
					$decoded_image = base64_decode($_POST['image3']);
					if (!file_exists($target_file)) {
						file_put_contents($target_file, $decoded_image);
					}
					$target_file = $target_dir . $file_name4;
					if(isset($_POST['image4'])){
						$decoded_image = base64_decode($_POST['image4']);
						if (!file_exists($target_file)) {
							file_put_contents($target_file, $decoded_image);
						}
					}
					echo('Enviado');
					$id_inspeccion = $mysqli->insert_id;
				}
				else
					echo('Error en el insert inspeccion: '.$mysqli->error);

				// Según las variables referente al estado de las inspeccion pedestre y/o termografica (arboles, construccion... ) se crea un aviso y se actualiza el campo que se dejó vacío en el insert anterior.
				// la variable tipo_aviso se llena con Z1 (necesita reparacion), Z2 (se encontró un objeto x sobre el equipo) o Z4 (necesita proyecto) según el caso. Por ahora es subjetivo.
				
				// ejemplo $id: 38-00001 (codigo establecimiento CE38, id inspeccion 1)
				$id = substr($codigo_establecimiento, 2).'-'.sprintf('%05d', $id_inspeccion);

				$desc_p = $id.'_INSP_'.$codigo_establecimiento;
				$desc_lp = 'Formulario '.$id.' Inspección pedestre en Establecimiento '.$establecimiento['nombre'].' Hallazgo: ';
				$pedestre = 0;

				$desc_t = $id.'_TER_'.$codigo_establecimiento;
				$desc_lt = 'Formulario '.$id.' Inspección termográfica en Establecimiento '.$establecimiento['nombre'].' Hallazgo: ';
				$termografica = 0;

				$descripcion = '';
				$descripcion_larga = '';

				// Arboles
				if(in_array(trim($_POST['arboles']), ['0','1','2','3','4','5','6'])){
					if($_POST['arboles'] == '0'){
						$pedestre = 1;

						$arboles = 'Dentro de la franja';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARDE';
						$desc_lp .= 'Árbol(es) dentro de la franja. ';
					}
					else if(trim($_POST['arboles']) == '1'){
						$pedestre = 1;

						$arboles = 'Bajo la línea';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARTO';
						$desc_lp .= 'Árbol(es) tocando la línea. ';
					}
					else if(trim($_POST['arboles']) == '2'){
						$pedestre = 1;

						$arboles = 'Proyección de caída';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARPRO';
						$desc_lp .= 'Proyección de caída de árbol(es). ';
					}
					else if(trim($_POST['arboles']) == '3'){
						$pedestre = 1;

						$arboles = 'Dentro de la franja y bajo la línea';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARDE_EXARTO';
						$desc_lp .= 'Árbol(es) dentro de la franja. Árbol(es) tocando la línea. ';
					}
					else if(trim($_POST['arboles']) == '4'){
						$pedestre = 1;

						$arboles = 'Dentro de la franja y proyección de caída';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARDE_EXARPRO';
						$desc_lp .= 'Árbol(es) dentro de la franja. Proyección de caída de árbol(es). ';
					}
					else if(trim($_POST['arboles']) == '5'){
						$pedestre = 1;

						$arboles = 'Bajo la línea y proyección de caída';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARTO_EXARPRO';
						$desc_lp .= 'Árbol(es) tocando la línea. Proyección de caída de árbol(es). ';
					}
					else if(trim($_POST['arboles']) == '6'){
						$pedestre = 1;

						$arboles = 'Dentro de la franja, bajo la línea y proyección de caída';
						$mysqli->query("UPDATE inspeccion SET arboles = '".$arboles."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXARDE_EXARTO_EXARPRO';
						$desc_lp .= 'Árbol(es) dentro de la franja. Árbol(es) tocando la línea. Proyección de caída de árbol(es). ';
					}

					if($prioridad == 'INMEDIATA' || $prioridad == 'PRIORIZADA')
						$tipo_aviso = 'Z1';
					else
						$tipo_aviso = 'Z4';			
				}
				else{
					$arboles = null;
				}
				
				// Construcción
				if(in_array(trim($_POST['construccion']), ['0','1','2'])){
					if(trim($_POST['construccion']) == '0'){
						$pedestre = 1;

						$construccion = 'Dentro de la franja';
						$mysqli->query("UPDATE inspeccion SET construccion = '".$construccion."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXCODE';
						$desc_lp .= 'Construcción dentro de la franja. ';
					}
					else if(trim($_POST['construccion']) == '1'){
						$pedestre = 1;

						$construccion = 'Bajo la línea';
						$mysqli->query("UPDATE inspeccion SET construccion = '".$construccion."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXCOBA';
						$desc_lp .= 'Construcción bajo la línea. ';
					}
					else if(trim($_POST['construccion']) == '2'){
						$pedestre = 1;

						$construccion = 'Dentro de la franja y bajo la línea';
						$mysqli->query("UPDATE inspeccion SET construccion = '".$construccion."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_EXCODE_EXCOBA';
						$desc_lp .= 'Construcción dentro de la franja. Construcción bajo la línea. ';
					}
					$tipo_aviso = 'Z4';
				}
				else{
					$construccion = null;
				}

				// Objeto externo
				if(trim($_POST['objeto_externo']) == '0'){
					$pedestre = 1;

					$objeto_externo = 'Si';
					$mysqli->query("UPDATE inspeccion SET objeto_externo = '".$objeto_externo."' WHERE id = '".$id_inspeccion."'");

					$desc_p .= '_EXOBSL';
					$desc_lp .= 'Objeto sobre la red. ';

					$tipo_aviso = 'Z2';
				}
				else if(trim($_POST['objeto_externo']) == '1'){
					$objeto_externo = 'No';
					$mysqli->query("UPDATE inspeccion SET objeto_externo = '".$objeto_externo."' WHERE id = '".$id_inspeccion."'");
				}

				// Estado Poste
				if(trim($_POST['e_poste']) == '0'){
					$e_poste = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_poste = '".$e_poste."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_poste']) == '1'){
						$pedestre = 1;

						$e_poste = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_poste = '".$e_poste."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INPOMA';
						$desc_lp .= 'Poste en mal estado. ';

						$tipo_aviso = 'Z4';
					}
					else if(trim($_POST['e_poste']) == '2'){
						$pedestre = 1;
						$e_poste = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_poste = '".$e_poste."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INPORE';
						$desc_lp .= 'Poste en estado regular. ';

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_poste']) == '3'){
						$e_poste = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_poste = '".$e_poste."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_poste']) == '4'){
						$e_poste = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_poste = '".$e_poste."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado cruceta
				if(trim($_POST['e_cruceta']) == '0'){
					$e_cruceta = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_cruceta = '".$e_cruceta."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_cruceta']) == '1'){
						$pedestre = 1;

						$e_cruceta = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_cruceta = '".$e_cruceta."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INCRMA';
						$desc_lp .= 'Cruceta en mal estado. ';

						$tipo_aviso = 'Z4';
					}
					else if(trim($_POST['e_cruceta']) == '2'){
						$pedestre = 1;

						$e_cruceta = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_cruceta = '".$e_cruceta."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INCRRE';
						$desc_lp .= 'Cruceta en estado regular. ';

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_cruceta']) == '3'){
						$e_cruceta = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_cruceta = '".$e_cruceta."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_cruceta']) == '4'){
						$e_cruceta = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_cruceta = '".$e_cruceta."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado aislación
				if(trim($_POST['e_aislacion']) == '0'){
					$e_aislacion = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_aislacion = '".$e_aislacion."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_aislacion']) == '1'){
						$pedestre = 1;

						$e_aislacion = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_aislacion = '".$e_aislacion."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INAIMA';
						$desc_lp .= 'Aislación en mal estador. ';

						$tipo_aviso = 'Z4';
					}
					else if(trim($_POST['e_aislacion']) == '2'){
						$pedestre = 1;

						$e_aislacion = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_aislacion = '".$e_aislacion."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INAIRE';
						$desc_lp .= 'Aislación en estado regular. ';

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_aislacion']) == '3'){
						$e_aislacion = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_aislacion = '".$e_aislacion."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_aislacion']) == '4'){
						$e_aislacion = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_aislacion = '".$e_aislacion."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado herraje
				if(trim($_POST['e_herraje']) == '0'){
					$e_herraje = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_herraje = '".$e_herraje."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_herraje']) == '1'){
						$e_herraje = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_herraje = '".$e_herraje."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_herraje']) == '2'){
						$e_herraje = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_herraje = '".$e_herraje."' WHERE id = '".$id_inspeccion."'");

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_herraje']) == '3'){
						$e_herraje = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_herraje = '".$e_herraje."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_herraje']) == '4'){
						$e_herraje = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_herraje = '".$e_herraje."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado conductor
				if(trim($_POST['e_conductor']) == '0'){
					$e_conductor = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_conductor = '".$e_conductor."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_conductor']) == '1'){
						$pedestre = 1;

						$e_conductor = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_conductor = '".$e_conductor."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INCOMA';
						$desc_lp .= 'Conductor en mal estado. ';

						$tipo_aviso = 'Z4';
					}
					else if(trim($_POST['e_conductor']) == '2'){
						$pedestre = 1;

						$e_conductor = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_conductor = '".$e_conductor."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INCORE';
						$desc_lp .= 'Conductor en estado regular. ';

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_conductor']) == '3'){
						$e_conductor = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_conductor = '".$e_conductor."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_conductor']) == '4'){
						$e_conductor = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_conductor = '".$e_conductor."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado flecha
				if(trim($_POST['e_flecha']) == '0'){
					$e_flecha = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_flecha = '".$e_flecha."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_flecha']) == '1'){
						$pedestre = 1;

						$e_flecha = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_flecha = '".$e_flecha."' WHERE id = '".$id_inspeccion."'")

						;$desc_p .= '_INFLMA';
						$desc_lp .= 'Flecha en mal estado. ';

						$tipo_aviso = 'Z4';
					}
					else if(trim($_POST['e_flecha']) == '2'){
						$pedestre = 1;

						$e_flecha = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_flecha = '".$e_flecha."' WHERE id = '".$id_inspeccion."'");

						$desc_p .= '_INFLRE';
						$desc_lp .= 'Flecha en estado regular. ';

						$tipo_aviso = 'Z1';
					}
					else if(trim($_POST['e_flecha']) == '3'){
						$e_flecha = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_flecha = '".$e_flecha."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_flecha']) == '4'){
						$e_flecha = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_flecha = '".$e_flecha."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado placa
				if(trim($_POST['e_placa']) == '0'){
					$e_placa = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_placa = '".$e_placa."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_placa']) == '1'){
						$e_placa = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_placa = '".$e_placa."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_placa']) == '2'){
						$e_placa = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_placa = '".$e_placa."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_placa']) == '3'){
						$e_placa = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_placa = '".$e_placa."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_placa']) == '4'){
						$e_placa = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_placa = '".$e_placa."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado numero
				if(trim($_POST['e_numero']) == '0'){
					$e_numero = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_numero = '".$e_numero."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_numero']) == '1'){
						$e_numero = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_numero = '".$e_numero."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_numero']) == '2'){
						$e_numero = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_numero = '".$e_numero."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_numero']) == '3'){
						$e_numero = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_numero = '".$e_numero."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_numero']) == '4'){
						$e_numero = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_numero = '".$e_numero."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado tirante
				if(trim($_POST['e_tirante']) == '0'){
					$e_tirante = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_tirante = '".$e_tirante."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_tirante']) == '1'){
						$e_tirante = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_tirante = '".$e_tirante."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_tirante']) == '2'){
						$e_tirante = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_tirante = '".$e_tirante."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_tirante']) == '3'){
						$e_tirante = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_tirante = '".$e_tirante."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_tirante']) == '4'){
						$e_tirante = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_tirante = '".$e_tirante."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado letrero peligro
				if(trim($_POST['e_letrero_peligro']) == '0'){
					$e_letrero_peligro = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_letrero_peligro = '".$e_letrero_peligro."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_letrero_peligro']) == '1'){
						$e_letrero_peligro = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_letrero_peligro = '".$e_letrero_peligro."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_letrero_peligro']) == '2'){
						$e_letrero_peligro = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_letrero_peligro = '".$e_letrero_peligro."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_letrero_peligro']) == '3'){
						$e_letrero_peligro = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_letrero_peligro = '".$e_letrero_peligro."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_letrero_peligro']) == '4'){
						$e_letrero_peligro = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_letrero_peligro = '".$e_letrero_peligro."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado antiescalamiento
				if(trim($_POST['e_antiescalamiento']) == '0'){
					$e_antiescalamiento = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_antiescalamiento = '".$e_antiescalamiento."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_antiescalamiento']) == '1'){
						$e_antiescalamiento = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_antiescalamiento = '".$e_antiescalamiento."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antiescalamiento']) == '2'){
						$e_antiescalamiento = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_antiescalamiento = '".$e_antiescalamiento."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antiescalamiento']) == '3'){
						$e_antiescalamiento = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_antiescalamiento = '".$e_antiescalamiento."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antiescalamiento']) == '4'){
						$e_antiescalamiento = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_antiescalamiento = '".$e_antiescalamiento."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado antipajaros
				if(trim($_POST['e_antipajaros']) == '0'){
					$e_antipajaros = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_antipajaros = '".$e_antipajaros."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_antipajaros']) == '1'){
						$e_antipajaros = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_antipajaros = '".$e_antipajaros."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antipajaros']) == '2'){
						$e_antipajaros = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_antipajaros = '".$e_antipajaros."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antipajaros']) == '3'){
						$e_antipajaros = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_antipajaros = '".$e_antipajaros."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_antipajaros']) == '4'){
						$e_antipajaros = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_antipajaros = '".$e_antipajaros."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado fundacion
				if(trim($_POST['e_fundacion']) == '0'){
					$e_fundacion = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_fundacion = '".$e_fundacion."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_fundacion']) == '1'){
						$e_fundacion = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_fundacion = '".$e_fundacion."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_fundacion']) == '2'){
						$e_fundacion = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_fundacion = '".$e_fundacion."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_fundacion']) == '3'){
						$e_fundacion = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_fundacion = '".$e_fundacion."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_fundacion']) == '4'){
						$e_fundacion = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_fundacion = '".$e_fundacion."' WHERE id = '".$id_inspeccion."'");
					}
				}

				// Estado stud
				if(trim($_POST['e_stud']) == '0'){
					$e_stud = 'Bueno';
					$mysqli->query("UPDATE inspeccion SET e_stud = '".$e_stud."' WHERE id = '".$id_inspeccion."'");
				}
				else{
					if(trim($_POST['e_stud']) == '1'){
						$e_stud = 'Malo';
						$mysqli->query("UPDATE inspeccion SET e_stud = '".$e_stud."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_stud']) == '2'){
						$e_stud = 'Regular';
						$mysqli->query("UPDATE inspeccion SET e_stud = '".$e_stud."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_stud']) == '3'){
						$e_stud = 'No Aplica';
						$mysqli->query("UPDATE inspeccion SET e_stud = '".$e_stud."' WHERE id = '".$id_inspeccion."'");
					}
					else if(trim($_POST['e_stud']) == '4'){
						$e_stud = 'No Posee';
						$mysqli->query("UPDATE inspeccion SET e_stud = '".$e_stud."' WHERE id = '".$id_inspeccion."'");
					}
				}

				/*
				// Uniones vano
				if(trim($_POST['uniones_vano']) == 'más de 3'){	
					$pedestre = 1;

					$desc_p .= '_INUNMA';
					$desc_lp .= 'Más de 3 uniones en el vano. ';

					if($prioridad == 'INMEDIATA' || $prioridad == 'PRIORIZADA')
						$tipo_aviso = 'Z1';
					else
						$tipo_aviso = 'Z4';
				}	
				*/
				// Estado termográfico estructura
				if(trim($_POST['e_estructura']) == '0'){
					$e_estructura = 'Normal';
					$mysqli->query("UPDATE inspeccion SET e_estructura = '".$e_estructura."' WHERE id = '".$id_inspeccion."'");
				}
				else if(trim($_POST['e_estructura']) == '1'){
					$termografica = 1;

					$e_estructura = 'Irregular';
					$mysqli->query("UPDATE inspeccion SET e_estructura = '".$e_estructura."' WHERE id = '".$id_inspeccion."'");	

					$desc_t .= '_TERESIRR';
					$desc_lt .= 'Estructura en estado Irregular. ';

					if($prioridad == 'INMEDIATA' || $prioridad == 'PRIORIZADA')
						$tipo_aviso = 'Z1';
					else
						$tipo_aviso = 'Z4';	
				}

				// Estado termográfico conexiones
				if(trim($_POST['e_conexiones']) == '0'){
					$e_conexiones = 'Normal';
					$mysqli->query("UPDATE inspeccion SET e_conexiones = '".$e_conexiones."' WHERE id = '".$id_inspeccion."'");
				}
				else if(trim($_POST['e_conexiones']) == '1'){
					$termografica = 1;

					$e_conexiones = 'Irregular';
					$mysqli->query("UPDATE inspeccion SET e_conexiones = '".$e_conexiones."' WHERE id = '".$id_inspeccion."'");

					$desc_t .= '_TERCOIRR';
					$desc_lt .= 'Conexiones en estado Irregular. ';

					if($prioridad == 'INMEDIATA' || $prioridad == 'PRIORIZADA')
						$tipo_aviso = 'Z1';
					else
						$tipo_aviso = 'Z4';
				}

				// Para no dejar los campos descripcion, descripcion_larga y tipo_aviso vacíos en caso de que no existan hallazgos, dejar un mensaje default.
				if($pedestre == 0 && $termografica == 0){
					$descripcion = $id.'_INSP_'.$codigo_establecimiento;
					$descripcion_larga = 'Formulario '.$id.' Inspección pedestre en Establecimiento '.$establecimiento['nombre'].' Sin hallazgos.';
					$tipo_aviso = 'Z2';
				}
				else{
					if($pedestre == 1){
						$descripcion .= $desc_p;
						$descripcion_larga .= $desc_lp;
					}
					if($termografica == 1){
						$descripcion .= $desc_t;
						$descripcion_larga .= $desc_lt;
					}
				}
				// Dejar solo los primeros 40 caracteres de la descripcion (requerimiento)
				$descripcion = substr($descripcion, 0, 40);
				// Preparar query para insert a aviso_sap con los datos acumulados.
				$query2 = 
				"INSERT INTO aviso_sap(
					idcliente,
					codigo_establecimiento,
					id_inspeccion,
					alimentador,
					tipo_aviso,
					descripcion,
					descripcion_larga) 
				VALUES (
					'".$id."',
					'".$codigo_establecimiento."',
					'".$id_inspeccion."',
					'".$alimentador."',
					'".$tipo_aviso."',
					'".$descripcion."',
					'".$descripcion_larga."'
				)";

				if(!($mysqli->query($query2)))
					echo "Error en consulta insert aviso. ".$mysqli->error.". ";
				
			} else {
				echo('Error en el insert estructura: '.$mysqli->error);
			}
		} else {
			echo "La línea ".trim($_POST['instalacion'])." no existe en la base de datos";
		}
	}

		
	
	// Crear formulario excel de inspección para alivianar la carga a la hora de hacer una descarga masiva de documentacion. Se pueden editar campos especificos (nombre, prioridad). Ver json/edit.php
	/*
	// Hacer formulario
	$objPHPExcel = new PHPExcel();

  $objPHPExcel->getProperties()->setCreator("cge-pap") // Nombre del autor
  ->setLastModifiedBy("cge-pap") //Ultimo usuario que lo modificó
  ->setTitle("InformePoste") // Titulo
  ->setSubject("InformePoste") //Asunto
  ->setDescription("InformePoste") //Descripción
  ->setKeywords("InformePoste") //Etiquetas
  ->setCategory("InformePoste"); //Categorias

  $tituloReporte = "Ficha de inspección Pedestre";
  
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:AD1');
  $objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('B1',$tituloReporte);

  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B3:H3');
  $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Instalación (línea/alimentador)');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B4:H4');
  $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Establecimiento');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B5:H5');
  $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'CECO');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B6:H6');
  $objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Reconec. / Arranque');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B7:H7');
  $objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Sector');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B8:H8');
  $objPHPExcel->getActiveSheet()->SetCellValue('B8', 'Comuna');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B9:H9');
  $objPHPExcel->getActiveSheet()->SetCellValue('B9', 'Zona (0 - 1 - ….)');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B10:H10');
  $objPHPExcel->getActiveSheet()->SetCellValue('B10', 'OT (S)');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B11:H11');
  $objPHPExcel->getActiveSheet()->SetCellValue('B11', 'Número de Estructura');
$objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B12:H12');
  $objPHPExcel->getActiveSheet()->SetCellValue('B12', 'Numero de Placa');
  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B15:H15');
   $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B13:H13');
  $objPHPExcel->getActiveSheet()->SetCellValue('B13', 'Estructuras en Vano');
  $objPHPExcel->getActiveSheet()->SetCellValue('B14', 'URL');

  $objPHPExcel->getActiveSheet()->SetCellValue('C14', 'http://aconcagua.neering.cl/pap/ver.php?id='.$id_inspeccion.'');
  $objPHPExcel->getActiveSheet()
  ->getCell('C12')
  ->getHyperlink()
  ->setUrl('http://aconcagua.neering.cl/pap/ver.php?id='.$id_inspeccion.'')
  ->setTooltip('Click para ir a la ficha.');

  $objPHPExcel->getActiveSheet()->SetCellValue('B15', 'Tipo de inspección');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I3:U3');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:U4');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I5:U5');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I6:U6');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I7:U7');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I8:U8');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I9:U9');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I10:L10');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M10:Q10');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R10:U10');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I11:N11');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I12:N12');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I13:N13');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C14:N14');
  $objPHPExcel->getActiveSheet()->SetCellValue('I15', 'INSP');
  $objPHPExcel->getActiveSheet()->SetCellValue('K15', 'TER');
  $objPHPExcel->getActiveSheet()->SetCellValue('M15', 'PYC');

  		
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X3:AA3');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB3:AD3');
  $objPHPExcel->getActiveSheet()->SetCellValue('X3', 'N° FORMULARIO');

  $objDrawing = new PHPExcel_Worksheet_Drawing();
  $objDrawing->setName('test_img');
  $objDrawing->setDescription('test_img');
  $objDrawing->setPath('../img/logo.png');
  $objDrawing->setCoordinates('X4');                      
  //setOffsetX works properly
  $objDrawing->setOffsetX(5); 
  $objDrawing->setOffsetY(5);                
  //set width, height
  $objDrawing->setWidth(70); 
  $objDrawing->setHeight(70); 
  $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X9:AA9');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB9:AD9');
  $objPHPExcel->getActiveSheet()->SetCellValue('X9', 'Fecha');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X10:AA10');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB10:AD10');
  $objPHPExcel->getActiveSheet()->SetCellValue('X10', 'Hora Visita');

	$styleArray = array(
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
      ),
      'inside' => array(
        'style' => PHPExcel_Style_Border::BORDER_DOTTED
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B3:H10')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('E3:U10')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B11:H11')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('E11:N11')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B12:H12')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('E12:N12')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B13:H13')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('E13:N13')->applyFromArray($styleArray);


  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B15:N15')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B14:N14')->applyFromArray($styleArray);

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('X3:AD3')->applyFromArray($styleArray);

  $styleArray = array(
    'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('argb' => 'FFFFFFFF')
          ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('X4:AD8')->applyFromArray($styleArray);

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('X9:AD10')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B17:E19');

  $objPHPExcel->getActiveSheet()->SetCellValue('B17', 'Datos de la propiedad');
  $objPHPExcel->getActiveSheet()
  ->getStyle('B17:E19')
  ->getAlignment()
  ->setWrapText(true);

  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B17:E19')->applyFromArray($style);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F17:I17');
  $objPHPExcel->getActiveSheet()->SetCellValue('F17', 'Ubicación de la red');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F18:G18');
  $objPHPExcel->getActiveSheet()->SetCellValue('F18', 'BNUP');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H18:I18');
  $objPHPExcel->getActiveSheet()->SetCellValue('H18', 'Privado');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F19:G19');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H19:I19');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L17:Q17');
  $objPHPExcel->getActiveSheet()->SetCellValue('L17', 'Autorización de cliente');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L18:N19');
  $objPHPExcel->getActiveSheet()->SetCellValue('L18', 'Permite trabajos');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O18:Q19');
  $objPHPExcel->getActiveSheet()->SetCellValue('O18', 'No permite trabajos');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L20:N20');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O20:Q20');

  $objPHPExcel->getActiveSheet()
  ->getStyle('L18:N19')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->getActiveSheet()
  ->getStyle('O18:Q19')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S17:V17');
  $objPHPExcel->getActiveSheet()->SetCellValue('S17', 'Tipo de sector');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S18:T18');
  $objPHPExcel->getActiveSheet()->SetCellValue('S18', 'Rural');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('U18:V18');
  $objPHPExcel->getActiveSheet()->SetCellValue('U18', 'Urbano');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S19:T19');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('U19:V19');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X17:AC18');
  $objPHPExcel->getActiveSheet()->SetCellValue('X17', 'Factibilidad de ingreso camión');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X19:Z19');
  $objPHPExcel->getActiveSheet()->SetCellValue('X19', 'Si');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA19:AC19');
  $objPHPExcel->getActiveSheet()->SetCellValue('AA19', 'No');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X20:Z20');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA20:AC20');

  $objPHPExcel->getActiveSheet()
  ->getStyle('X17:AC18')
  ->getAlignment()
  ->setWrapText(true);

  $styleArray = array(
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      ),
      'inside' => array(
        'style' => PHPExcel_Style_Border::BORDER_DOTTED
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('F17:I18')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F19:I19')->applyFromArray($styleArray);

  $objPHPExcel->getActiveSheet()->getStyle('L17:Q19')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('L20:Q20')->applyFromArray($styleArray);

  $objPHPExcel->getActiveSheet()->getStyle('S17:V18')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('S19:V19')->applyFromArray($styleArray);

  $objPHPExcel->getActiveSheet()->getStyle('X17:AC19')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X20:AC20')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F22:K22');
  $objPHPExcel->getActiveSheet()->SetCellValue('F22', 'Contaminación');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F23:G23');
  $objPHPExcel->getActiveSheet()->SetCellValue('F23', 'Leve');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H23:I23');
  $objPHPExcel->getActiveSheet()->SetCellValue('H23', 'Media');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J23:K23');
  $objPHPExcel->getActiveSheet()->SetCellValue('J23', 'Severa');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F24:G24');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H24:I24');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J24:K24');


  $objPHPExcel->getActiveSheet()->getStyle('F22:K23')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F24:K24')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M22:O22');
  $objPHPExcel->getActiveSheet()->SetCellValue('M22', 'Propietario');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M23:O23');
  $objPHPExcel->getActiveSheet()->SetCellValue('M23', 'Dirección');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P22:AB22');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P23:AB23');

  $objPHPExcel->getActiveSheet()->getStyle('M22:AB22')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('M23:AB23')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B26:E28');

  $objPHPExcel->getActiveSheet()->SetCellValue('B26', 'Datos Técnicos');
  $objPHPExcel->getActiveSheet()
  ->getStyle('B26:E28')
  ->getAlignment()
  ->setWrapText(true);

  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B26:E28')->applyFromArray($style);


  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F26:I26');
  $objPHPExcel->getActiveSheet()->SetCellValue('F26', 'Nivel de tension');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F27:G27');
  $objPHPExcel->getActiveSheet()->SetCellValue('F27', 'AT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H27:I27');
  $objPHPExcel->getActiveSheet()->SetCellValue('F28', 'MT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F28:G28');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H28:I28');
  $objPHPExcel->getActiveSheet()->SetCellValue('F29', 'BT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F29:G29');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H29:I29');


  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K26:N26');
  $objPHPExcel->getActiveSheet()->SetCellValue('K26', 'Tipo de Linea');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L27:N27');
  $objPHPExcel->getActiveSheet()->SetCellValue('L27', 'Desnuda');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L28:N28');
  $objPHPExcel->getActiveSheet()->SetCellValue('L28', 'Protegida');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P26:R26');
  $objPHPExcel->getActiveSheet()->SetCellValue('P26', 'Tipo de Poste');
  $objPHPExcel->getActiveSheet()->SetCellValue('P27', 'H');
  $objPHPExcel->getActiveSheet()->SetCellValue('Q27', 'M');
  $objPHPExcel->getActiveSheet()->SetCellValue('R27', 'F');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T26:V26');
  $objPHPExcel->getActiveSheet()->SetCellValue('T26', 'Cruceta');
  $objPHPExcel->getActiveSheet()->SetCellValue('T27', 'H');
  $objPHPExcel->getActiveSheet()->SetCellValue('U27', 'M');
  $objPHPExcel->getActiveSheet()->SetCellValue('V27', 'F');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X26:AB26');
  $objPHPExcel->getActiveSheet()->SetCellValue('X26', 'Cruce de Lineas');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X27:AA27');
  $objPHPExcel->getActiveSheet()->SetCellValue('X27', 'AT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X28:AA28');
  $objPHPExcel->getActiveSheet()->SetCellValue('X28', 'MT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X29:AA29');
  $objPHPExcel->getActiveSheet()->SetCellValue('X29', 'BT');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X30:AA30');
  $objPHPExcel->getActiveSheet()->SetCellValue('X30', 'Corrientes Débiles');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X31:AA31');
  $objPHPExcel->getActiveSheet()->SetCellValue('X31', 'Ferrocarriles');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X32:AA32');
  $objPHPExcel->getActiveSheet()->SetCellValue('X32', 'Caminos');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X33:AA33');
  $objPHPExcel->getActiveSheet()->SetCellValue('X33', 'Fluvial');

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ),
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('F26:I29')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('K26:N28')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('P26:R28')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('T26:V28')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X26:AB33')->applyFromArray($styleArray);


  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B35:E38');

  $objPHPExcel->getActiveSheet()->SetCellValue('B35', 'Hallazgos externos encontrados');
  $objPHPExcel->getActiveSheet()
  ->getStyle('B35:E38')
  ->getAlignment()
  ->setWrapText(true);

  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B35:E38')->applyFromArray($style);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F35:N35');
  $objPHPExcel->getActiveSheet()->SetCellValue('F35', 'Árbol(es)');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F36:H37');
  $objPHPExcel->getActiveSheet()->SetCellValue('F36', 'Dentro de la franja');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I36:K37');
  $objPHPExcel->getActiveSheet()->SetCellValue('I36', 'Cercano a la linea');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L36:N37');
  $objPHPExcel->getActiveSheet()->SetCellValue('L36', 'Proyección de caída');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F38:H38');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I38:K38');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L38:N38');

  $objPHPExcel->getActiveSheet()
  ->getStyle('F36:H37')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->getActiveSheet()
  ->getStyle('I36:K37')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->getActiveSheet()
  ->getStyle('L36:N37')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P35:U35');
  $objPHPExcel->getActiveSheet()->SetCellValue('P35', 'Construcción');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P36:R37');
  $objPHPExcel->getActiveSheet()->SetCellValue('P36', 'Dentro de la franja');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S36:U37');
  $objPHPExcel->getActiveSheet()->SetCellValue('S36', 'Cercano a la linea');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P38:R38');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S38:U38');

  $objPHPExcel->getActiveSheet()
  ->getStyle('P36:R37')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->getActiveSheet()
  ->getStyle('S36:U37')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W35:Z36');
  $objPHPExcel->getActiveSheet()->SetCellValue('W35', 'Objeto externo sobre la red ');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W37:X37');
  $objPHPExcel->getActiveSheet()->SetCellValue('W37', 'Si');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Y37:Z37');
  $objPHPExcel->getActiveSheet()->SetCellValue('Y37', 'No');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('W38:X38');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Y38:Z38');

  $objPHPExcel->getActiveSheet()
  ->getStyle('W35:Z36')
  ->getAlignment()
  ->setWrapText(true);

  $styleArray = array(
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      ),
      'inside' => array(
        'style' => PHPExcel_Style_Border::BORDER_DOTTED
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('F35:N38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('P35:U38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('W35:Z38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F38:N38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('P38:U38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('W38:Z38')->applyFromArray($styleArray);


  $objPHPExcel->setActiveSheetIndex(0)
  ->mergeCells('B40:E41');

  $objPHPExcel->getActiveSheet()->SetCellValue('B40', 'Hallazgos internos encontrados');
  $objPHPExcel->getActiveSheet()
  ->getStyle('B40:E41')
  ->getAlignment()
  ->setWrapText(true);

  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B40:E41')->applyFromArray($style);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F40:AF40');
  $objPHPExcel->getActiveSheet()->SetCellValue('F40', 'Estado de las estructuras y conductrores');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F41:G41');
  $objPHPExcel->getActiveSheet()->SetCellValue('F41', 'Poste');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H41:I41');
  $objPHPExcel->getActiveSheet()->SetCellValue('H41', 'Cruceta');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J41:K41');
  $objPHPExcel->getActiveSheet()->SetCellValue('J41', 'Aislación');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L41:M41');
  $objPHPExcel->getActiveSheet()->SetCellValue('L41', 'Conductor');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N41:O41');
  $objPHPExcel->getActiveSheet()->SetCellValue('N41', 'Herraje');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P41:Q41');
  $objPHPExcel->getActiveSheet()->SetCellValue('P41', 'Altura');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R41:S41');
  $objPHPExcel->getActiveSheet()->SetCellValue('R41', 'Placa');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T41:U41');
  $objPHPExcel->getActiveSheet()->SetCellValue('T41', 'Número');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V41:W41');
  $objPHPExcel->getActiveSheet()->SetCellValue('V41', 'Tirante');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X41:Z41');
  $objPHPExcel->getActiveSheet()->SetCellValue('X41', 'Letrero Peligro');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA41:AC41');
  $objPHPExcel->getActiveSheet()->SetCellValue('AA41', 'Antiescalamiento');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AD41:AF41');
  $objPHPExcel->getActiveSheet()->SetCellValue('AD41', 'P. Antipajaros');  


  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F42:G42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H42:I42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J42:K42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L42:M42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N42:O42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P42:Q42');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R42:S42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T42:U42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V42:W42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X42:Z42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA42:AC42');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AD42:AF42');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F43:G43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H43:I43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J43:K43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L43:M43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N43:O43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P43:Q43');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R43:S43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T43:U43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V43:W43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X43:Z43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA43:AC43');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AD43:AF43');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F44:G44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H44:I44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J44:K44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L44:M44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N44:O44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P44:Q44');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('R44:S44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T44:U44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('V44:W44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('X44:Z44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA44:AC44');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('AD44:AF44');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B42:C42');
  $objPHPExcel->getActiveSheet()->SetCellValue('B42', 'Estado');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D42:E42');
  $objPHPExcel->getActiveSheet()->SetCellValue('D42', 'Bueno');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D43:E43');
  $objPHPExcel->getActiveSheet()->SetCellValue('D43', 'Malo');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D44:E44');
  $objPHPExcel->getActiveSheet()->SetCellValue('D44', 'Regular');

  $styleArray = array(
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      ),
      'inside' => array(
        'style' => PHPExcel_Style_Border::BORDER_DOTTED
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('F40:AF41')->applyFromArray($styleArray);

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ),
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );
  
  $objPHPExcel->getActiveSheet()->getStyle('F42:AF44')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D49:E49');
  $objPHPExcel->getActiveSheet()->SetCellValue('D49', 'Bueno');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D50:E50');
  $objPHPExcel->getActiveSheet()->SetCellValue('D50', 'Malo');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F47:N47');
  $objPHPExcel->getActiveSheet()->SetCellValue('F47', 'Estado termográfico');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F48:H48');
  $objPHPExcel->getActiveSheet()->SetCellValue('F48', 'Estructura');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I48:K48');
  $objPHPExcel->getActiveSheet()->SetCellValue('I48', 'Conexiones');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L48:N48');
  $objPHPExcel->getActiveSheet()->SetCellValue('L48', 'Equipos');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F49:H49');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I49:K49');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L49:N49');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F50:H50');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I50:K50');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L50:N50');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q47:T47');
  $objPHPExcel->getActiveSheet()->SetCellValue('Q47', 'Hebras Cortadas');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q48:R48');
  $objPHPExcel->getActiveSheet()->SetCellValue('Q48', 'Si');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S48:T48');
  $objPHPExcel->getActiveSheet()->SetCellValue('S48', 'No');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q49:R49');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S49:T49');

  $styleArray = array(
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      ),
      'inside' => array(
        'style' => PHPExcel_Style_Border::BORDER_DOTTED
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('F47:N48')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('Q47:T48')->applyFromArray($styleArray);

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ),
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );
  
  $objPHPExcel->getActiveSheet()->getStyle('F49:N50')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('Q49:T49')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D52:E53');
  $objPHPExcel->getActiveSheet()->SetCellValue('D52', 'N° Fases');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D54:E56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F52:V52');
  $objPHPExcel->getActiveSheet()->SetCellValue('F52', 'Información');
  
  $objPHPExcel->getActiveSheet()->SetCellValue('H53', 'Tipo');
  $objPHPExcel->getActiveSheet()->SetCellValue('J53', 'Discos Buenos');
  $objPHPExcel->getActiveSheet()->SetCellValue('M53', 'Discos Malos');
  $objPHPExcel->getActiveSheet()->SetCellValue('P53', 'Uniones Vano');
  $objPHPExcel->getActiveSheet()->SetCellValue('S53', 'Estado Ferreteria');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F53:G53');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H53:I53');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J53:L53');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M53:O53');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P53:R53');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S53:V53');

  $objPHPExcel->getActiveSheet()->SetCellValue('F54', 'Fase 1');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F54:G54');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H54:I54');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J54:L54');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M54:O54');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P54:R54');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S54:V54');

  $objPHPExcel->getActiveSheet()->SetCellValue('F55', 'Fase 2');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F55:G55');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H55:I55');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J55:L55');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M55:O55');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P55:R55');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S55:V55');

  $objPHPExcel->getActiveSheet()->SetCellValue('F56', 'Fase 3');

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F56:G56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H56:I56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J56:L56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M56:O56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P56:R56');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('S56:V56');

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ),
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );
  
  $objPHPExcel->getActiveSheet()->getStyle('D52:V56')->applyFromArray($styleArray);


  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Y52:AB52');
  $objPHPExcel->getActiveSheet()->SetCellValue('Y52', 'Prioridad');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z53:AB53');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z53', 'Inmediata');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z54:AB54');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z54', 'Priorizada');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z55:AB55');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z55', 'Media');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z56:AB56');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z56', 'Baja');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z57:AB57');
  $objPHPExcel->getActiveSheet()->SetCellValue('Z57', 'No Requiere');

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    ),
    'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('Y52:AB57')->applyFromArray($styleArray);

  

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B59:AF59');
  $objPHPExcel->getActiveSheet()->SetCellValue('B59', 'Observaciones');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B60:AF62');

  $styleArray = array(
    'borders' => array(
      'allborders' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );
  $objPHPExcel->getActiveSheet()->getStyle('B59:AF62')->applyFromArray($styleArray);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B64:F64');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G64:M64');
  $objPHPExcel->getActiveSheet()->SetCellValue('B64', 'Nombre Inspector');
  $objPHPExcel->getActiveSheet()->SetCellValue('B67', 'Firma');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('U64:Y64');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Z64:AF64');
  $objPHPExcel->getActiveSheet()->SetCellValue('U64', 'Nombre Supervisor');
  $objPHPExcel->getActiveSheet()->SetCellValue('U67', 'Firma');

  $objPHPExcel->getActiveSheet()->getStyle('B64:M64')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('U64:AF64')->applyFromArray($styleArray);

   $styleArray = array(
    'borders' => array(
      'outline' => array(
        'style' => PHPExcel_Style_Border::BORDER_THIN
      )
    )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B65:M67')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('U65:AF67')->applyFromArray($styleArray);

  $estiloTituloReporte = array(
      'font' => array(
          'name'      => 'Verdana',
          'bold'      => true,
          'italic'    => false,
          'strike'    => false,
          'size' =>16,
          'color'     => array(
              'rgb' => '000000'
          )
      ),
      'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
              'argb' => 'FFFFFFFF')
    ),
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_NONE
          )
      ),
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
          'rotation' => 0
          
      )
  );

  $objPHPExcel->getActiveSheet()->getStyle('B1:AD1')->applyFromArray($estiloTituloReporte);
   
  $styleArray = array(
      'font'  => array(
          'bold'  => true
      ));

  $objPHPExcel->getActiveSheet()->getStyle('B3:H13')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B14')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B15:H15')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B17:E19')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F17:I17')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('L17:Q17')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('S17:V17')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X17:AC18')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F22:K22')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('M22:O23')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B26:E28')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F26:I26')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('K26:N26')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('P26:R26')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('T26:V26')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X26:AB26')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B35:E38')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F35:N35')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('P35:U35')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('W35:Z36')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B40:E41')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F40:AF40')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B42:C42')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('F47:N47')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('Q47:T47')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('D52:V53')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('G54:G56')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('Y52:AB52')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B59:AF59')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B64:F64')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('U64:Y64')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('B67')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('U67')->applyFromArray($styleArray);

  $objPHPExcel->getActiveSheet()->getStyle('X3:AA3')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X9:AA9')->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet()->getStyle('X10:AA10')->applyFromArray($styleArray);

///////
  $mysqli = new mysqli($host, $admin, $password, $db_name);
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  $mysqli->set_charset('utf8');
  
  $result = $mysqli->query("SELECT * FROM inspeccion WHERE id=".$id_inspeccion." LIMIT 1");

$myrow = $result->fetch_array(MYSQLI_ASSOC);
  $folio=sprintf("%05d",intval($myrow["id"]));
  $objPHPExcel->getActiveSheet()->SetCellValue('AB3',substr($myrow["establecimiento"], 2).'-'.strval($folio));
  $objPHPExcel->getActiveSheet()->SetCellValue('AB9', $myrow["fecha"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB10', $myrow["hora"]);

  $objPHPExcel->getActiveSheet()->SetCellValue('I3', $myrow["instalacion"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I4', $myrow["establecimiento"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I5', $myrow["ceco"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I6', $myrow["recarran"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I7', $myrow["sector"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I8', $myrow["comuna"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I9', $myrow["zona"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I10', $myrow["ot1"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('M10', $myrow["ot2"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('R10', $myrow["ot3"]);
  

  $objPHPExcel->getActiveSheet()->SetCellValue('I11', $myrow["num_estructura"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I12', $myrow["nombre"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('I13', $myrow["num_estructura_vano"]);

  if($myrow["tipo_inspeccion"]=='INSP')
    $objPHPExcel->getActiveSheet()->SetCellValue('J15', 'X');
  if($myrow["tipo_inspeccion"]=='TER')
    $objPHPExcel->getActiveSheet()->SetCellValue('L15', 'X');
  if($myrow["tipo_inspeccion"]=='PYC')
    $objPHPExcel->getActiveSheet()->SetCellValue('N15', 'X');

  if($myrow["ubicacion_red"]=='BNUP')
    $objPHPExcel->getActiveSheet()->SetCellValue('F19', 'X');
  if($myrow["ubicacion_red"]=='Privado')
    $objPHPExcel->getActiveSheet()->SetCellValue('H19', 'X');
  
  if($myrow["autorizacion_cliente"]=='Permite')
    $objPHPExcel->getActiveSheet()->SetCellValue('L20', 'X');
  if($myrow["autorizacion_cliente"]=='No Permite')
    $objPHPExcel->getActiveSheet()->SetCellValue('O20', 'X');
  
  if($myrow["tipo_sector"]=='Rural')
    $objPHPExcel->getActiveSheet()->SetCellValue('S19', 'X');
  if($myrow["tipo_sector"]=='Urbano')
    $objPHPExcel->getActiveSheet()->SetCellValue('U19', 'X');
  
  if($myrow["ingreso_camion"]=='Si')
    $objPHPExcel->getActiveSheet()->SetCellValue('X20', 'X');
  if($myrow["ingreso_camion"]=='No')
    $objPHPExcel->getActiveSheet()->SetCellValue('AA20', 'X');

  if($myrow["contaminacion"]=='Leve')
    $objPHPExcel->getActiveSheet()->SetCellValue('F24', 'X');
  if($myrow["contaminacion"]=='Media')
    $objPHPExcel->getActiveSheet()->SetCellValue('H24', 'X');
  if($myrow["contaminacion"]=='Severa')
    $objPHPExcel->getActiveSheet()->SetCellValue('J24', 'X');

  $objPHPExcel->getActiveSheet()->SetCellValue('P22', $myrow["propietario"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('P23', $myrow["propietario_dir"]);
  
  if($myrow["tension"]=='AT')
    $objPHPExcel->getActiveSheet()->SetCellValue('H27', 'X');
  if($myrow["tension"]=='MT')
    $objPHPExcel->getActiveSheet()->SetCellValue('H28', 'X');
  if($myrow["tension"]=='BT')
    $objPHPExcel->getActiveSheet()->SetCellValue('H29', 'X');

  if($myrow["tipo_linea"]=='Desnuda')
    $objPHPExcel->getActiveSheet()->SetCellValue('K27', 'X');
  if($myrow["tipo_linea"]=='Protegida')
    $objPHPExcel->getActiveSheet()->SetCellValue('K28', 'X');
  
  if($myrow["tipo_poste"]=='H')
    $objPHPExcel->getActiveSheet()->SetCellValue('P28', 'X');
  if($myrow["tipo_poste"]=='M')
    $objPHPExcel->getActiveSheet()->SetCellValue('Q28', 'X');
  if($myrow["tipo_poste"]=='F')
    $objPHPExcel->getActiveSheet()->SetCellValue('R28', 'X');
  
  if($myrow["cruceta"]=='H')
    $objPHPExcel->getActiveSheet()->SetCellValue('T28', 'X');
  if($myrow["cruceta"]=='M')
    $objPHPExcel->getActiveSheet()->SetCellValue('U28', 'X');
  if($myrow["cruceta"]=='F')
    $objPHPExcel->getActiveSheet()->SetCellValue('V28', 'X');
  
  $objPHPExcel->getActiveSheet()->SetCellValue('AB27', $myrow["crucesAT"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB28', $myrow["crucesMT"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB29', $myrow["crucesBT"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB30', $myrow["cant_corrientes_debiles"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB31', $myrow["cant_ferrocarriles"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB32', $myrow["cant_caminos"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('AB33', $myrow["cant_fluvial"]);

  if($myrow["arboles"]=='Dentro de la franja')
    $objPHPExcel->getActiveSheet()->SetCellValue('F38', 'X');
  if($myrow["arboles"]=='Bajo la línea')
    $objPHPExcel->getActiveSheet()->SetCellValue('I38', 'X');
  if($myrow["arboles"]=='Proyección de caída')
    $objPHPExcel->getActiveSheet()->SetCellValue('L38', 'X');
  if($myrow["arboles"]=='Dentro de la franja y bajo la línea')
    $objPHPExcel->getActiveSheet()->SetCellValue('F38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('I38', 'X');
  if($myrow["arboles"]=='Dentro de la franja y proyección de caída')
    $objPHPExcel->getActiveSheet()->SetCellValue('F38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('L38', 'X');
  if($myrow["arboles"]=='Bajo la línea y proyección de caída')
    $objPHPExcel->getActiveSheet()->SetCellValue('I38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('L38', 'X');
  if($myrow["arboles"]=='Dentro de la franja, bajo la línea y proyección de caída')
    $objPHPExcel->getActiveSheet()->SetCellValue('F38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('I38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('L38', 'X');
    
  if($myrow["construccion"]=='Dentro de la franja')
    $objPHPExcel->getActiveSheet()->SetCellValue('P38', 'X');
  if($myrow["construccion"]=='Bajo la línea')
    $objPHPExcel->getActiveSheet()->SetCellValue('S38', 'X');
  if($myrow["construccion"]=='Dentro de la franja y bajo la línea')
    $objPHPExcel->getActiveSheet()->SetCellValue('P38', 'X');
    $objPHPExcel->getActiveSheet()->SetCellValue('S38', 'X');
  
  if($myrow["objeto_externo"]=='Si')
    $objPHPExcel->getActiveSheet()->SetCellValue('W38', 'X');
  if($myrow["objeto_externo"]=='No')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y38', 'X');
  
  if($myrow["e_poste"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('F42', 'X');
  if($myrow["e_poste"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('F43', 'X');
  if($myrow["e_poste"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('F44', 'X');
  
  if($myrow["e_cruceta"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('H42', 'X');
  if($myrow["e_cruceta"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('H43', 'X');
  if($myrow["e_cruceta"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('H44', 'X');
  
  if($myrow["e_aislacion"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('J42', 'X');
  if($myrow["e_aislacion"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('J43', 'X');
  if($myrow["e_aislacion"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('J44', 'X');
  
  if($myrow["e_conductor"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('L42', 'X');
  if($myrow["e_conductor"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('L43', 'X');
  if($myrow["e_conductor"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('L44', 'X');
  
  if($myrow["e_herraje"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('N42', 'X');
  if($myrow["e_herraje"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('N43', 'X');
  if($myrow["e_herraje"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('N44', 'X');
  
  if($myrow["e_flecha"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('P42', 'X');
  if($myrow["e_flecha"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('P43', 'X');
  if($myrow["e_flecha"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('P44', 'X');

  if($myrow["e_placa"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('R42', 'X');
  if($myrow["e_placa"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('R43', 'X');
  if($myrow["e_placa"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('R44', 'X');

  if($myrow["e_numero"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('T42', 'X');
  if($myrow["e_numero"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('T43', 'X');
  if($myrow["e_numero"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('T44', 'X');

  if($myrow["e_tirante"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('V42', 'X');
  if($myrow["e_tirante"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('V43', 'X');
  if($myrow["e_tirante"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('V44', 'X');

  if($myrow["e_letrero_peligro"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('X42', 'X');
  if($myrow["e_letrero_peligro"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('X43', 'X');
  if($myrow["e_letrero_peligro"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('X44', 'X');

  if($myrow["e_antiescalamiento"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('AA42', 'X');
  if($myrow["e_antiescalamiento"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('AA43', 'X');
  if($myrow["e_antiescalamiento"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('AA44', 'X');

  if($myrow["e_antipajaros"]=='Bueno')
    $objPHPExcel->getActiveSheet()->SetCellValue('AD42', 'X');
  if($myrow["e_antipajaros"]=='Malo')
    $objPHPExcel->getActiveSheet()->SetCellValue('AD43', 'X');
  if($myrow["e_antipajaros"]=='Regular')
    $objPHPExcel->getActiveSheet()->SetCellValue('AD44', 'X');

  

  //TERMOGRAFIA
  if($myrow["e_estructura"]=='Normal')
    $objPHPExcel->getActiveSheet()->SetCellValue('F49', 'X');
  if($myrow["e_estructura"]=='Irregular')
    $objPHPExcel->getActiveSheet()->SetCellValue('F50', 'X');
  
  if($myrow["e_conexiones"]=='Normal')
    $objPHPExcel->getActiveSheet()->SetCellValue('I49', 'X');
  if($myrow["e_conexiones"]=='Irregular')
    $objPHPExcel->getActiveSheet()->SetCellValue('I50', 'X');
  
  if($myrow["cant_hebras_cortadas"]=='0')
    $objPHPExcel->getActiveSheet()->SetCellValue('S49', 'X');
  if($myrow["cant_hebras_cortadas"]=='1')
    $objPHPExcel->getActiveSheet()->SetCellValue('Q49', 'X');

  $objPHPExcel->getActiveSheet()->SetCellValue('D54',  $myrow["n_fases"]);

  $objPHPExcel->getActiveSheet()->SetCellValue('H54',  $myrow["fase1"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('J54',  $myrow["fase1db"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('M54',  $myrow["fase1dm"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('P54',  $myrow["fase1uv"]);

  if ($rows[0]['fase1e_ferreteria'] == '0'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S54',  'Bueno');
  }
  if ($rows[0]['fase1e_ferreteria'] == '1'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S54',  'Malo');
  }
  if ($rows[0]['fase1e_ferreteria'] == '2'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S54',  'Regular');
  }
  if ($rows[0]['fase1e_ferreteria'] == '3'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S54',  'No aplica');
  }
  if ($rows[0]['fase1e_ferreteria'] == '4'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S54',  'No posee');
  }

  $objPHPExcel->getActiveSheet()->SetCellValue('H55',  $myrow["fase2"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('J55',  $myrow["fase2db"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('M55',  $myrow["fase2dm"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('P55',  $myrow["fase2uv"]);

  if ($rows[0]['fase2e_ferreteria'] == '0'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S55',  'Bueno');
  }
  if ($rows[0]['fase2e_ferreteria'] == '1'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S55',  'Malo');
  }
  if ($rows[0]['fase2e_ferreteria'] == '2'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S55',  'Regular');
  }
  if ($rows[0]['fase2e_ferreteria'] == '3'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S55',  'No aplica');
  }
  if ($rows[0]['fase2e_ferreteria'] == '4'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S55',  'No posee');
  }

  $objPHPExcel->getActiveSheet()->SetCellValue('H56',  $myrow["fase3"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('J56',  $myrow["fase3db"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('M56',  $myrow["fase3dm"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('P56',  $myrow["fase3uv"]);
  $objPHPExcel->getActiveSheet()->SetCellValue('D54',  $myrow["n_fases"]);

  if ($rows[0]['fase3e_ferreteria'] == '0'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S56',  'Bueno');
  }
  if ($rows[0]['fase3e_ferreteria'] == '1'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S56',  'Malo');
  }
  if ($rows[0]['fase3e_ferreteria'] == '2'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S56',  'Regular');
  }
  if ($rows[0]['fase3e_ferreteria'] == '3'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S56',  'No aplica');
  }
  if ($rows[0]['fase3e_ferreteria'] == '4'){
    $objPHPExcel->getActiveSheet()->SetCellValue('S56',  'No posee');
  }


  if($myrow["prioridad"]=='Inmediata')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y53', 'X');
  if($myrow["prioridad"]=='Priorizada')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y54', 'X');
  if($myrow["prioridad"]=='Baja')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y55', 'X');
  if($myrow["prioridad"]=='No Requiere')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y56', 'X');
  if($myrow["prioridad"]=='Media')
    $objPHPExcel->getActiveSheet()->SetCellValue('Y55', 'X');

  $objPHPExcel->getActiveSheet()->SetCellValue('B60',  $myrow["obs"]);
  $objPHPExcel->getActiveSheet()
  ->getStyle('B60:AF62')
  ->getAlignment()
  ->setWrapText(true);

  $objPHPExcel->getActiveSheet()->SetCellValue('G64',  $myrow["responsable"]);
  
  $result->close();

/////
  $style = array(
      'alignment' => array(
          'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
          'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
  );


  $styleArray = array(
  	'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('argb' => 'FFFFFFFF')
          ),
  'font'  => array(
      'size'  => 10
  ));
  $objPHPExcel->getActiveSheet()->getStyle('B3:AF70')->applyFromArray($styleArray);

  $styleArray = array(
  'font'  => array(
      'size'  => 8
  ));
  $objPHPExcel->getActiveSheet()->getStyle('F41:AF41')->applyFromArray($styleArray);

  $objPHPExcel->getDefaultStyle()->applyFromArray(
      array(
          'fill' => array(
              'type'  => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('argb' => 'FFFFFFFF')
          ),
      )
  );




  
  for($i = 'A'; $i <= 'Z'; $i++){
  	$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setWidth(4);
  }

  $objPHPExcel->getActiveSheet()->setTitle('Informe');
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);    
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);    
  $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:AG69');
  // Se activa la hoja para que sea la que se muestre cuando el archivo se abre
  $objPHPExcel->setActiveSheetIndex(0);

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('../img/uploads/'.$id_inspeccion.'/InformePoste.xlsx');*/
}
$mysqli->close();
?>