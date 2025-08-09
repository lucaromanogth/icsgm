<?php
include_once("setdb.php");

date_default_timezone_set('UTC');

$caratteri_speciali = array('à','â','ã','è','ê','ë','ì','í','î','ï','ù','û','ò','ô','õ','é','Ã','À','È','É','Ê','Ì','Í','Î','Ï','Ò','Ô','Ù','Û','Õ','ç','¡','¿','ñ','"','°','\'','\'','-','"','"','\'',' ','- ');
$caratteri_sostitutivi = array('&agrave;','&acirc;','&atilde;','&egrave;','&ecirc;','&euml;','&igrave;','&iacute;','&icirc;','&iuml;','&ugrave;','&ucirc;','&ograve;','&ocirc;','&otilde;','&eacute;','&Atilde;','&Agrave;','&Egrave;','&Eacute;','&Ecirc;','&Igrave;','&Iacute;','&Icirc;','&Iuml;','&Ograve;','&Ocirc;','&Ugrave;','&Ucirc;','&Otilde;','&ccedil;','&iexcl;','&iquest;','&ntilde;','&quot;','&deg;','&rsquo;','&acute;','&ndash;','&ldquo;','&rdquo;','’','&nbsp;','&bull;');

function getFooter()
{
  $connect = connectDB();
	$query = " SELECT * FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$footer = '&copy;Copyright '.$row['copyright'].' - '.$row['nome_ics'].' - Comune di '.$row['comune'].' - '.$row['citta'];
	}
	return $footer;
}

function getAnnoScolastico()
{
  $connect = connectDB();
	$query = " SELECT anno_scolastico FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$anno_scolastico = $row['anno_scolastico'];
	}
	return $anno_scolastico;
}

function getDominio()
{
  $connect = connectDB();
	$query = " SELECT dominio FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$dominio = $row['dominio'];
	}
	return $dominio;
}

function getNomeICS()
{
  $connect = connectDB();
	$query = " SELECT nome_ics FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$nome_ics = $row['nome_ics'];
	}
	return $nome_ics;
}

function getIndirizzo() {
    $connect = connectDB();
	$query = " SELECT indirizzo FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$indirizzo = $row['indirizzo'];
	}
	return $indirizzo;
}

function getProvincia()
{
  $connect = connectDB();
	$query = " SELECT provincia FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$provincia = $row['provincia'];
	}
	return $provincia;
}

function getCAP()
{
  $connect = connectDB();
	$query = " SELECT cap FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$cap = $row['cap'];
	}
	return $cap;
}

function getEmail()
{
  $connect = connectDB();
	$query = " SELECT email FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$email = $row['email'];
	}
	return $email;
}

function getCodMIUR()
{
  $connect = connectDB();
	$query = " SELECT cod_miur FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$cod_miur = $row['cod_miur'];
	}
	return $cod_miur;
}

function getTel()
{
  $connect = connectDB();
	$query = " SELECT tel FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$tel = $row['tel'];
	}
	return $tel;
}

function getFax()
{
  $connect = connectDB();
	$query = " SELECT fax FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$fax = $row['fax'];
	}
	return $fax;
}

function getComune()
{
  $connect = connectDB();
	$query = " SELECT comune FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$comune = $row['comune'];
	}
	return $comune;
}

function getComuneScuola($id_scu)
{
  $connect = connectDB();
	$query = " SELECT comune FROM scuola WHERE id = ?";
	$stmt = mysqli_prepare($connect, $query);
	mysqli_stmt_bind_param($stmt, "i", $id_scu);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$comune = $row['comune'];
	}
	return $comune;
}

function getCitta()
{
  $connect = connectDB();
	$query = " SELECT citta FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$citta = $row['citta'];
	}
	return $citta;
}

function getWeb()
{
  $connect = connectDB();
	$query = " SELECT web FROM settings ";
	$result = mysqli_query($connect, $query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$web = $row['web'];
	}
	return $web;
}

function getDirigenteScolastico()
{
	$query = " SELECT dirigente_scolastico FROM settings ";
	$result = executeQuery($query);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$dirigente_scolastico = $row['dirigente_scolastico'];
	}
	return $dirigente_scolastico;
}

function isCoordinatore($id_doc)
{
	$num = 0;
	$connect = connectDB();
	$query = " SELECT count(*) occurrences FROM doc_cla_map WHERE coordinatore=1 AND id_doc=? AND anno_scolastico=(SELECT anno_scolastico FROM settings) ";
	$stmt = mysqli_prepare($connect, $query);
	mysqli_stmt_bind_param($stmt, "i", $id_doc);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$num = $row['occurrences'];
	}
	disconnectDB($connect);
	return $num>0;
}

function isAllowDsaIns($id_doc)
{
	$num = 0;
	$connect = connectDB();
	$query = " SELECT count(*) occurrences
	           FROM doc_cla_map, classe, scuola
			   WHERE classe.id = doc_cla_map.id_cla
			   AND classe.id_scu = scuola.id
			   AND classe.classe = 1
			   AND scuola.id_ordine_scuola = 2
			   AND id_doc=?
			   AND coordinatore=1
			   AND doc_cla_map.anno_scolastico=(SELECT anno_scolastico FROM settings) ";
	$stmt = mysqli_prepare($connect, $query);
	mysqli_stmt_bind_param($stmt, "i", $id_doc);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ( $row = mysqli_fetch_assoc($result) ) {
		$num = $row['occurrences'];
	}
	disconnectDB($connect);
	return $num>0;
}


function is_dir_empty($dir)
{
	if (!is_readable($dir)) return NULL;
	return (count(scandir($dir)) == 2);
}

function removeCarriageReturn($snip)
{
	$snip = str_replace("\t", '', $snip); // remove tabs
	$snip = str_replace("\n", '', $snip); // remove new lines
	$snip = str_replace("\r", '', $snip); // remove carriage returns
	$snip = str_replace('  ', ' ', $snip); // remove double spaces
	return $snip;
}

function nvl(&$var, $default = "")
{
	return isset($var) && !empty($var) ? $var
					   : $default;
}
?>
