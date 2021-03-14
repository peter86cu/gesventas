<?php
#===========================================#
#           LIBRERÍA DE FUNCIONES           #
#         creado por Acner Pinazo         	#
#             acner999{}hotmail.com         #
#                 Jun - 2011                #
#===========================================#
//cambios----------------
//22/06/2011 cambie para que el qrow traiga tambien los idiomas predeterminados
//27/06/2011 cree nueva funcion para traer las miniaturas
//28/06/2011 cree funciones para exportar a excel y a word y limpiar los campos de excel

include_once 'utf8-clean.php'; // Archivo requerido para varias funciones

#====== FUNCIONES ======#

//Obtiene la IP del cliente
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

# Devuelve un fragmento del texto
function fragmento($texto, $long){
	if(strlen($texto) > $long):
		$expresionregular = '/(^.{0,'.($long - 1).'}\w)(\s)+/s';
		preg_match($expresionregular, $texto, $ereg);
		$retorno = $ereg[1].'...';
	else:
		$retorno = $texto;
	endif;
	return $retorno;
}

# Reemplaza caracteres especiales por comunes
function url_ami($texto){
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	$texto = strtolower(strtr(iso_clean($texto), utf8_decode($tofind), $replac));
	$texto = preg_replace("/[^a-z0-9]+/s", '-', $texto);
	$texto = preg_replace("/(^-|-$)/", '', $texto);
	return $texto;
}

# Reemplaza caracteres especiales por comunes
function text_ami($texto){
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	$texto = strtolower(strtr(iso_clean($texto), utf8_decode($tofind), $replac));
	$texto = trim(preg_replace("/[^a-z0-9\.,]+/s", ' ', $texto));
	return $texto;
}

# Retorna todas las palabras de un texto
function keywords($texto){
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	$texto = strtr(iso_clean($texto), utf8_decode($tofind), $replac);
	$texto = strtolower($texto);
	$texto = preg_replace('/\W+/', '-', $texto);
	$texto = preg_replace('/\b\w{1,3}-/', '', $texto);
	$texto = preg_replace("/-$|^-/", '', $texto);
	$texto_arr = array_count_values(explode('-', $texto));
	arsort($texto_arr);
	return implode(',', array_keys($texto_arr));
}

function simbolo_moneda($numero, $moneda = true,$decimal=false, $id){
	
	if($id==1){
	if($decimal){$d=2;}else{$d=0;}
	return (($moneda)?'Gs. ':'').((!empty($numero))?(number_format($numero, $d, ',', '.')):'0');
	}if($id==2){
		return  (($moneda)?'US$. ':'').((!empty($numero))?(number_format($numero, 2, '.', ',')):'0');
	}if($id==3){
		return (($moneda)?'$. ':'').number_format($numero, 2, ',', '.');
	}if($id==4){
		return (($moneda)?'&euro;. ':'').number_format($numero, 2, ',', '.');
	}
}

# Retorna un numero formateado como moneda en guaraníes
function mgs($numero, $moneda = true,$decimal=false){
	if($decimal){$d=2;}else{$d=0;}
	return (($moneda)?'Gs. ':'').((!empty($numero))?(number_format($numero, $d, ',', '.')):'0');
}

# Retorna un numero formateado como moneda en dolares
function mdl($numero, $moneda = true){
	return (($moneda)?'US$. ':'').((!empty($numero))?(number_format($numero, 2, '.', ',')):'0');

}

# Retorna un numero formateado como moneda en pesos
function mps($numero, $moneda = true){
	return (($moneda)?'$. ':'').number_format($numero, 2, ',', '.');
}

# Retorna un numero formateado como moneda en pesos
function meu($numero, $moneda = true){
	return (($moneda)?'&euro;. ':'').number_format($numero, 2, ',', '.');
}

# Retorna un numero formateado como moneda en pesos
function mrs($numero, $moneda = true){
	return (($moneda)?'R$. ':'').number_format($numero, 2, ',', '.');
}

# Retorna un número formateado como la moneda predeterminada
function mon($numero, $moneda = true){
	return mgs($numero, $moneda);
}

# Retorna la base url del archivo actual
function base($pagina = false){ global $_claves;
	if($pagina){
		$base = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	}
	else{
		
		if($_claves["direccion_sistema"]!=''){
			$base =$_claves["direccion_sistema"];
		}else{
			$base = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);
		if(substr($base, -1, 1) != '/') $base .= '/';	
		}
		
	}
	return $base;
}

# Opciones de fecha
function fecha($_fecha, $_formato = 'd-m-Y', $_tipo = 'maq'){
	// Obtiene los datos según el formato de origen
	switch($_tipo):
		case 'maq':
			if(!preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $_fecha, $reg))
				if(!preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $_fecha, $reg))
					preg_match('/()()()([0-9]{2}):([0-9]{2}):([0-9]{2})/', $_fecha, $reg);
			$r->fecha   = $reg[0];
			$r->ano     = $reg[1];
			$r->mes     = $reg[2];
			$r->dia     = $reg[3];
			$r->hora    = $reg[4];
			$r->minuto  = $reg[5];
			$r->segundo = $reg[6];
			break;
		case 'dmy';
			preg_match('/([0-9]{1,2})(-|\/|\|)([0-9]{1,2})(-|\/|\|)([0-9]{2,4})/', $_fecha, $reg);
			$r->fecha   = $reg[0];
			$r->ano     = $reg[5];
			$r->mes     = $reg[3];
			$r->dia     = $reg[1];
			$r->hora    = 0;
			$r->minuto  = 0;
			$r->segundo = 0;
			break;
		case 'mdy';
			preg_match('/([0-9]{1,2})(-|\/|\|)([0-9]{1,2})(-|\/|\|)([0-9]{2,4})/', $_fecha, $reg);
			$r->fecha   = $reg[0];
			$r->ano     = $reg[5];
			$r->mes     = $reg[1];
			$r->dia     = $reg[3];
			$r->hora    = 0;
			$r->minuto  = 0;
			$r->segundo = 0;
			break;
		case 'ymd';
			preg_match('/([0-9]{2,4})(-|\/|\|)([0-9]{1,2})(-|\/|\|)([0-9]{1,2})/', $_fecha, $reg);
			$r->fecha   = $reg[0];
			$r->ano     = $reg[1];
			$r->mes     = $reg[3];
			$r->dia     = $reg[5];
			$r->hora    = 0;
			$r->minuto  = 0;
			$r->segundo = 0;
			break;
	endswitch;

	// Devuelve los datos según el formato de destino, o una cadena vacía si la fecha no es válida
	if($r->mes > 0 && $r->dia > 0 && !checkdate((int)$r->mes, (int)$r->dia, (int)$r->ano)){
		$return = '';
	}
	else{
		$return = date($_formato, mktime((int)$r->hora, (int)$r->minuto, (int)$r->segundo, (int)$r->mes, (int)$r->dia, (int)$r->ano));
	}
	return $return;
}

# Obtiene el listado de categorías hijas y sub-hijas, incluyendo los índices padres
function get_hijos($indices, $tabla = 'categorias', $padre = 'padre_id', $id = 'id'){
	$res = mysql_query("SELECT GROUP_CONCAT({$id}) FROM {$tabla} WHERE {$padre} IN ({$indices})");
	if($ids = mysql_result($res, 0)){
		$hijos = get_hijos($ids, $tabla, $padre, $id);
	}
	if($hijos) $indices .= ','.$hijos;
	return $indices;
}

# Obtiene el listado de categorías hijas y sub-hijas, incluyendo los índices padres en un array
function get_hijos_arr($indices, $tabla = 'categorias', $padre = 'padre_id', $id = 'id'){
	return explode(',', get_hijos($indices, $tabla, $padre, $id));
}

# Crea el arbol de objetos hasta el nivel superior.
function get_path($indice, $tabla = 'categorias', $padre = 'padre_id', $id = 'id'){
	$path = array();
	while($indice > 0){
		$res = mysql_query("SELECT * FROM {$tabla} WHERE {$id} = '{$indice}' LIMIT 1");
		$indice = 0;
		while($row = mysql_fetch_object($res)){
			$indice = $row->{$padre};
			$path[] = $row;
		}
	}
	return array_reverse($path);
}

# Obtiene la ciudad de la DB desde el índice
function ciudad_db($indice){
	$res = mysql_query("SELECT descripcion FROM ciudades WHERE id = '{$indice}'");
	$return = @mysql_result($res, 0);
	return $return;
}

# Obtiene el pais de la DB desde el índice de la ciudad
function pais_db($indice){
	$res = mysql_query("SELECT paises.descripcion FROM paises, ciudades WHERE paises.id = ciudades.pais_id AND ciudades.id = '{$indice}'");
	$return = @mysql_result($res, 0);
	return $return;
}

# Convierte a una variante de base64 para usar sin problemas en urls
function base64_url_encode($input) {
	return strtr(base64_encode($input), '+/=', '_~-');
}

# Convierte desde una variante de base64 para usar sin problemas en urls
function base64_url_decode($input) {
	return base64_decode(strtr($input, '_~-', '+/='));
}

# Genera la url para la miniatura
function thumb($img, $ancho = '', $alto = '', $recortar = 0, $rellenar = 0){
	//$img = str_replace('%2F', '/', rawurlencode(iso_clean($img)));
	//$return = "foto.php?src={$img}&x={$ancho}&y={$alto}&r={$recortar}&c={$rellenar}";
	$ruta = stristr($img, '/') ? dirname($img).'/' : '';
	$img = rawurlencode(iso_clean(basename($img)));
	$param = array('x' => $ancho,
	               'y' => $alto,
								 'r' => $recortar,
								 'c' => $rellenar);
	$return = $ruta.'tdd'.base64_url_encode(json_encode($param)).'/'.$img;
	return $return;
}

# Genera la url para la miniatura
function miniatura($img, $ancho = '', $alto = '', $recortar = 0, $rellenar = 0){
	//$img = str_replace('%2F', '/', rawurlencode(iso_clean($img)));
	//$return = "foto.php?src={$img}&x={$ancho}&y={$alto}&r={$recortar}&c={$rellenar}";
	$ruta = stristr($img, '/') ? dirname($img).'/' : '';
	$img = rawurlencode(iso_clean(basename($img)));
	$param = array('x' => $ancho,
	               'y' => $alto,
								 'r' => $recortar,
								 'c' => $rellenar);
	$return = $ruta.'-miniatura'.base64_url_encode(json_encode($param)).'.'.$img;
	return $return;
}

# Aplica el rawurlencode junto con el iso_clean
function iso_rawurlencode($texto){
	return rawurlencode(iso_clean($texto));
}

# Realiza una consulta básica
function leer($campo, $tabla, $where = 1){
	$res = mysql_query("SELECT {$campo} FROM {$tabla} WHERE {$where} LIMIT 1");
	$return = @mysql_result($res, 0);
	return $return;
}

# Devuelve el resultado con links de una consulta sql como array de objetos
function qsql($sql, $link_char = '', $link_column = 'titulo'){
	$arr = array();
	$res = mysql_query($sql);
	while($row = mysql_fetch_object($res)){
		if($link_char != ''){
			$row->vinculo = link_ami($row->{$link_column}, $row->id, $link_char);
		}
		$arr[] = $row;
	}
	return $arr;
}

# Obtiene el resultado con links de una consulta sql como array de objetos, a partir del nombre de tabla, condición y límites
function qlist($tabla, $where = '', $limit = '', $link_char = '', $link_column = 'titulo'){
	if($where != '') $_where = "WHERE {$where}";
	if($limit != '') $_limit = "LIMIT {$limit}";
	$qry = "SELECT * FROM {$tabla} {$_where} {$_limit}";
	$return = qsql($qry, $link_char, $link_column);
	return $return;
}

# Obtiene el resultado de una consulta sql como un objeto, a partir del nombre de tabla, condición
function qrow($tabla, $where = ''){
	if($where != '') $_where = "WHERE {$where}";
	$qry = "SELECT * FROM {$tabla} {$_where} LIMIT 1";
	$res = mysql_query($qry);
	$return = @mysql_fetch_object($res);
	return $return;
	
}

# Limpia el utf8 del contenido por referencia (es necesario cargar el archivo utf8-clean.php)
function uclean(&$texto){
	if(is_array($texto)){
		foreach($texto as $_ind => $item){
			uclean($texto[$_ind]);
		}
	}
	elseif(is_object($texto)){
		foreach($texto as $_ind => $item){
			uclean($texto->{$_ind});
		}
	}
	else{
		$texto = utf8_clean($texto);
	}
}

# Limpia el iso del contenido por referencia (es necesario cargar el archivo utf8-clean.php)
function iclean(&$texto){
	if(is_array($texto)){
		foreach($texto as $_ind => $item){
			iclean($texto[$_ind]);
		}
	}
	elseif(is_object($texto)){
		foreach($texto as $_ind => $item){
			iclean($texto->{$_ind});
		}
	}
	else{
		$texto = iso_clean($texto);
	}
}

# Devuelve un id único para el pedido y guarda en la sesión, en caso de existencia, devuelve el id guardado en la sesión
function get_pedido_id($nuevo = false){
	if((int)$_SESSION['id_pedido'] == 0 || $nuevo){
		mysql_query("INSERT INTO ids (fecha) VALUES ('".date('Y-m-d H:i:s')."')");
		$_SESSION['id_pedido'] = mysql_insert_id();
	}
	return $_SESSION['id_pedido'];
}

# Devuelve la cantidad de ítems del carrito
function get_cart_items(){
	$pedido_id = $_SESSION['id_pedido']; // Se lee directamente de la sesión para no generar ids innecesarios
	$res = mysql_query("SELECT SUM(cantidad) FROM carrito WHERE pedido_id = '{$pedido_id}'");
	$return = @mysql_result($res, 0);
	return (int)$return;
}

# Devuelve el siguiente id para una tabla de multi idiomas
function get_new_table_id($tabla, $id = 'id'){
	$res = pg_query("SELECT MAX({$id}) FROM {$tabla}");
	return @pg_fetch_result($res, 0) + 1;
}

# Devuelve la última cotización de la moneda solicitada
function get_cotizacion($moneda = 'dolar'){
	$valor = leer('valor', 'cotizaciones', "moneda = '{$moneda}' ORDER BY fecha DESC");
	if($valor == 0) $valor = 1;
	return $valor;
}

# Devuelve el link armado con url amigable
function link_ami($texto, $id, $link_char){
	return url_ami($texto).'-'.$link_char.$id.".html";
}

# Agrega los escapes a comillas en caso de que no esté activada la función magic_quotes_gpc
function autoslashes(&$texto){
	if(!get_magic_quotes_gpc()){
		if(is_array($texto)){
			foreach($texto as $_ind => $item){
				autoslashes($texto[$_ind]);
			}
		}
		elseif(is_object($texto)){
			foreach($texto as $_ind => $item){
				autoslashes($texto->{$_ind});
			}
		}
		else{
			$texto = addslashes($texto);
		}
	}
}

# Convierte todos los emails en tags a con link "mailto" (no distingue si los emails ya poseen link)
function add_email_links($texto){
	$return = preg_replace('/([_a-z0-9-]+(?:\.[_a-z0-9-]+)*@[a-z0-9-]+(?:\.[a-z0-9-]+)*(?:\.[a-z]{2,4})+)/i', '<a href="mailto:$1">$1</a>', $texto);
	return $return;
}
function limpiar($string)
{
  if(get_magic_quotes_gpc())  // prevents duplicate backslashes
  {
    $string = stripslashes($string);
  }
  if (phpversion() >= '4.3.0')
  {
    $string = mysql_real_escape_string($string);
  }
  else
  {
    $string = mysql_escape_string($string);
  }
  return $string;
}
# Obtiene la marca de tiempo de UNIX
function gmt_timestamp($fecha){
	
}

//obtener los accesos
function readAccesos(){
	$main_menu = array();
	$main_menu_sort = array();
	$dirs = array();
	$base = "./modules/";

	if(is_dir($base)){
		if($dh = opendir($base)){
			while(($read = readdir($dh)) !== false) {
				if($read != '.' && $read != '..' && is_dir($base.$read)){
					$dirs[] = $read;
				}
			}
		closedir($dh);
		}
		foreach($dirs as $dir){
			if(is_file($base.$dir.'/menu.php')){
				include $base.$dir.'/menu.php';
				foreach($menu as $item){
						$main_menu[$item['seccion']][$item['permiso'][0]] = $item['permiso'];		
						$main_menu_sort[$item['seccion']] = $item['posicion'];
						
					
				}
			}
		}
	}
	array_multisort($main_menu_sort, $main_menu);
	return $main_menu;
}
function acceso($clave){
	if(is_numeric($clave)){
		if($clave < $_SESSION["nivel"]){
			header('Location: index.php?r=1');
			exit;
		}
	}
	else if(!permiso($clave)){
		header('Location: index.php?r=1');
		exit;
	}else{
		return permiso($clave);	
	}
}

# Restringe el acceso según el permiso o el nivel del usuario actual
function permiso($clave){
	global $_acceso;
	if( $_SESSION["nivel"] <= 2){
		return true;
	}else{
		$si=0;
		$permisos=array();
		
		for($i=0; $i<count($_SESSION["permisos"]); $i++){
			$a = $_SESSION["permisos"][$i];	
			$f = explode(",",trim($a,","));		
				if($f[0]==$clave){
					$si++;
					$permisos=$f;
				}	
		}
		
		if($si>0){
			$_acceso=$permisos;
			return true;
		}else{
			return false;
		}
	}
}


function readMenu(){
	$main_menu = array();
	$main_menu_sort = array();
	$dirs = array();
	$permiso2=array();
	$base = "./modules/";

	if(is_dir($base)){
		if($dh = opendir($base)){
			while(($read = readdir($dh)) !== false) {
				if($read != '.' && $read != '..' && is_dir($base.$read)){
					$dirs[] = $read;
				}
			}
		closedir($dh);
		}
		foreach($dirs as $dir){
			if(is_file($base.$dir.'/menu.php')){
				include $base.$dir.'/menu.php';
				foreach($menu as $item){
					if(permiso($item['permiso'][0])){
						$main_menu[$item['seccion'].'|'.$item['imagen_cabecera'].'|'.$item['orientacion']][$item['titulo']] = $dir.$item['link'];		
						$main_menu_sort[$item['seccion'].'|'.$item['imagen_cabecera'].'|'.$item['orientacion']] = $item['posicion'];
					}
				}
			}
		}
	}
	
	array_multisort($main_menu_sort, $main_menu);
	return $main_menu;	
	
}

function mostrar($permiso){
	global $_acceso;
	if( $_SESSION['nivel']<= 2){
		return true;
	}else{
		return (in_array($permiso,$_acceso));
	}
}
//cree para exportar //28/06/11----
//limpiar los campos de excel
function campoParaExcel($str){
	$ret = htmlspecialchars($str);
	if (substr($ret,0,1)== "=") 
		$ret = "&#61;".substr($ret,1);
	return $ret;

}

function mostrarDatosParaExportar($query, $tipo){
	//primer query 
$q = $query;
	//segundo query para no tener problemas
$q2 = $query;
$rs= mysql_fetch_object($q);
	//obtenemos el numero de columnas
$columnas=mysql_num_fields($q);
	//creamos la cabecera --------------
	//si es excel creamos un parametros xls :str
	if($tipo=="excel"){
		$n=0;
		foreach($rs as $key => $value){
			if($n==0)echo '<tr>';
				echo '<td style="width: 100" x:str>'.campoParaExcel(strtoupper($key)).'</td>';
		$n++;
			if($columnas==$n)echo '</tr>';	
		}
	}
	else{
		$n=0;
		foreach($rs as $key => $value){
			if($n==0)echo '<tr>';
				echo '<td>'.strtoupper($key).'</td>';
		$n++;
			if($columnas==$n)echo '</tr>';	
		}
	}
	//-----------------------------------
	//datos de la tabla
	if($tipo=="excel"){
		//si es excel
		$a = array();
		//creamos el array
		while($r=mysql_fetch_row($q2)){
			$a[]=$r;
		}
		//recorremos el array e imprimimos
		foreach($a as $keys=>$val){
			$n=0;
			foreach($val as $_ind){
				if($n==0)echo '<tr>';
				echo '<td x:str>'.campoParaExcel($_ind).'</td>';
				$n++;
				if($columnas==$n)echo '</tr>';
			}
		}
	}else{
		$a = array();
		//creamos el array
		while($r=mysql_fetch_row($q2)){
			$a[]=$r;
		}
		//recorremos el array e imprimimos
		foreach($a as $keys=>$val){
			$n=0;
			foreach($val as $_ind){
				if($n==0)echo '<tr>';
				echo '<td>'.$_ind.'</td>';
				$n++;
				if($columnas==$n)echo '</tr>';
			}
		}
	}
}

function ExportToExcel($query,$charset='UTF-8'){
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=llamadas_clientes.xls");

	echo "<html>";
	echo "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns=\"http://www.w3.org/TR/REC-html40\">";
	
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\">";
	echo "<body>";
	echo "<table border=1>";

	mostrarDatosParaExportar($query,'excel');

	echo "</table>";
	echo "</body>";
	echo "</html>";
}

function ExportToWord($query,$charset='UTF-8'){
	header("Content-Type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=llamadas_clientes.doc");

	echo "<html>";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=".$charset."\">";
	echo "<body>";
	echo "<table border=1>";

	mostrarDatosParaExportar($query,'word');

	echo "</table>";
	echo "</body>";
	echo "</html>";
}
function array_in_array($needles, $haystack) {
    foreach ($needles as $needle) {
        if ( in_array($needle, $haystack) ) {
            return true;
        }
    }
    return false;
} 
function traer_array_encontrado_in_array($needles, $haystack) {
    foreach ($needles as $needle) {
        if ( in_array($needle, $haystack) ) {
            $key = array_search($needle,$haystack);
			return $haystack[$key];
        }
    }
    return false;
} 
function quitacero($vari){ 
	$largo=strlen($vari); 
	$algo=substr($vari,0,1); 
	if($algo=='0'){ 
		$vari2=substr($vari,1,$largo-1); 
	}else{
		$vari2=$vari;
	} 
	return $vari2; 
} 

// FUNCIONES DE CONVERSION DE NUMEROS A LETRAS.

function Centenas($VCentena) {
	$Numeros[0] = "cero";
	$Numeros[1] = "uno";
	$Numeros[2] = "dos";
	$Numeros[3] = "tres";
	$Numeros[4] = "cuatro";
	$Numeros[5] = "cinco";
	$Numeros[6] = "seis";
	$Numeros[7] = "siete";
	$Numeros[8] = "ocho";
	$Numeros[9] = "nueve";
	$Numeros[10] = "diez";
	$Numeros[11] = "once";
	$Numeros[12] = "doce";
	$Numeros[13] = "trece";
	$Numeros[14] = "catorce";
	$Numeros[15] = "quince";
	$Numeros[20] = "veinte";
	$Numeros[30] = "treinta";
	$Numeros[40] = "cuarenta";
	$Numeros[50] = "cincuenta";
	$Numeros[60] = "sesenta";
	$Numeros[70] = "setenta";
	$Numeros[80] = "ochenta";
	$Numeros[90] = "noventa";
	$Numeros[100] = "ciento";
	$Numeros[101] = "quinientos";
	$Numeros[102] = "setecientos";
	$Numeros[103] = "novecientos";
	if ($VCentena == 1) { return $Numeros[100]; }
	else if ($VCentena == 5) { return $Numeros[101];}
	else if ($VCentena == 7 ) {return ( $Numeros[102]); }
	else if ($VCentena == 9) {return ($Numeros[103]);}
	else {return $Numeros[$VCentena];}

}



function Unidades($VUnidad) {
	$Numeros[0] = "cero";
	$Numeros[1] = "un";
	$Numeros[2] = "dos";
	$Numeros[3] = "tres";
	$Numeros[4] = "cuatro";
	$Numeros[5] = "cinco";
	$Numeros[6] = "seis";
	$Numeros[7] = "siete";
	$Numeros[8] = "ocho";
	$Numeros[9] = "nueve";
	$Numeros[10] = "diez";
	$Numeros[11] = "once";
	$Numeros[12] = "doce";
	$Numeros[13] = "trece";
	$Numeros[14] = "catorce";
	$Numeros[15] = "quince";
	$Numeros[20] = "veinte";
	$Numeros[30] = "treinta";
	$Numeros[40] = "cuarenta";
	$Numeros[50] = "cincuenta";
	$Numeros[60] = "sesenta";
	$Numeros[70] = "setenta";
	$Numeros[80] = "ochenta";
	$Numeros[90] = "noventa";
	$Numeros[100] = "ciento";
	$Numeros[101] = "quinientos";
	$Numeros[102] = "setecientos";
	$Numeros[103] = "novecientos";
	
	$tempo=$Numeros[$VUnidad];
	return $tempo;
}

function Decenas($VDecena) {
	$Numeros[0] = "cero";
	$Numeros[1] = "uno";
	$Numeros[2] = "dos";
	$Numeros[3] = "tres";
	$Numeros[4] = "cuatro";
	$Numeros[5] = "cinco";
	$Numeros[6] = "seis";
	$Numeros[7] = "siete";
	$Numeros[8] = "ocho";
	$Numeros[9] = "nueve";
	$Numeros[10] = "diez";
	$Numeros[11] = "once";
	$Numeros[12] = "doce";
	$Numeros[13] = "trece";
	$Numeros[14] = "catorce";
	$Numeros[15] = "quince";
	$Numeros[20] = "veinte";
	$Numeros[30] = "treinta";
	$Numeros[40] = "cuarenta";
	$Numeros[50] = "cincuenta";
	$Numeros[60] = "sesenta";
	$Numeros[70] = "setenta";
	$Numeros[80] = "ochenta";
	$Numeros[90] = "noventa";
	$Numeros[100] = "ciento";
	$Numeros[101] = "quinientos";
	$Numeros[102] = "setecientos";
	$Numeros[103] = "novecientos";
	$tempo = ($Numeros[$VDecena]);
	return $tempo;
}

function NumerosALetras($Numero){	
	$Decimales = 0;
	//$Numero = intval($Numero);
	$letras = "";
		while ($Numero != 0){
			// '*---> Validación si se pasa de 100 millones
			if ($Numero >= 1000000000) {
			$letras = "Error en Conversión a Letras";
			$Numero = 0;
			$Decimales = 0;
			}
			
			// '*---> Centenas de Millón
			if (($Numero < 1000000000) && ($Numero >= 100000000)){
			if ((intval($Numero / 100000000) == 1) && (($Numero - (intval($Numero / 100000000) * 100000000)) < 1000000)){
			$letras .= (string) "cien millones ";
			}
			else {
			$letras = $letras & Centenas(intval($Numero / 100000000));
			if ((intval($Numero / 100000000) <> 1) && (intval($Numero / 100000000) <> 5) && (intval($Numero / 100000000) <> 7) && (intval($Numero / 100000000) <> 9)) {
			$letras .= (string) "cientos ";
			}
			else {
			$letras .= (string) " ";
			}
			}
			$Numero = $Numero - (intval($Numero / 100000000) * 100000000);
		}
		
		// '*---> Decenas de Millón
		if (($Numero < 100000000) && ($Numero >= 10000000)) {
		if (intval($Numero / 1000000) < 16) {
		$tempo = Decenas(intval($Numero / 1000000));
		$letras .= (string) $tempo;
		$letras .= (string) " millones ";
		$Numero = $Numero - (intval($Numero / 1000000) * 1000000);
		}
		else {
		$letras = $letras & Decenas(intval($Numero / 10000000) * 10);
		$Numero = $Numero - (intval($Numero / 10000000) * 10000000);
		if ($Numero > 1000000) {
		$letras .= $letras & " y ";
		}
		}
		}
		
		// '*---> Unidades de Millón
		if (($Numero < 10000000) && ($Numero >= 1000000)) {
		$tempo=(intval($Numero / 1000000));
		if ($tempo == 1) {
		$letras .= (string) " un millón ";
		}
		else {
		$tempo= Unidades(intval($Numero / 1000000));
		$letras .= (string) $tempo;
		$letras .= (string) " millones ";
		}
		$Numero = $Numero - (intval($Numero / 1000000) * 1000000);
		}
		
		// '*---> Centenas de Millar
		if (($Numero < 1000000) && ($Numero >= 100000)) {
		$tempo=(intval($Numero / 100000));
		$tempo2=($Numero - ($tempo * 100000));
		if (($tempo == 1) && ($tempo2 < 1000)) {
		$letras .= (string) "cien mil ";
		}
		else {
		$tempo=Centenas(intval($Numero / 100000));
		$letras .= (string) $tempo;
		$tempo=(intval($Numero / 100000));
		if (($tempo <> 1) && ($tempo <> 5) && ($tempo <> 7) && ($tempo <> 9)) {
		$letras .= (string) "cientos ";
		}
		else {
		$letras .= (string) " ";
		}
		}
		$Numero = $Numero - (intval($Numero / 100000) * 100000);
		}
		
		// '*---> Decenas de Millar
		if (($Numero < 100000) && ($Numero >= 10000)) {
		$tempo= (intval($Numero / 1000));
		if ($tempo < 16) {
		$tempo = Decenas(intval($Numero / 1000));
		$letras .= (string) $tempo;
		$letras .= (string) " mil ";
		$Numero = $Numero - (intval($Numero / 1000) * 1000);
		}
		else {
		$tempo = Decenas(intval($Numero / 10000) * 10);
		$letras .= (string) $tempo;
		$Numero = $Numero - (intval(($Numero / 10000)) * 10000);
		if ($Numero > 1000) {
		$letras .= (string) " y ";
		}
		else {
		$letras .= (string) " mil ";
		
		}
		}
		}
		
		
		// '*---> Unidades de Millar
		if (($Numero < 10000) && ($Numero >= 1000)) {
		$tempo=(intval($Numero / 1000));
		if ($tempo == 1) {
		$letras .= (string) "un";
		}
		else {
		$tempo = Unidades(intval($Numero / 1000));
		$letras .= (string) $tempo;
		}
		$letras .= (string) " mil ";
		$Numero = $Numero - (intval($Numero / 1000) * 1000);
		}
		
		// '*---> Centenas
		if (($Numero < 1000) && ($Numero > 99)) {
		if ((intval($Numero / 100) == 1) && (($Numero - (intval($Numero / 100) * 100)) < 1)) {
		$letras = $letras & "cien ";
		}
		else {
		$temp=(intval($Numero / 100));
		$l2=Centenas($temp);
		$letras .= (string) $l2;
		if ((intval($Numero / 100) <> 1) && (intval($Numero / 100) <> 5) && (intval($Numero / 100) <> 7) && (intval($Numero / 100) <> 9)) {
		$letras .= "cientos ";
		}
		else {
		$letras .= (string) " ";
		}
		}
		
		$Numero = $Numero - (intval($Numero / 100) * 100);
		
		}
		
		// '*---> Decenas
		if (($Numero < 100) && ($Numero > 9) ) {
		if ($Numero < 16 ) {
		$tempo = Decenas(intval($Numero));
		$letras .= $tempo;
		$Numero = $Numero - intval($Numero);
		}
		else {
		$tempo= Decenas(intval(($Numero / 10)) * 10);
		$letras .= (string) $tempo;
		$Numero = $Numero - (intval(($Numero / 10)) * 10);
		if ($Numero > 0.99) {
		$letras .=(string) " y ";
		
		}
		}
		}
		
		// '*---> Unidades
		if (($Numero < 10) && ($Numero > 0.99)) {
		$tempo=Unidades(intval($Numero));
		$letras .= (string) $tempo;
		
		$Numero = $Numero - intval($Numero);
		}
		
		
		// '*---> Decimales
		if ($Decimales > 0) {
		
		// $letras .=(string) " con ";
		// $Decimales= $Decimales*100;
		// echo ("*");
		// $Decimales = number_format($Decimales, 2);
		// echo ($Decimales);
		// $tempo = Decenas(intval($Decimales));
		// $letras .= (string) $tempo;
		// $letras .= (string) "centavos";
		}
		else {
		if (($letras <> "Error en Conversión a Letras") && (strlen(Trim($letras)) > 0)) {
		$letras .= (string) " ";
		
		}
		}
		return $letras;
	}
}
function getCotizacion(){
	$q = pg_query("select * from cotizaciones_monedas order by serie desc limit 1");
	$r = pg_fetch_object($q);
	return $r->serie;
}


#====== VALORES COMUNES ======#
//los que no necesitan login
$no_plantilla = array('index.php','paginas.php','acceso.php','404.php','listado.php','foto.php','lostpassword.php','captcha.php','login.php','contacto.php','noticias.php','noticias-detalle.php','buscar.php', 'adis.php','sitemap.php','buscadorgoogle.php');
# Formas de pago
$formas_de_pago = array(0=>'No definido', 1=>'Tarjeta de crédito', 2=>'Efectivo o cheque', 3=>'Giro o Transferencia');
# Meses del año
$meses = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');

$meses_2 = array(1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre');

# Valor booleano en español
$sino = array('No', 'Sí');
$nosi = array('SI', 'NO');
# Sexos
$sexos = array(1 => 'Masculino', 2 => 'Femenino');
# Estados civiles
$estados_civiles = array(1 => 'Soltero', 2 => 'Casado', 3 => 'Viudo', 4 => 'Divorciado');
# Categorías
$categorias = array(1 => 'Persona', 2 => 'Empresa', 3 => 'Fideicomiso');
$estados = array(
	0 => 'En borrador',
	1 => 'Activo',    //Pendiente de llenarse el cupo mínimo
	2 => 'Abierto',   //Se ha llenado el cupo mínimo, se debitaron y está listo para sortearse
	3 => 'Realizado', //Se ha sorteado
	4 => 'Cerrado'    //Se ha vencido, no se llegó al cupo mínimo
);
$estados_ventas = array(
	0 => 'Pendiente',
	1 => 'Vendido',    //Pendiente de llenarse el cupo mínimo
	2 => 'Cancelado',   //Se ha llenado el cupo mínimo, se debitaron y está listo para sortearse
	3 => 'Devuelto', //Se ha sorteado
);


function usuario_activar($id,$nivel){
	if($id=='-1'){//yo el mas purete de la tierra :D 
		return true;
	}elseif($id=='1'){//SUper Admin
		return true;	
	}elseif($id=='2' ){//SUper Admin
		return true;	
	}elseif($id=='3'){//SUper Admin
		return false;	
	}elseif($id==4 && $nivel=='mozo'){
		return true;	
	}elseif($id=='5' && $nivel=='caja'){
		return true;
	}elseif($id=='6' && $nivel=='cocina'){
		return true;
	}elseif($id=='7' && $nivel=='vendedor'){
		return true;
	}else{
		return false;// si no es ninguno de estos no le permitimos	
	}
}
//---------------REM
 function usuario_nombre($id){
								 if($id=='-1'){
								echo 'master'; 
							 }else{
                             $qa = mysql_query('select * from administradores where id='.$id);
							 $foh = mysql_fetch_object($qa);
							 echo $foh->usuario;
							 }
							 }
							 function traer_usuarios(){
	//usuarios
	$q1=mysql_query('select id, usuario_asignado from archivos');
$a=array();
while($f1=mysql_fetch_object($q1)){
	$a[$f1->id]=$f1->usuario_asignado;
}

 $usuario_archivo=array();
 foreach ( $a as $key => $value ) { 
    $exusuario=explode('|',$value);
	if(in_array($_SESSION['id'],$exusuario)||$_SESSION['id']=='-1'){//si es master muestra todo
		if($_SESSION['id']=='-1'){
			for($i=0;$i<count($exusuario);$i++){
			$usuario_archivo[$key][]=$exusuario[$i];
			}
		}else{
			$usuario_archivo[$key][]=$_SESSION['id'];
		}
	}
   }
   return $usuario_archivo; 
   // $fin_usuario=
}
function grupo(){
	//usuarios
	$q1=mysql_query('select id, grupo_asignado from archivos');
$a=array();
while($f1=mysql_fetch_object($q1)){
	$a[$f1->id]=$f1->grupo_asignado;
}

 $usuario_archivo=array();
 foreach ( $a as $key => $value ) { 
    $exusuario=explode('|',$value);
	if(in_array(traer_grupos(),$exusuario)){//si es master muestra todo
		
			$usuario_archivo[$key][]=traer_grupos();
		
	}
   }
   return $usuario_archivo; 
   // $fin_usuario=
}

function fatal_error ( $sErrorMessage = '' ){
		header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
		die( $sErrorMessage );
	}

function traer_grupos(){
	$st='SELECT g.nombre,g.id_grupo
FROM grupos AS g, grupo_detalle AS gd
WHERE gd.id_grupo = g.id_grupo
AND gd.id_usuario ='.$_SESSION['id'];
	$query= mysql_query($st);
$fo= mysql_fetch_object($query);
 if($fo->id_grupo>0){
	 return $fo->id_grupo;
 }else{
	 return 0;
 }
	}
function strtolower_utf8($inputString) {
    $outputString    = utf8_decode($inputString);
    $outputString    = strtolower($outputString);
    $outputString    = utf8_encode($outputString);
    return $outputString;
}
function formato($datos){
	if($datos!="Null"){
		if(preg_match('/(<p>|<br>|<br\s>)/',$datos)){
			return link_formato(preg_replace_callback("/\[vinc(.*?)\](.*?)\[.*?\]/",'convertir_a_link',$datos));	
		}else{
			return link_formato(nl2br(preg_replace_callback("/\[vinc(.*?)\](.*?)\[.*?\]/",'convertir_a_link',$datos)));	
		}
	}		
}
function raya($cantidad){
	$raya='';
    for ($i = 0;$i < $cantidad; $i++) {
        $raya .= "=";
    }
      return $raya;
}

function link_formato($d){
	
	return preg_replace_callback('/\[((.*?))\\/]/','convertir_a_link_ajustes',$d);
	
}
		 
function imprimir_ticket($id,$comprobante='Original'){
	
	$hoy = date("j-m-Y");

	//select empresa 
	$sql_empresa = mysql_query('select * from empresas where id="'.$_SESSION['empresa'].'"');
	$f = mysql_fetch_object($sql_empresa);
	
	//TICKET
	$sql_venta = mysql_query('select * from ventas where id="'.$id.'" and estado=1');
	$venta = mysql_fetch_object($sql_venta);
	
	//usuario
	$sql_usuario = mysql_query('select * from administradores where id="'.$venta->usuario.'"');
	$u = mysql_fetch_object($sql_usuario);
	
	//detalles
	$sql_detalle = mysql_query('select p.id, sum(d.cantidad) as cantidad, p.codigo, p.nombre, p.precio_venta from ventas_detalle d, ventas v, productos p where v.id="'.$id.'" and v.id=d.id_venta and p.codigo=d.producto_cod group by p.id');
	$datos = '';
	
	while($row = mysql_fetch_object($sql_detalle)){
		$datos .= $row->cantidad.'  '.fragmento($row->nombre,60).'  '.(float)($row->precio_venta*$row->cantidad).'
';
	}
		

$str= ".:: ".$f->empresa." ::.
Paseo Carmelitas 
EXPEDIDO El ".$hoy."
COMPROBANTE ".$comprobante."
".raya(29)."
RUC: 80055166-4
TEL: (021) 665-099
".raya(29)."
Ticket # ".$venta->ticket."
LE ATENDIÓ: ".$u->usuario." 
".raya(29)."
".$datos."
".raya(29)."
TOTAL: ".$venta->monto."
		 
		
".raya(29)."
---Gracias por su vistita ---
		
		
		
";
if($_master["phpprinter"]=='true'){
	$con = @printer_open($_SESSION['impresora_ticket']);	
	@printer_write($con, $str);
	@printer_close($con);
}else{
	return $str;	
}
}

function imprimir_ticket_pedido($id,$orden='caja'){
	
	$hoy = date("j-m-Y");
	
	//select empresa 
	$sql_empresa = mysql_query('select * from empresas where id="'.$_SESSION['empresa'].'"');
	$f = mysql_fetch_object($sql_empresa);
	
	
	
	//usuario
	$sql_usuario = mysql_query('select * from administradores where id="'.$_SESSION['id'].'"');
	$u = mysql_fetch_object($sql_usuario);
	
	if($orden=='mozo'){// si hace un mozo
		$sql_detalle = mysql_query('select p.id, sum(d.cantidad) as cantidad, p.codigo, p.nombre, p.precio_venta, p.seccion from pedidos_detalle d, pedidos_mesa v, productos p where v.id="'.$id.'" and v.id=d.id_venta and d.pedido_realizado="" and p.codigo=d.producto_cod group by p.id');
	//TICKET
	$sql_venta = mysql_query('select * from pedidos_mesa where id="'.$id.'" and estado=0');
	$venta = mysql_fetch_object($sql_venta);
	
	}else{// si hace una cajera
		//detalles
		$sql_detalle = mysql_query('select p.id, sum(d.cantidad) as cantidad, p.codigo, p.nombre, p.precio_venta, p.seccion from ventas_detalle d, ventas v, productos p where v.id="'.$id.'" and v.id=d.id_venta and p.codigo=d.producto_cod group by p.id');
	//TICKET
	$sql_venta = mysql_query('select * from ventas where id="'.$id.'" and estado=1');
	$venta = mysql_fetch_object($sql_venta);
	
	}
	$datos_cocina = '';
	$datos_cantina='';
	while($row = mysql_fetch_object($sql_detalle)){
		if($row->seccion=='cocina'){
			$datos_cocina .= $row->cantidad.'  '.fragmento($row->nombre,60).'  '.(float)($row->precio_venta*$row->cantidad).'
';
		}else{
			$datos_cantina .= $row->cantidad.'  '.fragmento($row->nombre,60).'  '.(float)($row->precio_venta*$row->cantidad).'
';
		}
	}
	
	
if($datos_cantina!=''){	
$conexion = @printer_open($_SESSION['impresora_ticket']);//cantina

$str= ".:: ".$f->empresa." ::.
NOTA DE PEDIDO--( CANTINA )
(Comprobante Interno)
		 
EXP. El ".$hoy."
".raya(29)."
		
Ticket Pedido # ".$venta->ticket."
PERSONAL: ".$u->usuario." 
".raya(29)."
".$datos_cantina."
".raya(29)."

--- FIN DE LA NOTA---
		
		
		
";
		
@printer_write($conexion, $str);
@printer_close($conexion);
return true;
}
//fin cantina


//cocina
if($datos_cocina!=''){
$conexion = @printer_open($_SESSION['impresora_ticket_cocina']);//cocina

$str= ".:: ".$f->empresa." ::.
NOTA DE PEDIDO--( COCINA )
(Comprobante Interno)
		 
EXPEDIDO El ".$venta->fecha_hora_cerrado."
".raya(29)."
		
Ticket Pedido # ".$venta->ticket."
PERSONAL: ".$u->usuario." 
".raya(29)."
".$datos_cocina."
".raya(29)."

--- FIN DE LA NOTA---
		
		
		
";
		
@printer_write($conexion, $str);
@printer_close($conexion);
}
//fin cocina


}




function imprimir_factura($id,$ruc,$nombre){
	$conexion = @printer_open($_SESSION['impresora_factura']);//factura
	//obtener numero
	$numerosql = mysql_query('select * from nro_factura where mostrar=0 order by descripcion asc  limit 0,1');
	$numero = mysql_fetch_object($numerosql);
	
	//TICKET
	$sql_venta = mysql_query('select * from ventas where id="'.$id.'" and estado=1');
	$venta = mysql_fetch_object($sql_venta);
	
	
	//detalles
	$sql_detalle = mysql_query('select p.id, sum(d.cantidad) as cantidad, p.codigo, p.nombre, p.precio_venta from ventas_detalle d, ventas v, productos p where v.id="'.$id.'" and v.id=d.id_venta and p.codigo=d.producto_cod group by p.id');
	$datos = '';		

$str= "

                                              ".$numero->descripcion."                                                               ".$numero->descripcion."
	".date('d-m-Y')."									  x				             ".date('d-m-Y')."										    x
	".$ruc."                                                                ".$ruc."
	".$nombre."                                                               ".$nombre."
	
	
	
	      Total consumicion                             ".$venta->monto."                             Total consumicion                      ".$venta->monto."
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		                                                ".$venta->monto."                                                                      ".$venta->monto."
		--                                                          --		
		
														".round($venta->monto/11)."                                                                         ".round($venta->monto/11)."
														
		
		
		
";
@printer_write($conexion, $str);
@printer_close($conexion);
return true;
}



function imprimir_ticket_temporal($id){
	
	$hoy = date("j-m-Y");
$con = @printer_open($_SESSION['impresora_ticket']);	
	//select empresa 
	$sql_empresa = mysql_query('select * from empresas where id="'.$_SESSION['empresa'].'"');
	$f = mysql_fetch_object($sql_empresa);
	
	
	//usuario
	$sql_usuario = mysql_query('select * from administradores where id="'.$_SESSION['id'].'"');
	$u = mysql_fetch_object($sql_usuario);
	
	//detalles
	$sql_detalle = mysql_query('select p.id, sum(d.cantidad) as cantidad, p.codigo, p.nombre, d.monto as precio_venta from pedidos_detalle d, pedidos_mesa v, productos p where v.id="'.$id.'" and v.id=d.id_venta and p.codigo=d.producto_cod group by p.id');
	$datos = '';
	$monto=0;
	while($row = mysql_fetch_object($sql_detalle)){
		$datos .= $row->cantidad.'  '.fragmento($row->nombre,60).'  '.(float)($row->precio_venta*$row->cantidad).'
';
$monto += ($row->cantidad*$row->precio_venta); 
	}
		

$str= ".:: ".$f->empresa." ::.
Paseo Carmelitas 
EXPEDIDO El ".$hoy."
--ESTADO DE CUENTA-
".raya(29)."
RUC: 80055166-4
TEL: (021) 665-099
".raya(29)."

LE ATENDIÓ: ".$u->usuario." 
".raya(29)."
".$datos."
".raya(29)."
TOTAL: ".$monto."
		 
		
".raya(29)."
---Gracias por su vistita ---
		
		
		
";
@printer_write($con, $str);
@printer_close($con);
}
?>