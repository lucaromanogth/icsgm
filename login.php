<?php
session_start();

include_once("set/lib.php");
include_once("set/verifica_login.php");

$dominio = getDominio();
$nome_ics = getNomeICS();

$array_s_login = $_SESSION["S_LOGIN"];
$login = $_POST['login'];
$password = $_POST['password'];
$mem_username = $_POST['mem_username'];

if ( (!isset($login) || (empty($login))) && (!isset($password) || (empty($password))) ) {
   // FORM VUOTO - NON SETTATO
   session_destroy();
   header("Location: index.php");
   exit;

} else if ( (!empty($login)) && (!isset($password) || (empty($password))) ) {

   $_SESSION["S_ERR_LOGIN"] = "Nome Utente e/o Password errati. Riprovare!<br><br>";
   header("Location: index.php");
   exit;

} else {

   $user_l = Verifica_Login($login, $password);
   //var_dump($user_l);
   //exit;

   if ($user_l) {
       // L'UTENTE ESISTE.

      if (empty($user_l['error_msg']))
	  {
          // AVANTI
          $array_s_login = $user_l;

          $_SESSION["S_LOGIN"] = $array_s_login;

         /* if ( isset($mem_username) && (strtoupper($mem_username)=="ON") )
          {
            $durata = time()+60*60*24*180; // 6 mesi
            setcookie($dominio,"ON",$durata,"/");
            setcookie("mem_user_".$dominio,"ON",$durata,"/");
            setcookie("user_".$dominio,$login,$durata,"/");
          }
          else
          {
            $durata = time()-3600; // per farlo scadere subito
            setcookie($dominio,"OFF",$durata,"/");
            setcookie("mem_user_".$dominio,"OFF",$durata,"/");
            setcookie("user_".$dominio,"",$durata,"/");
          }
          */
		    header("Location: home.php");
		    exit;
     }
	   else
	   {
          // ERRORE!
          $_SESSION["S_ERR_LOGIN"] = $user_l['error_msg'];
          header("Location: index.php");
          exit;
     }

   }
   else
   {
       // L'UTENTE NON ESISTE
       $_SESSION["S_ERR_LOGIN"] = "Nome Utente e/o Password errati. Riprovare!<br><br>";
       header("Location: index.php");
       exit;
   }
}
?>
