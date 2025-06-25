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
		<div class="right">
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

					<div id="container">
            <p class="mail_black" style="">
  						<strong><br/>GESTIONE ANAGRAFICA</strong>
  					</p>
            <div class="cella1" style="top: 25px;">
							<p class="ico_ico">
                  <a target="blank" href="users/archive.php"><img src="img/addusers_on.png" alt="Gestione Utenti" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella2" style="top: 25px;">
							<p class="ico_ico">
                <a target="blank" href="docenti/archive.php"><img src="img/docenti_on.png" alt="Gestione Docenti" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella3" style="top: 25px;">
							<p class="ico_ico">
                <a target="blank" href="alunni/archive.php"><img src="img/alunni_on.png" alt="Gestione Alunni" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella4" style="top: 25px;">
							<p class="ico_ico">
                <a target="blank" href="materie/archive.php"><img src="img/materie_on.png" alt="Gestione Materie" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella5" style="top: 25px;">
							<p class="ico_ico">
                <a target="blank" href="classi/archive.php"><img src="img/classi_on.png" alt="Gestione Classi" width="60" height="60"></img></a>
              </p>
            </div>


						<div class="cella1b" style="top: 85px;">
						<p align="center" class="description_ico">Utenti</p>
						</div>
						<div class="cella2b" style="top: 85px;">
						<p align="center" class="description_ico">Docenti</p>
						</div>
						<div class="cella3b" style="top: 85px;">
						<p align="center" class="description_ico">Alunni</p>
						</div>
						<div class="cella4b" style="top: 85px;">
						<p align="center" class="description_ico">Materie</p>
						</div>
						<div class="cella5b" style="top: 85px;">
						<p align="center" class="description_ico">Classi</p>
						</div>



            <p class="mail_black" style="top: 95px;position:relative;">
  						<strong><br/>GESTIONE TRAGUARDI E OBIETTIVI</strong>
  					</p>
            <div class="cella1c" style="top: 145px;">
							<p class="ico_ico">
                  <a target="blank" href="competenze/archive_competenze.php"><img src="img/indicatori_on.png" alt="Traguardi Nazionali" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella2c" style="top: 145px;">
							<p class="ico_ico">
                <a target="blank" href="obiettivi/archive_obiettivi.php"><img src="img/obiettivi_on.png" alt="Obiettivi Nazionali" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella3c" style="top: 145px;">
							<p class="ico_ico">
                <a target="blank" href="obiettivi_istituto/archivio_obiettivi_istituto.php"><img src="img/obiettivi_on.png" alt="Obiettivi di Istituto" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella4c" style="top: 145px;">
							<p class="ico_ico">
							<a target="blank" href="obiettivi_faro/archivio_obiettivi_faro.php"><img src="img/obiettivi_on.png" alt="Obiettivi Faro" width="60" height="60"></img></a>
              </p>
            </div>
			<div class="cella5c" style="top: 145px;">
				<p class="ico_ico">
				<a target="blank" href="certificazione_competenze/lista_profili.php"><img src="img/indicatori_on.png" alt="profili_certificazione_competenza" width="60" height="60"></img></a>
              </p>
            </div>

            <div class="cella1d" style="top: 205px;">
				<p align="center" class="description_ico">Traguardi Nazionali</p>
			</div>
			<div class="cella2d" style="top: 205px;">
				<p align="center" class="description_ico">Obiettivi Nazionali</p>
			</div>
            <div class="cella3d" style="top: 205px;">
				<p align="center" class="description_ico">Obiettivi di Istituto</p>
			</div>
			<div class="cella4d" style="top: 205px;">
				<p align="center" class="description_ico">Obiettivi Faro</p>
			</div>
			<div class="cella5d" style="top: 205px;">
				<p align="center" class="description_ico">Gestione Profili Certificazione Competenza</p>
			</div>

            <p class="mail_black" style="top: 200px;position:relative;">
  						<strong><br/>GESTIONE FONDO DI ISTITUTO</strong>
  					</p>
            <div class="cella1e" style="top: 275px;">
							<p class="ico_ico">
                  <a target="blank" href="incarichi/lista.php"><img src="img/incarichi_on.png" alt="incarichi" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella2e" style="top: 275px;">
							<p class="ico_ico">
                <a target="blank" href="carta_docente/lista_categorie_spesa.php"><img src="img/incarichi_on.png" alt="categorie di spesa" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella3c" style="top: 275px;">
							<p class="ico_ico">
                <a target="blank" href="bonus_docente/lista_categorie_bonus.php"><img src="img/incarichi_on.png" alt="categorie bonus" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella4c" style="top: 275px;">
							<p class="ico_ico">

              </p>
            </div>
            <div class="cella5c" style="top: 275px;">
							<p class="ico_ico">

              </p>
            </div>


            <div class="cella1d" style="top: 335px;">
						<p align="center" class="description_ico">Incarichi</p>
						</div>
						<div class="cella2d" style="top: 335px;">
						<p align="center" class="description_ico">Categorie di Spesa</p>
						</div>
            <div class="cella3d" style="top: 335px;">
              <p align="center" class="description_ico">Categorie Bonus Premialit&agrave;</p>
						</div>



            <p class="mail_black" style="top: 295px;position:relative;">
  						<strong><br/>GESTIONE SCRUTINI</strong>
  					</p>
            <div class="cella1e" style="top: 390px;">
							<p class="ico_ico">
                  <a target="blank" href="scrutini/archivio_scrutinio.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella2e" style="top: 390px;">
							<p class="ico_ico">
                <a target="blank" href="scrutini/archivio_scrutinio_doc.php"><img src="img/scrutini_on.png" alt="scrutini" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella3c" style="top: 390px;">
							<p class="ico_ico">
                <a target="blank" href="certificazione_competenze/archivio_certificazioni.php"><img src="img/scrutini_on.png" alt="archivio_certificazioni" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella4c" style="top: 390px;">
							<p class="ico_ico">

              </p>
            </div>
            <div class="cella5c" style="top: 390px;">
							<p class="ico_ico">

              </p>
            </div>


            <div class="cella1d" style="top: 450px;">
						<p align="center" class="description_ico">Scrutini</p>
						</div>
						<div class="cella2d" style="top: 450px;">
						<p align="center" class="description_ico">Voti Proposti</p>
						</div>

            <div class="cella3d" style="top: 450px;">
            <p align="center" class="description_ico">Scrutini Certificazione Competenza</p>
						</div>


            <p class="mail_black" style="top: 390px;position:relative;">
  						<strong><br/>REPORT</strong>
  					</p>
            <div class="cella1e" style="top: 510px;">
							<p class="ico_ico">
                <a target="blank" href="incarichi/archivio_report.php"><img src="img/archivio_on.png" alt="Report incarichi" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella2e" style="top: 510px;">
							<p class="ico_ico">
                <a target="blank" href="programmazione/lista_programmazioni.php"><img src="img/archivio_on.png" alt="Report programmazioni" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella3c" style="top: 510px;">
							<p class="ico_ico">
                <a target="blank" href="relazione_finale/lista_relazioni.php"><img src="img/archivio_on.png" alt="Report relazioni finali" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella4c" style="top: 510px;">
							<p class="ico_ico">
                <a target="blank" href="certificazione_competenze/report_certificazione.php"><img src="img/archivio_on.png" alt="Report Certificazioni" width="60" height="60"></img></a>
              </p>
            </div>
            <div class="cella5c" style="top: 510px;">
				<p class="ico_ico">
					<a target="blank" href="bonus_docente/archivio_report.php"><img src="img/archivio_on.png" alt="Report Bonus Premialita" width="60" height="60"></img></a>
            	</p>
            </div>


            <div class="cella1d" style="top: 570px;">
						<p align="center" class="description_ico">Incarichi</p>
						</div>
            <div class="cella2d" style="top: 570px;">
						<p align="center" class="description_ico">Programmazioni</p>
						</div>
            <div class="cella3d" style="top: 570px;">
            <p align="center" class="description_ico">Relazioni Finali</p>
						</div>
            <div class="cella4d" style="top: 570px;">
				<p align="center" class="description_ico">Certificazioni Competenza</p>
			</div>
			<div class="cella5d" style="top: 570px;">
				<p align="center" class="description_ico">Bonus Premialit&agrave;</p>
			</div>		
			

			<p class="mail_black" style="top: 475px;position:relative;">
				<strong><br/>DSA</strong>
  			</p>
			<div class="cella1e" style="top: 630px;">
				<p class="ico_ico">
					<a target="blank" href="dsa/lista_competenze.php"><img src="img/incarichi_on.png" alt="Gestione competenze DSA" width="60" height="60"></img></a>
				</p>
			</div>
			<div class="cella1f" style="top: 690px;">
				<p align="center" class="description_ico">Gestione Competenze DSA</p>
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
