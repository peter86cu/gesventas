<?php
###################################
#                                 #
#          UTF-8 CLEAN            #
#                                 #
#           creado por            #
#         Acner Pinazo          #
#       acner999{}hotmail.com        #
#        V2.0 - enero 2011        #
#                                 #
###################################

# Devuelve el texto con la codificación en UTF-8 limpia
function utf8_clean($texto){
	if(is_numeric($texto)) return $texto;
	$texto = utf8_c($texto);
	return cp1252_to_utf8($texto);
}

# Devuelve el texto con la codificación en ISO-8859-1 limpia
function iso_clean($texto){
	if(is_numeric($texto)) return $texto;
	$texto = utf8_to_cp1252($texto);
	return iso_c($texto);
}

# Limpia la codificación en UTF-8 (interno)
function utf8_c($t){
	$len = strlen($t);
	$r = '';
	for($i = 0; $i < $len; ++$i):
		if(ord($t[$i]) < 128): $r .= $t[$i];
		elseif(ord($t[$i]) < 192): $r .= utf8_encode($t[$i]);
		elseif(ord($t[$i]) < 224):
			if((ord($t[$i + 1]) & 192) == 128):
				$r .= $t[$i].$t[$i + 1];
				$i += 1;
			else:
				$r .= utf8_encode($t[$i]);
			endif;
		elseif(ord($t[$i]) < 240):
			if((ord($t[$i + 1]) & 192) == 128 and (ord($t[$i + 2]) & 192) == 128):
				$r .= $t[$i].$t[$i + 1].$t[$i + 2];
				$i += 2;
			else:
				$r .= utf8_encode($t[$i]);
			endif;
		elseif(ord($t[$i]) < 248):
			if((ord($t[$i + 1]) & 192) == 128 and (ord($t[$i + 2]) & 192) == 128 and (ord($t[$i + 3]) & 192) == 128):
				$r .= $t[$i].$t[$i + 1].$t[$i + 2].$t[$i + 3];
				$i += 3;
			else:
				$r .= utf8_encode($t[$i]);
			endif;
		else:
			$r .= utf8_encode($t[$i]);
		endif;
	endfor;
	return $r;
}

# Limpia la codificación en ISO-8859-1 (interno)
function iso_c($t){
	$len = strlen($t);
	$r = '';
	for($i = 0; $i < $len; ++$i):
		if(ord($t[$i]) < 128): $r .= $t[$i];
		elseif(ord($t[$i]) < 192): $r .= $t[$i];
		elseif(ord($t[$i]) < 224):
			if((ord($t[$i + 1]) & 192) == 128):
				$r .= utf8_decode($t[$i].$t[$i + 1]);
				$i += 1;
			else:
				$r .= $t[$i];
			endif;
		elseif(ord($t[$i]) < 240):
			if((ord($t[$i + 1]) & 192) == 128 and (ord($t[$i + 2]) & 192) == 128):
				$r .= utf8_decode($t[$i].$t[$i + 1].$t[$i + 2]);
				$i += 2;
			else:
				$r .= $t[$i];
			endif;
		elseif(ord($t[$i]) < 248):
			if((ord($t[$i + 1]) & 192) == 128 and (ord($t[$i + 2]) & 192) == 128 and (ord($t[$i + 3]) & 192) == 128):
				$r .= utf8_decode($t[$i].$t[$i + 1].$t[$i + 2].$t[$i + 3]);
				$i += 3;
			else:
				$r .= $t[$i];
			endif;
		else:
			$r .= $t[$i];
		endif;
	endfor;
	return $r;
}

# Reemplaza los caracteres en UTF-8 de cp1252 a UTF-8 correcto
function cp1252_to_utf8($str){
	$cp1252_map = array(
		"\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
		"\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
		"\xc2\x83" => "\xc6\x92",     /* LATIN SMALL LETTER F WITH HOOK */
		"\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
		"\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
		"\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
		"\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
		"\xc2\x88" => "\xcb\x86",     /* MODIFIER LETTER CIRCUMFLEX ACCENT */
		"\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
		"\xc2\x8a" => "\xc5\xa0",     /* LATIN CAPITAL LETTER S WITH CARON */
		"\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
		"\xc2\x8c" => "\xc5\x92",     /* LATIN CAPITAL LIGATURE OE */
		"\xc2\x8e" => "\xc5\xbd",     /* LATIN CAPITAL LETTER Z WITH CARON */
		"\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
		"\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
		"\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
		"\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
		"\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
		"\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
		"\xc2\x97" => "\xe2\x80\x94", /* EM DASH */
		"\xc2\x98" => "\xcb\x9c",     /* SMALL TILDE */
		"\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
		"\xc2\x9a" => "\xc5\xa1",     /* LATIN SMALL LETTER S WITH CARON */
		"\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
		"\xc2\x9c" => "\xc5\x93",     /* LATIN SMALL LIGATURE OE */
		"\xc2\x9e" => "\xc5\xbe",     /* LATIN SMALL LETTER Z WITH CARON */
		"\xc2\x9f" => "\xc5\xb8"      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
	);
	return strtr($str, $cp1252_map);
}

# Reemplaza los caracteres en UTF-8 de UTF-8 correcto a cp1252
function utf8_to_cp1252($str){
	$cp1252_map = array(
		"\xe2\x82\xac" => "\xc2\x80", /* EURO SIGN */
		"\xe2\x80\x9a" => "\xc2\x82", /* SINGLE LOW-9 QUOTATION MARK */
		"\xc6\x92"     => "\xc2\x83", /* LATIN SMALL LETTER F WITH HOOK */
		"\xe2\x80\x9e" => "\xc2\x84", /* DOUBLE LOW-9 QUOTATION MARK */
		"\xe2\x80\xa6" => "\xc2\x85", /* HORIZONTAL ELLIPSIS */
		"\xe2\x80\xa0" => "\xc2\x86", /* DAGGER */
		"\xe2\x80\xa1" => "\xc2\x87", /* DOUBLE DAGGER */
		"\xcb\x86"     => "\xc2\x88", /* MODIFIER LETTER CIRCUMFLEX ACCENT */
		"\xe2\x80\xb0" => "\xc2\x89", /* PER MILLE SIGN */
		"\xc5\xa0"     => "\xc2\x8a", /* LATIN CAPITAL LETTER S WITH CARON */
		"\xe2\x80\xb9" => "\xc2\x8b", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
		"\xc5\x92"     => "\xc2\x8c", /* LATIN CAPITAL LIGATURE OE */
		"\xc5\xbd"     => "\xc2\x8e", /* LATIN CAPITAL LETTER Z WITH CARON */
		"\xe2\x80\x98" => "\xc2\x91", /* LEFT SINGLE QUOTATION MARK */
		"\xe2\x80\x99" => "\xc2\x92", /* RIGHT SINGLE QUOTATION MARK */
		"\xe2\x80\x9c" => "\xc2\x93", /* LEFT DOUBLE QUOTATION MARK */
		"\xe2\x80\x9d" => "\xc2\x94", /* RIGHT DOUBLE QUOTATION MARK */
		"\xe2\x80\xa2" => "\xc2\x95", /* BULLET */
		"\xe2\x80\x93" => "\xc2\x96", /* EN DASH */
		"\xe2\x80\x94" => "\xc2\x97", /* EM DASH */
		"\xcb\x9c"     => "\xc2\x98", /* SMALL TILDE */
		"\xe2\x84\xa2" => "\xc2\x99", /* TRADE MARK SIGN */
		"\xc5\xa1"     => "\xc2\x9a", /* LATIN SMALL LETTER S WITH CARON */
		"\xe2\x80\xba" => "\xc2\x9b", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
		"\xc5\x93"     => "\xc2\x9c", /* LATIN SMALL LIGATURE OE */
		"\xc5\xbe"     => "\xc2\x9e", /* LATIN SMALL LETTER Z WITH CARON */
		"\xc5\xb8"     => "\xc2\x9f"  /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
	);
	return strtr($str, $cp1252_map);
}
?>