<?php
session_set_cookie_params(3600);
ini_set('session.gc_maxlifetime', 3600);

session_start();

if (isset($_SESSION["S_LOGIN"]) && !empty($_SESSION["S_LOGIN"]))
{

  include_once("set/lib.php");
  include_once("set/verifica_login.php");
	

	$array_s_login = $_SESSION["S_LOGIN"];
	$type_user = getTypeUser($array_s_login);
	$id_user = getIdUser($array_s_login);

	if ($type_user==4)
  	{
		header( 'Location: diario/n/consulta_diario.php' );
	}
	if ($type_user==1)
  	{
		header( 'Location: admin.php' );
	}

	//$curr_year = date('Y');
	//$anno_scolastico = ($curr_year-1).'-'.$curr_year;
	$anno_scolastico = getAnnoScolastico();
	$footer = getFooter();
	$dominio = getDominio();

	if (Verifica_Sess_Login($array_s_login)) {

       // VERIFICA OK!!!
       echo <<< EOQ

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="ctl00_Html1" xmlns="http://www.w3.org/1999/xhtml" lang="it">

<head id="ctl00_Head1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home </title>
<link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />
<link rel="stylesheet" type="text/css" href="css/DsawStyleSheet.css" media="all" />
<meta name="robots" content="noindex, nofollow" />
</head>

<body>
<div id="login">
<div style="margin-top: -20pt; padding: 0pt;">

		<!-- inizio colonna sinistra -->
		<div class="left">
			<div style="height: 100px; margin-top:30px;">
			</div>
			<div class="infoText">
				<p>
					<strong><br/>Utente:
						<div class="logon">
EOQ;
						echo $array_s_login['username'];
						echo <<< EOQ
						</div>
						<br />
						<a href="logout.php"> Logout</a>
					</strong>
					<br />
					<br />
						Il men&ugrave a destra presenta le applicazioni che puoi utilizzare in accordo con le politiche aziendali.
					<br />
					<br />
					<strong>
						Hai necessit&agrave di utilizzare un'applicazione che trovi disabilitata?
					</strong>
					<br />
						Richiedine l'autorizzazione per l'utilizzo cliccando sul link seguente:
					<br />
						<a href="mailto:sistemi@$dominio?subject=Richiesta autorizzazione per l'utilizzo di risorse nel portale di amministrazione di $dominio"> Richiesta Autorizzazione</a>.
					<br />
					<br />
EOQ;
					if ($type_user==2 || $type_user==1){
						$connect = connectDB();
						$query = " SELECT * FROM ";
						$query .= " inc_ute_map ";
						$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

						$result = mysqli_query($connect, $query);
						$count = mysqli_num_rows($result);
						disconnectDB($connect);

						if ($count > 0) {
							echo <<< EOQ
							<br><strong>
EOQ;
						if ($count > 1) {
							$richieste = 'richieste';
						}
						else {
							$richieste = 'richiesta ';
						}
							echo '<a class="moderatenews" href="incarichi/lista_moderazione_incarichi.php">Hai '.$count.' '.$richieste.' di inserimento incarichi da moderare.</a>';
							echo <<< EOQ
							</strong>
EOQ;
						}

						$query = " SELECT * FROM ";
						$query .= " carta_docente ";
						$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

						$connect = connectDB();
						$result = mysqli_query($connect, $query);
						$count = mysqli_num_rows($result);
						disconnectDB($connect);

						if ($count > 0) {
							echo <<< EOQ
							<br><strong>
EOQ;
						if ($count > 1) {
							$richieste = 'richieste';
						}
						else {
							$richieste = 'richiesta ';
						}
							echo '<br/><a class="moderatenews" href="carta_docente/lista_moderazione_carta.php">Hai '.$count.' '.$richieste.' di inserimento carta del docente da moderare.</a>';
							echo <<< EOQ
							</strong>
EOQ;
						}

						$query = " SELECT * FROM ";
						$query .= " bonus_docente ";
						$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

						$connect = connectDB();
						$result = mysqli_query($connect, $query);
						$count = mysqli_num_rows($result);
						disconnectDB($connect);

						if ($count > 0) {
							echo <<< EOQ
							<br><strong>
EOQ;
						if ($count > 1) {
							$richieste = 'richieste';
						}
						else {
							$richieste = 'richiesta ';
						}
							echo '<br/><a class="moderatenews" href="bonus_docente/lista_moderazione_bonus.php">Hai '.$count.' '.$richieste.' di inserimento bonus premialit&agrave; docente da moderare.</a>';
							echo <<< EOQ
							</strong>
EOQ;
						}

						$query = " SELECT * FROM ";
						$query .= " bonus_docente ";
						$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '2017-2018'";

						$connect = connectDB();
						$result = mysqli_query($connect, $query);
						$count = mysqli_num_rows($result);
						disconnectDB($connect);

						if ($count > 0) {
							echo <<< EOQ
							<br><strong>
EOQ;
						if ($count > 1) {
							$richieste = 'richieste';
						}
						else {
							$richieste = 'richiesta ';
						}
							echo '<br/><a class="moderatenews" href="bonus_docente/2017_2018/lista_moderazione_bonus.php">Hai '.$count.' '.$richieste.' di inserimento bonus premialit&agrave; docente a.s. 2017-2018 da moderare.</a>';
							echo <<< EOQ
							</strong>
EOQ;
						}
					}

					echo '<br/>
					Accesso alla casella di posta elettronica:</strong>
					<strong><a class="moderatenews" href="https://webmail.aruba.it/">WebMail Aruba</a></strong>';
							echo <<< EOQ
EOQ;

					$query = " SELECT * FROM live_meeting WHERE id_doc = $id_user ";
					$connect = connectDB();
					$result = mysqli_query($connect, $query);
					$count = mysqli_num_rows($result);
					disconnectDB($connect);

					if ($count > 0)
					{
						echo '<br/><br/>';
						echo 'Accesso al </strong> <strong><a class="moderatenews" href="live/live.php">Live Meeting</a></strong>';
					}

					echo <<< EOQ
EOQ;

					echo <<< EOQ

					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>


						Per problemi di carattere tecnico contatta il servizio di <a href="mailto:sistemi@$dominio?subject=Segnalazione%20dalla%20pagina%20di%20Login%20del%20portale%20di%20amministrazione%20">assistenza</a>.
					<br />
				</p>
			</div>
		</div>
		<!-- fine colonna sinistra -->
		<!-- inizio colonna destra -->
		<div class="right">
			<div id="loginForm">
				<br />
				<div>
					<p class="mail_black">
						<strong><br/>Elenco delle applicazioni disponibili:</strong>
					</p>
					<p class="info">
					</p>
EOQ;

					$connect = connectDB();
					$res_select_abilitato = getUserAllows($array_s_login);
					disconnectDB($connect);
					echo <<< EOQ
					<div id="container">
EOQ;
				if ($type_user==2 || $type_user==1){

						echo <<< EOQ
						<div class="cella1" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/addusers_off.png" alt="Gestione Utenti" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="users/archive.php"><img src="img/addusers_on.png" alt="Gestione Utenti" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/docenti_off.png" alt="Gestione Docenti" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="docenti/archive.php"><img src="img/docenti_on.png" alt="Gestione Docenti" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella3" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_ALUNNI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/alunni_off.png" alt="Gestione Alunni" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="alunni/archive.php"><img src="img/alunni_on.png" alt="Gestione Alunni" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/materie_off.png" alt="Gestione Materie" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="materie/archive.php"><img src="img/materie_on.png" alt="Gestione Materie" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>


						<div class="cella5" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/classi_off.png" alt="Gestione Classi" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="classi/archive.php"><img src="img/classi_on.png" alt="Gestione Classi" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>


						<div class="cella1b" style="top: 85px;">
						<p align="center" class="description_ico">Gestione Utenti</p>
						</div>
						<div class="cella2b" style="top: 85px;">
						<p align="center" class="description_ico">Gestione Docenti</p>
						</div>
						<div class="cella3b" style="top: 85px;">
						<p align="center" class="description_ico">Gestione Alunni</p>
						</div>
						<div class="cella4b" style="top: 85px;">
						<p align="center" class="description_ico">Gestione Materie</p>
						</div>
						<div class="cella5b" style="top: 85px;">
						<p align="center" class="description_ico">Gestione Classi</p>
						</div>


						<div class="cella1c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="competenze/archive_competenze.php"><img src="img/indicatori_on.png" alt="competenze" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/obiettivi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="obiettivi/archive_obiettivi.php"><img src="img/obiettivi_on.png" alt="obiettivi" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella3c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="incarichi/lista.php"><img src="img/incarichi_on.png" alt="incarichi" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_CORSI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/stats_off.png" alt="corsi" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="corsi/lista.php"><img src="img/stats_on.png" alt="corsi" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella5c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="incarichi/archivio_report.php"><img src="img/archivio_on.png" alt="incarichi" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella1d" style="top: 205px;">
						<p align="center" class="description_ico">Gestione Traguardi Nazionali</p>
						</div>

						<div class="cella2d" style="top: 205px;">
						<p align="center" class="description_ico">Gestione Obiettivi Nazionali</p>
						</div>

						<div class="cella3d" style="top: 205px;">
						<p align="center" class="description_ico">Gestione Incarichi</p>
						</div>

						<div class="cella4d" style="top: 205px;">
						<p align="center" class="description_ico">Gestione Corsi Aggiornamento</p>
						</div>

						<div class="cella5d" style="top: 205px;">
						<p align="center" class="description_ico">Archivio Report Incarichi</p>
						</div>

EOQ;

					if ($type_user==1){
						echo <<< EOQ
						<div class="cella1c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="programmazione/lista_programmazioni.php"><img src="img/archivio_on.png" alt="Report programmazioni" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2c" style="top: 265px;">
							<p class="ico_ico">
								<a target="blank" href="scrutini/archivio_scrutinio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
							</p>
						</div>

						<div class="cella3c" style="top: 265px;">
							<p class="ico_ico">
								<a target="blank" href="scrutini/archivio_scrutinio_doc.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
							</p>
						</div>

						<div class="cella4c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="relazione_finale/lista_relazioni.php"><img src="img/archivio_on.png" alt="Report relazioni finali" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella5c" style="top: 265px;">
							<p class="ico_ico">
								<a target="blank" href="settings/edit.php"><img src="img/settings.png" alt="settings" width="60" height="60"></img></a>
							</p>
						</div>

EOQ;
						echo <<< EOQ

						<div class="cella1d" style="top: 325px;">
						<p align="center" class="description_ico">Report programmazioni</p>
						</div>

						<div class="cella2d" style="top: 325px;">
						<p align="center" class="description_ico">Gestione Scrutini</p>
						</div>

						<div class="cella3d" style="top: 325px;">
						<p align="center" class="description_ico">Gestione Voti Proposti</p>
						</div>

						<div class="cella4d" style="top: 325px;">
						<p align="center" class="description_ico">Report relazioni finali</p>
						</div>

						<div class="cella5d" style="top: 325px;">
						<p align="center" class="description_ico">Impostazioni</p>
						</div>


						<div class="cella1e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="certificazione_competenze/lista_profili.php"><img src="img/indicatori_on.png" alt="profili_certificazione_competenza" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="certificazione_competenze/archivio_certificazioni.php"><img src="img/scrutini_on.png" alt="archivio_certificazioni" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella3e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="certificazione_competenze/report_certificazione.php"><img src="img/archivio_on.png" alt="report_certificazione" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="dsa/lista_competenze.php"><img src="img/indicatori_on.png" alt="profili_certificazione_competenza" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella5e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="carta_docente/lista_categorie_spesa.php"><img src="img/incarichi_on.png" alt="categorie di spesa" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella1f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione Profili Certificazione Competenza</p>
						</div>

						<div class="cella2f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione Scrutini Certificazione Competenza</p>
						</div>

						<div class="cella3f" style="top: 445px;">
						<p align="center" class="description_ico">Report Certificazione Competenza</p>
						</div>

						<div class="cella4f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione Competenze DSA</p>
						</div>

						<div class="cella5f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione Categorie di Spesa</p>
						</div>


						<div class="cella1g" style="top: 505px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="carta_docente/archivio_report.php"><img src="img/archivio_on.png" alt="categorie di spesa" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2g" style="top: 505px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="bonus_docente/lista_categorie_bonus.php"><img src="img/incarichi_on.png" alt="categorie bonus" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella3g" style="top: 505px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="bonus_docente/archivio_report.php"><img src="img/indicatori_on.png" alt="bonus premialita" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4g" style="top: 505px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="dad/lista_descrittori.php"><img src="img/indicatori_on.png" alt="descrittori dad" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella5g" style="top: 505px;">
							<p class="ico_ico">
								<a target="blank" href="dad/scrutini_dad.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
							</p>
						</div>

						<div class="cella1h" style="top: 565px;">
						<p align="center" class="description_ico">Archivio Report Carta del Docente</p>
						</div>

						<div class="cella2h" style="top: 565px;">
						<p align="center" class="description_ico">Gestione Categorie Bonus Premialit&agrave;</p>
						</div>

						<div class="cella3h" style="top: 565px;">
						<p align="center" class="description_ico">Archivio Report Bonus Premialit&agrave</p>
						</div>

						<div class="cella4h" style="top: 565px;">
						<p align="center" class="description_ico">Gestione descrittori DaD</p>
						</div>

						<div class="cella5h" style="top: 565px;">
						<p align="center" class="description_ico">Gestione Scrutini DaD</p>
						</div>
EOQ;

					}
					else if ($type_user==2){
						echo <<< EOQ


						<div class="cella1c" style="top: 265px;">
							<p class="ico_ico">
								<a target="blank" href="scrutini/archivio_scrutinio_doc.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
							</p>
						</div>

						<div class="cella2c" style="top: 265px;">
							<p class="ico_ico">
								<a target="blank" href="settings/edit.php"><img src="img/settings.png" alt="settings" width="60" height="60"></img></a>
							</p>
						</div>


						<div class="cella3c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_UTENTI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/indicatori_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="certificazione_competenze/lista_profili.php"><img src="img/indicatori_on.png" alt="profili_certificazione_competenza" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="carta_docente/lista_categorie_spesa.php"><img src="img/incarichi_on.png" alt="categorie di spesa" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella5c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="carta_docente/archivio_report.php"><img src="img/archivio_on.png" alt="categorie di spesa" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>


EOQ;
						echo <<< EOQ


						<div class="cella1d" style="top: 325px;">
						<p align="center" class="description_ico">Gestione Voti Proposti</p>
						</div>

						<div class="cella2d" style="top: 325px;">
						<p align="center" class="description_ico">Impostazioni</p>
						</div>

						<div class="cella3d" style="top: 325px;">
						<p align="center" class="description_ico">Gestione Profili Certificazione Competenza</p>
						</div>

						<div class="cella4d" style="top: 325px;">
						<p align="center" class="description_ico">Gestione Categorie di Spesa</p>
						</div>

						<div class="cella5d" style="top: 325px;">
						<p align="center" class="description_ico">Archivio Report Carta del Docente</p>
						</div>


						<div class="cella1e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="bonus_docente/lista_categorie_bonus.php"><img src="img/incarichi_on.png" alt="categorie bonus" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="bonus_docente/archivio_report.php"><img src="img/archivio_on.png" alt="bonus premialita" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella3e" style="top: 385px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_MNG'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="dad/lista_descrittori.php"><img src="img/archivio_on.png" alt="descrittori dad" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

EOQ;
						echo <<< EOQ
						<div class="cella1f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione Categorie Bonus Premialit&agrave;</p>
						</div>

EOQ;
						echo <<< EOQ
						<div class="cella2f" style="top: 445px;">
						<p align="center" class="description_ico">Archivio Report Bonus Premialit&agrave;</p>
						</div>
EOQ;

						echo <<< EOQ
						<div class="cella3f" style="top: 445px;">
						<p align="center" class="description_ico">Gestione descrittori DaD</p>
						</div>
EOQ;

					}

				} else if ($type_user==3){

					echo <<< EOQ

						<div class="cella1" style="top: 25px;">
							<p class="ico_ico">

EOQ;
							if ($res_select_abilitato['ALLOW_VALUTAZIONE_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/addusers_off.png" alt="stats" width="60" height="60"></img>
EOQ;
							}
							else {
								echo <<< EOQ
										<a target="blank" href="alunni/ricerca.php">
											<img src="img/addusers_on.png" alt="anagrafica" width="60" height="60"></img>
										</a>
EOQ;
							}


							echo <<< EOQ

							</p>
						</div>

						<div class="cella2" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_INCARICHI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/incarichi_off.png" alt="stats" width="60" height="60"></img>
EOQ;
							}

							else {
								$connect = connectDB();
								$query = "SELECT stato FROM inc_ute_map WHERE id_utente=".$id_user." AND anno_scolastico = '".$anno_scolastico."'";
								$result = mysqli_query($connect, $query);

								if ($row = mysqli_fetch_assoc($result)) {

									if ($row['stato'] == 'BOZZA') {

									echo <<< EOQ
										<a target="blank" href="incarichi/lista_sel.php">
											<img src="img/incarichi_on.png" alt="incarichi" width="60" height="60"></img>
										</a>
EOQ;
									}
									else {

										echo <<< EOQ
										<a target="blank" href="incarichi/report_incarichi.php">
											<img src="img/incarichi_on.png" alt="incarichi" width="60" height="60"></img>
										</a>
EOQ;
									}
								}
								else {
									echo <<< EOQ
										<a target="blank" href="incarichi/lista_sel.php">
											<img src="img/incarichi_on.png" alt="incarichi" width="60" height="60"></img>
										</a>
EOQ;
								}
							}


								echo <<< EOQ
							</p>
						</div>
						<div class="cella3" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_CORSI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/stats_off.png" alt="corsi" width="60" height="60"></img>
EOQ;
								}
								else {
								$connect = connectDB();
								$query = "SELECT stato FROM inc_ute_map WHERE id_utente=".$id_user." AND anno_scolastico = '".$anno_scolastico."'";
								$result = mysqli_query($connect, $query);

								if ($row = mysqli_fetch_assoc($result)) {

									if ($row['stato'] == 'BOZZA') {

									echo <<< EOQ
										<a target="blank" href="corsi/lista_sel.php">
											<img src="img/stats_on.png" alt="corsi" width="60" height="60"></img>
										</a>
EOQ;
									}
									else {

										echo <<< EOQ
										<a target="blank" href="incarichi/report_incarichi.php">
											<img src="img/stats_on.png" alt="corsi" width="60" height="60"></img>
										</a>
EOQ;
									}
								}
								else {
									echo <<< EOQ
										<a target="blank" href="corsi/lista_sel.php">
											<img src="img/stats_on.png" alt="corsi" width="60" height="60"></img>
										</a>
EOQ;
								}
							}

								echo <<< EOQ
							</p>
						</div>

						<div class="cella4" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_VALUTAZIONE_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/valutazione_off.png" alt="stats" width="60" height="60"></img>
EOQ;
							}
							else {
								echo <<< EOQ
										<a target="blank" href="valutazione/valutazione.php">
											<img src="img/valutazione_on.png" alt="valutazione" width="60" height="60"></img>
										</a>
EOQ;
							}


							echo <<< EOQ
							</p>
						</div>

						<div class="cella5" style="top: 25px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_PROGRAMMAZIONE_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/programmazione_off.png" alt="stats" width="60" height="60"></img>
EOQ;
							}
							else {
								echo <<< EOQ
										<a target="blank" href="programmazione/archive.php">
											<img src="img/programmazione_on.png" alt="programmazione" width="60" height="60"></img>
										</a>
EOQ;
							}



							echo <<< EOQ
							</p>
						</div>


						<div class="cella1b" style="top: 85px;">
						<p align="center" class="description_ico">Ricerca Alunni</p>
						</div>
						<div class="cella2b" style="top: 85px;">
						<p align="center" class="description_ico">Selezione Incarichi</p>
						</div>
						<div class="cella3b" style="top: 85px;">
						<p align="center" class="description_ico">Selezione Corsi Aggiornamento</p>
						</div>
						<div class="cella4b" style="top: 85px;">
						<p align="center" class="description_ico">Inserimento Valutazione</p>
						</div>
						<div class="cella5b" style="top: 85px;">
						<p align="center" class="description_ico">Inserimento Programmazione</p>
						</div>


						<div class="cella1c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_VALUTAZIONE_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/archivio_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="valutazione/seleziona_report.php"><img src="img/archivio_on.png" alt="report" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella2c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_VALUTAZIONE_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/diario_bordo_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ
								<a target="blank" href="diario/eventi.php"><img src="img/diario_bordo_on.png" alt="report" width="60" height="60"></img></a>
EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

						<div class="cella4c" style="top: 145px;">
							<p class="ico_ico">
EOQ;
							if ($res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'NO') {

								echo <<< EOQ
								<img src="img/scrutini_off.png" alt="stats" width="60" height="60"></img>
EOQ;
								} else {
								echo <<< EOQ

								<a target="blank" href="scrutini/archivio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>

EOQ;
								}
								echo <<< EOQ
							</p>
						</div>

EOQ;
					$connect = connectDB();
					$query = " SELECT * FROM ";
					$query .= " doc_cla_map ";
					$query .= " WHERE id_doc = ".$id_user;
					$query .= " AND coordinatore = 1 ";

					$result = mysqli_query($connect, $query);
					if (!$result) {
						$message  = 'Invalid query: ' . mysqli_error() . "\nWhole query: " . $query;
						die($message);
					}
					$check = mysqli_num_rows($result);
					disconnectDB($connect);


					//if ($check>0 && $res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'SI') {
            // <a target="blank" href="scrutini/archivio_scrutinio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
						echo <<< EOQ
						<div class="cella5c" style="top: 145px;">
							<p class="ico_ico">
							   <a target="blank" href="scrutini/archivio_scrutinio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
							</p>
						</div>
EOQ;
					//}
					//else {
						echo <<< EOQ
						<div class="cella3c" style="top: 145px;">
							<p class="ico_ico">
								<a target="blank" href="relazione_finale/archive.php"><img src="img/indicatori_on.png" alt="relazione finale" width="60" height="60"></img></a>
							</p>
						</div>
EOQ;
					//}

						echo <<< EOQ

						<div class="cella1d" style="top: 205px;">
						<p align="center" class="description_ico">Report Valutazioni</p>
						</div>
						<div class="cella2d" style="top: 205px;">
						<p align="center" class="description_ico">Diario di Bordo</p>
						</div>
						<div class="cella3d" style="top: 205px;">
						<p align="center" class="description_ico">Inserimento Relazione Finale</p>
						</div>
EOQ;

					//if ($check>0 && $res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'SI') {
						echo <<< EOQ
						<div class="cella5d" style="top: 205px;">
						<p align="center" class="description_ico">Consultazione Scrutini</p>
						</div>
EOQ;
					//}
					/*else {
						echo <<< EOQ
						<div class="cella5d" style="top: 205px;">
						<p align="center" class="description_ico">Consultazione Scrutini</p>
						</div>	*/
EOQ;
					//}

					//else {
						echo <<< EOQ
						<div class="cella4d" style="top: 205px;">
						<p align="center" class="description_ico">Inserimento Voti Proposti Scrutini</p>
						</div>


EOQ;
					//}


						echo <<< EOQ
						<div class="cella1c" style="top: 265px;">
							<p class="ico_ico">
EOQ;

								echo <<< EOQ
								<a target="blank" href="certificazione_competenze/lista_proposte.php"><img src="img/scrutini_on.png" alt="Inserimento Certificazioni Competenza Proposte" width="60" height="60"></img></a>
EOQ;

								echo <<< EOQ
							</p>
						</div>

EOQ;

						echo <<< EOQ
						<div class="cella2c" style="top: 265px;">
							<p class="ico_ico">
EOQ;

								echo <<< EOQ
								<a target="blank" href="carta_docente/lista_sel.php"><img src="img/indicatori_on.png" alt="Inserimento Carta del Docente" width="60" height="60"></img></a>
EOQ;

								echo <<< EOQ
							</p>
						</div>
EOQ;

						echo <<< EOQ
						<div class="cella3c" style="top: 265px;">
							<p class="ico_ico">
EOQ;

								echo <<< EOQ
								<a target="blank" href="bonus_docente/lista_sel.php"><img src="img/indicatori_on.png" alt="Inserimento Bonus Premialit&agrave; Docente" width="60" height="60"></img></a>
EOQ;

								echo <<< EOQ
							</p>
						</div>

EOQ;

						echo <<< EOQ
						<div class="cella4c" style="top: 265px;">
							<p class="ico_ico">
EOQ;

								echo <<< EOQ
								<a target="blank" href="dad/ins_valutazione_dad.php"><img src="img/video_on.png" alt="Inserimento Valutazione DaD" width="60" height="60"></img></a>
EOQ;

								echo <<< EOQ
							</p>
						</div>

EOQ;
						if ( ($res_select_abilitato['ALLOW_DSA_INS'] == 'SI') || isAllowDsaIns($array_s_login['id']) ) {
								echo <<< EOQ
						<div class="cella5c" style="top: 265px;">
							<p class="ico_ico">
EOQ;
								echo <<< EOQ
								<a target="blank" href="dsa/lista_osservazioni.php"><img src="img/indicatori_on.png" alt="Inserimento Osservazioni DSA" width="60" height="60"></img></a>
EOQ;

								echo <<< EOQ
							</p>
						</div>
EOQ;
						}
								echo <<< EOQ
						<div class="cella1d" style="top: 325px;">
						<p align="center" class="description_ico">Inserimento Certificazioni Competenza Proposte</p>
						</div>

EOQ;
						echo <<< EOQ
						<div class="cella2d" style="top: 325px;">
						<p align="center" class="description_ico">Inserimento Carta del Docente</p>
						</div>

EOQ;
						echo <<< EOQ
						<div class="cella3d" style="top: 325px;">
						<p align="center" class="description_ico">Inserimento Bonus Premialit&agrave Docente</p>
						</div>

EOQ;
						echo <<< EOQ
						<div class="cella4d" style="top: 325px;">
						<p align="center" class="description_ico">Inserimento Valutazione DaD</p>
						</div>

EOQ;
						if ($res_select_abilitato['ALLOW_DSA_INS'] == 'SI' || isAllowDsaIns($array_s_login['id'])) {
								echo <<< EOQ
						<div class="cella5d" style="top: 325px;">
						<p align="center" class="description_ico">Inserimento Osservazioni DSA</p>
						</div>
EOQ;
						}
								echo <<< EOQ

EOQ;
				}

				echo <<< EOQ


					</div>


					<br />
					<div>
						<span class="checkbox">


						</span>
					</div>
					<br />

				</div>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
	<!-- fine colonna destra -->

	<!-- inizio footer -->
	<div class="footer" style="margin-top:120pt">
		<div class="clear"></div>
		<div id="copyright">$footer</div>
        <div class="clear"></div>
	</div>
	<!-- fine footer -->

</div>
</body>
</html>


EOQ;

exit;
    }
}

session_destroy();
header("Location: index.php");
exit;
?>
