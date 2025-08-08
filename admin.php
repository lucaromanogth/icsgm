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

	if ($type_user!=1)
  {
		header( 'Location: index.php' );
	}

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
								<a href="mailto:sistemi@$dominio?subject=Richiesta autorizzazione per l'utilizzo di risorse nel portale di amministrazione di $dominio"> Richiesta Autorizzazione</a>.
							<br />
							<br />
		<?php
							  $connect = connectDB();
								$query = " SELECT * FROM ";
								$query .= " inc_ute_map ";
								$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

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
									echo '<a class="moderatenews" href="incarichi/lista_moderazione_incarichi.php">Hai '.$count.' '.$richieste.' di inserimento incarichi da moderare.</a>';
								?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM ";
								$query .= " carta_docente ";
								$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

								$connect = connectDB();
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
									echo '<br/><a class="moderatenews" href="carta_docente/lista_moderazione_carta.php">Hai '.$count.' '.$richieste.' di inserimento carta del docente da moderare.</a>';
								?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM ";
								$query .= " bonus_docente ";
								$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '".$anno_scolastico."'";

								$connect = connectDB();
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
									echo '<br/><a class="moderatenews" href="bonus_docente/lista_moderazione_bonus.php">Hai '.$count.' '.$richieste.' di inserimento bonus premialit&agrave; docente da moderare.</a>';
								?>
									</strong>
		<?php
								}

								$query = " SELECT * FROM ";
								$query .= " bonus_docente ";
								$query .= " WHERE stato = 'DA APPROVARE' AND anno_scolastico = '2017-2018'";

								$connect = connectDB();
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

						?>

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
					<p class="mail_black" style="">
  						<strong><br/>GESTIONE ANAGRAFICA</strong>
  					</p>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="users/archive.php" class="text-decoration-none">
								<i class="fas fa-users fa-3x"></i>
								<p class="description_ico">Utenti</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="docenti/archive.php" class="text-decoration-none">
								<i class="fas fa-user-tie fa-3x"></i>
								<p class="description_ico">Docenti</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="alunni/archive.php" class="text-decoration-none">
								<i class="fas fa-user-graduate fa-3x"></i>
								<p class="description_ico">Alunni</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="materie/archive.php" class="text-decoration-none">
								<i class="fas fa-book fa-3x"></i>
								<p class="description_ico">Materie</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="classi/archive.php" class="text-decoration-none">
								<i class="fas fa-school fa-3x"></i>
								<p class="description_ico">Classi</p>
							</a>
            </div>



            <p class="mail_black" style="top: 95px;position:relative;">
  						<strong><br/>GESTIONE TRAGUARDI E OBIETTIVI</strong>
  					</p>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="competenze/archive_competenze.php" class="text-decoration-none">
								<i class="fas fa-chart-line fa-3x"></i>
								<p class="description_ico">Traguardi Nazionali</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="obiettivi/archive_obiettivi.php" class="text-decoration-none">
								<i class="fas fa-bullseye fa-3x"></i>
								<p class="description_ico">Obiettivi Nazionali</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="obiettivi_istituto/archivio_obiettivi_istituto.php" class="text-decoration-none">
								<i class="fas fa-bullseye fa-3x"></i>
								<p class="description_ico">Obiettivi di Istituto</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="obiettivi_faro/archivio_obiettivi_faro.php" class="text-decoration-none">
								<i class="fas fa-bullseye fa-3x"></i>
								<p class="description_ico">Obiettivi Faro</p>
							</a>
            </div>
			<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="certificazione_competenze/lista_profili.php" class="text-decoration-none">
								<i class="fas fa-chart-line fa-3x"></i>
								<p class="description_ico">Gestione Profili Certificazione Competenza</p>
							</a>
            </div>

            <p class="mail_black" style="top: 200px;position:relative;">
  						<strong><br/>GESTIONE FONDO DI ISTITUTO</strong>
  					</p>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="incarichi/lista.php" class="text-decoration-none">
								<i class="fas fa-file-signature fa-3x"></i>
								<p class="description_ico">Incarichi</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="carta_docente/lista_categorie_spesa.php" class="text-decoration-none">
								<i class="fas fa-file-signature fa-3x"></i>
								<p class="description_ico">Categorie di Spesa</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="bonus_docente/lista_categorie_bonus.php" class="text-decoration-none">
								<i class="fas fa-file-signature fa-3x"></i>
								<p class="description_ico">Categorie Bonus Premialit&agrave;</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<p class="ico_ico">

              </p>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<p class="ico_ico">

              </p>
            </div>


            <p class="mail_black" style="top: 295px;position:relative;">
  						<strong><br/>GESTIONE SCRUTINI</strong>
  					</p>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="scrutini/archivio_scrutinio.php" class="text-decoration-none">
								<i class="fas fa-balance-scale fa-3x"></i>
								<p class="description_ico">Scrutini</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="scrutini/archivio_scrutinio_doc.php" class="text-decoration-none">
								<i class="fas fa-clipboard-check fa-3x"></i>
								<p class="description_ico">Voti Proposti</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="certificazione_competenze/archivio_certificazioni.php" class="text-decoration-none">
								<i class="fas fa-balance-scale fa-3x"></i>
								<p class="description_ico">Scrutini Certificazione Competenza</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<p class="ico_ico">

              </p>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<p class="ico_ico">

              </p>
            </div>


            <p class="mail_black" style="top: 390px;position:relative;">
  						<strong><br/>REPORT</strong>
  					</p>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="incarichi/archivio_report.php" class="text-decoration-none">
								<i class="fas fa-archive fa-3x"></i>
								<p class="description_ico">Incarichi</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="programmazione/lista_programmazioni.php" class="text-decoration-none">
								<i class="fas fa-archive fa-3x"></i>
								<p class="description_ico">Programmazioni</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="relazione_finale/lista_relazioni.php" class="text-decoration-none">
								<i class="fas fa-archive fa-3x"></i>
								<p class="description_ico">Relazioni Finali</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="certificazione_competenze/report_certificazione.php" class="text-decoration-none">
								<i class="fas fa-archive fa-3x"></i>
								<p class="description_ico">Certificazioni Competenza</p>
							</a>
            </div>
            <div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="bonus_docente/archivio_report.php" class="text-decoration-none">
								<i class="fas fa-archive fa-3x"></i>
								<p class="description_ico">Bonus Premialit&agrave;</p>
							</a>
            </div>
			

			<p class="mail_black" style="top: 475px;position:relative;">
				<strong><br/>DSA</strong>
  			</p>
			<div class="col-6 col-md-4 col-lg-2 text-center mb-4">
							<a target="blank" href="dsa/lista_competenze.php" class="text-decoration-none">
								<i class="fas fa-file-signature fa-3x"></i>
								<p class="description_ico">Gestione Competenze DSA</p>
							</a>
			</div>

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
	<div class="footer" style="margin-top:200pt">
		<div class="clear"></div>
		<div id="copyright"><?php echo $footer;?></div>
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
