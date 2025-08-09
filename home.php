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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html id="ctl00_Html1" xmlns="http://www.w3.org/1999/xhtml" lang="it">

<head id="ctl00_Head1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Home </title>
<link rel="stylesheet" type="text/css" href="css/StyleSheet.css" />
<link rel="stylesheet" type="text/css" href="css/DsawStyleSheet.css" media="all" />
<meta name="robots" content="noindex, nofollow" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div id="login">
<div style="margin-top: -20pt; padding: 0pt;">

		<div class="container">
			<div class="row">
				<!-- inizio colonna sinistra -->
				<div class="col-md-4">
					<div style="height: 100px; margin-top:30px;">
					</div>
					<div class="infoText">
						<p>
							<strong><br/>Utente:
								<div class="logon">
		<?php
								echo $array_s_login['username'];
		?>
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
								<a href="mailto:sistemi@<?php echo $dominio; ?>?subject=Richiesta autorizzazione per l'utilizzo di risorse nel portale di amministrazione di <?php echo $dominio; ?>"> Richiesta Autorizzazione</a>.
							<br />
							<br />
		<?php
							if ($type_user==2 || $type_user==1){
								$connect = connectDB();
								$query = " SELECT * FROM inc_ute_map WHERE stato = 'DA APPROVARE' AND anno_scolastico = ?";
								$stmt = mysqli_prepare($connect, $query);
								mysqli_stmt_bind_param($stmt, "s", $anno_scolastico);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								$count = mysqli_num_rows($result);
								disconnectDB($connect);

								if ($count > 0) {
		?>
									<br><strong>
		<?php
								if ($count > 1) {
									$richieste = 'richieste';
								}
								else {
									$richieste = 'richiesta ';
								}
									echo '<a class="moderatenews" href="incarichi/lista_moderazione_incarichi.php">Hai '.$count.' '.$richieste.' di inserimento incarichi da moderare.</a>';
		?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM carta_docente WHERE stato = 'DA APPROVARE' AND anno_scolastico = ?";
								$stmt = mysqli_prepare($connect, $query);
								mysqli_stmt_bind_param($stmt, "s", $anno_scolastico);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								$count = mysqli_num_rows($result);
								disconnectDB($connect);

								if ($count > 0) {
		?>
									<br><strong>
		<?php
								if ($count > 1) {
									$richieste = 'richieste';
								}
								else {
									$richieste = 'richiesta ';
								}
									echo '<br/><a class="moderatenews" href="carta_docente/lista_moderazione_carta.php">Hai '.$count.' '.$richieste.' di inserimento carta del docente da moderare.</a>';
		?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM bonus_docente WHERE stato = 'DA APPROVARE' AND anno_scolastico = ?";
								$stmt = mysqli_prepare($connect, $query);
								mysqli_stmt_bind_param($stmt, "s", $anno_scolastico);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								$count = mysqli_num_rows($result);
								disconnectDB($connect);

								if ($count > 0) {
		?>
									<br><strong>
		<?php
								if ($count > 1) {
									$richieste = 'richieste';
								}
								else {
									$richieste = 'richiesta ';
								}
									echo '<br/><a class="moderatenews" href="bonus_docente/lista_moderazione_bonus.php">Hai '.$count.' '.$richieste.' di inserimento bonus premialit&agrave; docente da moderare.</a>';
		?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM bonus_docente WHERE stato = 'DA APPROVARE' AND anno_scolastico = '2017-2018'";
								$result = mysqli_query($connect, $query);
								$count = mysqli_num_rows($result);
								disconnectDB($connect);

								if ($count > 0) {
		?>
									<br><strong>
		<?php
								if ($count > 1) {
									$richieste = 'richieste';
								}
								else {
									$richieste = 'richiesta ';
								}
									echo '<br/><a class="moderatenews" href="bonus_docente/2017_2018/lista_moderazione_bonus.php">Hai '.$count.' '.$richieste.' di inserimento bonus premialit&agrave; docente a.s. 2017-2018 da moderare.</a>';
		?>
									</strong>
		<?php
								}
							}

							echo '<br/>
							Accesso alla casella di posta elettronica:</strong>
							<strong><a class="moderatenews" href="https://webmail.aruba.it/">WebMail Aruba</a></strong>';
		?>
		<?php

							$query = " SELECT * FROM live_meeting WHERE id_doc = ?";
							$stmt = mysqli_prepare($connect, $query);
							mysqli_stmt_bind_param($stmt, "i", $id_user);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							$count = mysqli_num_rows($result);
							disconnectDB($connect);

							if ($count > 0)
							{
								echo '<br/><br/>';
								echo 'Accesso al </strong> <strong><a class="moderatenews" href="live/live.php">Live Meeting</a></strong>';
							}

		?>
		<?php
		?>

							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<p>&nbsp;</p>


								Per problemi di carattere tecnico contatta il servizio di <a href="mailto:sistemi@<?php echo $dominio; ?>?subject=Segnalazione%20dalla%20pagina%20di%20Login%20del%20portale%20di%20amministrazione%20">assistenza</a>.
							<br />
						</p>
					</div>
				</div>
				<!-- fine colonna sinistra -->
				<!-- inizio colonna destra -->
				<div class="col-md-8">
					<div id="loginForm">
						<br />
						<div>
							<p class="mail_black">
								<strong><br/>Elenco delle applicazioni disponibili:</strong>
							</p>
							<p class="info">
							</p>
		<?php

							$connect = connectDB();
							$res_select_abilitato = getUserAllows($array_s_login);
							disconnectDB($connect);
		?>
							<div class="row">
		<?php
						if ($type_user==2 || $type_user==1){

		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="users/archive.php" class="text-decoration-none">
										<i class="fas fa-users fa-3x"></i>
										<p class="description_ico">Gestione Utenti</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="docenti/archive.php" class="text-decoration-none">
										<i class="fas fa-user-tie fa-3x"></i>
										<p class="description_ico">Gestione Docenti</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="alunni/archive.php" class="text-decoration-none">
										<i class="fas fa-user-graduate fa-3x"></i>
										<p class="description_ico">Gestione Alunni</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="materie/archive.php" class="text-decoration-none">
										<i class="fas fa-book fa-3x"></i>
										<p class="description_ico">Gestione Materie</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="classi/archive.php" class="text-decoration-none">
										<i class="fas fa-school fa-3x"></i>
										<p class="description_ico">Gestione Classi</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="competenze/archive_competenze.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione Traguardi Nazionali</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="obiettivi/archive_obiettivi.php" class="text-decoration-none">
										<i class="fas fa-bullseye fa-3x"></i>
										<p class="description_ico">Gestione Obiettivi Nazionali</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="incarichi/lista.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Gestione Incarichi</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="corsi/lista.php" class="text-decoration-none">
										<i class="fas fa-chart-bar fa-3x"></i>
										<p class="description_ico">Gestione Corsi Aggiornamento</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="incarichi/archivio_report.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Archivio Report Incarichi</p>
									</a>
								</div>
		<?php

							if ($type_user==1){
		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="programmazione/lista_programmazioni.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Report programmazioni</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="scrutini/archivio_scrutinio.php" class="text-decoration-none">
										<i class="fas fa-balance-scale fa-3x"></i>
										<p class="description_ico">Gestione Scrutini</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="scrutini/archivio_scrutinio_doc.php" class="text-decoration-none">
										<i class="fas fa-clipboard-check fa-3x"></i>
										<p class="description_ico">Gestione Voti Proposti</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="relazione_finale/lista_relazioni.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Report relazioni finali</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="settings/edit.php" class="text-decoration-none">
										<i class="fas fa-cog fa-3x"></i>
										<p class="description_ico">Impostazioni</p>
									</a>
								</div>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="certificazione_competenze/lista_profili.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione Profili Certificazione Competenza</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="certificazione_competenze/archivio_certificazioni.php" class="text-decoration-none">
										<i class="fas fa-balance-scale fa-3x"></i>
										<p class="description_ico">Gestione Scrutini Certificazione Competenza</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="certificazione_competenze/report_certificazione.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Report Certificazione Competenza</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dsa/lista_competenze.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione Competenze DSA</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="carta_docente/lista_categorie_spesa.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Gestione Categorie di Spesa</p>
									</a>
								</div>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="carta_docente/archivio_report.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Archivio Report Carta del Docente</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="bonus_docente/lista_categorie_bonus.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Gestione Categorie Bonus Premialit&agrave;</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="bonus_docente/archivio_report.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Archivio Report Bonus Premialit&agrave</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dad/lista_descrittori.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione descrittori DaD</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dad/scrutini_dad.php" class="text-decoration-none">
										<i class="fas fa-balance-scale fa-3x"></i>
										<p class="description_ico">Gestione Scrutini DaD</p>
									</a>
								</div>
		<?php

							}
							else if ($type_user==2){
		?>


								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="scrutini/archivio_scrutinio_doc.php" class="text-decoration-none">
										<i class="fas fa-clipboard-check fa-3x"></i>
										<p class="description_ico">Gestione Voti Proposti</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="settings/edit.php" class="text-decoration-none">
										<i class="fas fa-cog fa-3x"></i>
										<p class="description_ico">Impostazioni</p>
									</a>
								</div>


								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="certificazione_competenze/lista_profili.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione Profili Certificazione Competenza</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="carta_docente/lista_categorie_spesa.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Gestione Categorie di Spesa</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="carta_docente/archivio_report.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Archivio Report Carta del Docente</p>
									</a>
								</div>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="bonus_docente/lista_categorie_bonus.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Gestione Categorie Bonus Premialit&agrave;</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="bonus_docente/archivio_report.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Archivio Report Bonus Premialit&agrave;</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dad/lista_descrittori.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Gestione descrittori DaD</p>
									</a>
								</div>
		<?php

							}

						} else if ($type_user==3){

		?>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="alunni/ricerca.php" class="text-decoration-none">
										<i class="fas fa-search fa-3x"></i>
										<p class="description_ico">Ricerca Alunni</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="incarichi/lista_sel.php" class="text-decoration-none">
										<i class="fas fa-file-signature fa-3x"></i>
										<p class="description_ico">Selezione Incarichi</p>
									</a>
								</div>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="corsi/lista_sel.php" class="text-decoration-none">
										<i class="fas fa-chart-bar fa-3x"></i>
										<p class="description_ico">Selezione Corsi Aggiornamento</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="valutazione/valutazione.php" class="text-decoration-none">
										<i class="fas fa-star-half-alt fa-3x"></i>
										<p class="description_ico">Inserimento Valutazione</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="programmazione/archive.php" class="text-decoration-none">
										<i class="fas fa-calendar-alt fa-3x"></i>
										<p class="description_ico">Inserimento Programmazione</p>
									</a>
								</div>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="valutazione/seleziona_report.php" class="text-decoration-none">
										<i class="fas fa-archive fa-3x"></i>
										<p class="description_ico">Report Valutazioni</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="diario/eventi.php" class="text-decoration-none">
										<i class="fas fa-book-open fa-3x"></i>
										<p class="description_ico">Diario di Bordo</p>
									</a>
								</div>

								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="scrutini/archivio.php" class="text-decoration-none">
										<i class="fas fa-clipboard-check fa-3x"></i>
										<p class="description_ico">Inserimento Voti Proposti Scrutini</p>
									</a>
								</div>
		<?php
							$connect = connectDB();
							$query = " SELECT * FROM doc_cla_map WHERE id_doc = ? AND coordinatore = 1";
							$stmt = mysqli_prepare($connect, $query);
							mysqli_stmt_bind_param($stmt, "i", $id_user);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);
							if (!$result) {
								$message  = 'Invalid query: ' . mysqli_error() . "\nWhole query: " . $query;
								die($message);
							}
							$check = mysqli_num_rows($result);
							disconnectDB($connect);


							//if ($check>0 && $res_select_abilitato['ALLOW_SCRUTINI_INS'] == 'SI') {
		            // <a target="blank" href="scrutini/archivio_scrutinio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="scrutini/archivio_scrutinio.php" class="text-decoration-none">
										<i class="fas fa-balance-scale fa-3x"></i>
										<p class="description_ico">Consultazione Scrutini</p>
									</a>
								</div>
		<?php
							//}
							//else {
		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="relazione_finale/archive.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Inserimento Relazione Finale</p>
									</a>
								</div>
		<?php
							//}
		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="certificazione_competenze/lista_proposte.php" class="text-decoration-none">
										<i class="fas fa-balance-scale fa-3x"></i>
										<p class="description_ico">Inserimento Certificazioni Competenza Proposte</p>
									</a>
								</div>

		<?php

		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="carta_docente/lista_sel.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Inserimento Carta del Docente</p>
									</a>
								</div>
		<?php

		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="bonus_docente/lista_sel.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Inserimento Bonus Premialit&agrave Docente</p>
									</a>
								</div>

		<?php

		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dad/ins_valutazione_dad.php" class="text-decoration-none">
										<i class="fas fa-video fa-3x"></i>
										<p class="description_ico">Inserimento Valutazione DaD</p>
									</a>
								</div>

		<?php
								if ( ($res_select_abilitato['ALLOW_DSA_INS'] == 'SI') || isAllowDsaIns($array_s_login['id']) ) {
		?>
								<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
									<a target="blank" href="dsa/lista_osservazioni.php" class="text-decoration-none">
										<i class="fas fa-chart-line fa-3x"></i>
										<p class="description_ico">Inserimento Osservazioni DSA</p>
									</a>
								</div>
		<?php
								}
		?>

		<?php
						}

		?>


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
		<div id="copyright"><?php echo $footer; ?></div>
        <div class="clear"></div>
	</div>
	<!-- fine footer -->

</div>
</body>
</html>


<?php

exit;
    }
}

session_destroy();
header("Location: index.php");
exit;
?>
