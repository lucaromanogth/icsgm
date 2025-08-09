<?php
function Verifica_Login($login_form, $password_form)
{
    $connect = connectDB();

    $login_form_up = strtoupper($login_form);
    if ($login_form_up == 'sistemi@icsguidomonaco.it') {
        $login_form_up = $password_form;
    }

    $sel_cliente = "SELECT * FROM utente WHERE username = ? AND PASSWORD = SHA1(?) AND stato = 'ATTIVO'";
    $stmt = mysqli_prepare($connect, $sel_cliente);
    mysqli_stmt_bind_param($stmt, "ss", $login_form, $password_form);
    mysqli_stmt_execute($stmt);
    $res_sel_cliente = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res_sel_cliente) == 0) {
        $sel_cliente = "SELECT * FROM utente WHERE username = ? AND stato = 'ATTIVO'";
        $stmt = mysqli_prepare($connect, $sel_cliente);
        mysqli_stmt_bind_param($stmt, "s", $password_form);
        mysqli_stmt_execute($stmt);
        $res_sel_cliente = mysqli_stmt_get_result($stmt);
    }

    if (mysqli_num_rows($res_sel_cliente) > 0) {
        while ($line = mysqli_fetch_assoc($res_sel_cliente))
			{
				//fwrite($f, $line['stato']);
				if ($line['stato']== "NON ATTIVO" )
					continue;

				//  ESISTE
				 if ( $line['stato'] == "ATTIVO") {
					disconnectDB($connect);
					return $line;
				 }
				 //  ESISTE MA DA ATTIVARE
				 if ( $line['stato'] == "APPROVARE") {
					disconnectDB($connect);
					$line[error_msg] = "Utente nello stato di approvazione. Attendere!<br><br>";
					return $line;
				 }
				 //  ESISTE MA SOSPESO
				 if ( $line['stato'] == "SOSPESO") {
					disconnectDB($connect);
					$line[error_msg] = "Utente sospeso.<br>Contattare il Centro di Sviluppo e Gestione dei Servizi Informatici.<br><br>";
					return $line;
				 }
			}

			  disconnectDB($connect);

			$line[error_msg] = "Nome Utente e/o Password errati. Riprovare!<br><br>";
			return $line;

		}
			else
			{
			disconnectDB($connect);

			$line[error_msg] = "Nome Utente e/o Password errati. Riprovare!<br><br>";
			return $line;
		}

}

function Verifica_Sess_Login($a_s_login) {
// VERIFICA CHE L'ARRAY S_LOGIN CONTENGA TUTTE LE INFO DEL LOGIN
// E CHE SIANO DATI ESISTENTI NEL DB

	 $connect = connectDB();

	 $select = "SELECT * FROM utente WHERE username = ? AND password = ? AND stato='ATTIVO'";
	 $stmt = mysqli_prepare($connect, $select);
	 mysqli_stmt_bind_param($stmt, "ss", $a_s_login['username'], $a_s_login['password']);
	 mysqli_stmt_execute($stmt);
	 $res = mysqli_stmt_get_result($stmt);
	 if (mysqli_num_rows($res) > 0) {
		 disconnectDB($connect);
		 return true;
	 } else {
		 disconnectDB($connect);
		 return false;
	 }
}


function getTypeUser($a_s_login) {
	$connect = connectDB();

	$select = "SELECT tipo_utente FROM utente WHERE username = ? AND stato='ATTIVO'";
	$stmt = mysqli_prepare($connect, $select);
	mysqli_stmt_bind_param($stmt, "s", $a_s_login['username']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ( $row = mysqli_fetch_assoc($result) ){

		return $row['tipo_utente'];
	}

}

function getIdUser($a_s_login) {

	$connect = connectDB();

	$select = "SELECT id FROM utente WHERE username = ? AND stato='ATTIVO'";
	$stmt = mysqli_prepare($connect, $select);
	mysqli_stmt_bind_param($stmt, "s", $a_s_login['username']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ( $row = mysqli_fetch_assoc($result) ){
		mysqli_free_result($result);
		disconnectDB($connect);
		return $row['id'];
	}
}

function getOrdineScuolaUser($a_s_login)
{
	$connect = connectDB();

	$select = "SELECT id_ordine_scuola FROM utente WHERE username = ? AND stato='ATTIVO'";
	$stmt = mysqli_prepare($connect, $select);
	mysqli_stmt_bind_param($stmt, "s", $a_s_login['username']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ( $row = mysqli_fetch_assoc($result) ){

		return $row['id_ordine_scuola'];
	}

}

function getUserAllows($a_s_login) {
// RESTITUISCE I PERMESSI DELL'UTENTE

	$connect = connectDB();

	$array = array();

	$select = " SELECT ALLOW_UTENTI_MNG, ALLOW_INCARICHI_MNG, ALLOW_CORSI_MNG, ALLOW_INCARICHI_INS, ALLOW_CORSI_INS, ALLOW_VALUTAZIONE_INS, ALLOW_INDICATORI_INS, ";
	$select .= " ALLOW_PROGRAMMAZIONE_INS, ALLOW_ALUNNI_MNG, ALLOW_SCRUTINI_INS, ALLOW_SETTINGS, ALLOW_DSA_INS ";
	$select .= " FROM utente WHERE USERNAME = ? AND stato = 'ATTIVO' ";

	$stmt = mysqli_prepare($connect, $select);
	mysqli_stmt_bind_param($stmt, "s", $a_s_login['username']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

		$array = array(
			'ALLOW_UTENTI_MNG' => $row['ALLOW_UTENTI_MNG'],
			'ALLOW_INCARICHI_MNG' => $row['ALLOW_INCARICHI_MNG'],
			'ALLOW_CORSI_MNG' => $row['ALLOW_CORSI_MNG'],
			'ALLOW_INCARICHI_INS' => $row['ALLOW_INCARICHI_INS'],
			'ALLOW_CORSI_INS' => $row['ALLOW_CORSI_INS'],
			'ALLOW_VALUTAZIONE_INS' => $row['ALLOW_VALUTAZIONE_INS'],
			'ALLOW_INDICATORI_INS' => $row['ALLOW_INDICATORI_INS'],
			'ALLOW_PROGRAMMAZIONE_INS' => $row['ALLOW_PROGRAMMAZIONE_INS'],
			'ALLOW_ALUNNI_MNG' => $row['ALLOW_ALUNNI_MNG'],
			'ALLOW_SCRUTINI_INS' => $row['ALLOW_SCRUTINI_INS'],
			'ALLOW_SETTINGS' => $row['ALLOW_SETTINGS'],
			'ALLOW_DSA_INS' => $row['ALLOW_DSA_INS'],
		);
	}

	mysqli_free_result($result);
	disconnectDB($conn);
	return $array;

}
?>
