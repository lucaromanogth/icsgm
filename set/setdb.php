<?php

////////////////////////////
// APRE CONNESSIONE AL DB //
////////////////////////////

function getSchemaName() {
	return "DATABASE";
}

function connectDB()
{
	$conn = mysqli_connect("127.0.0.1", "user", "password", "DB_NAME");
	$conn->set_charset('utf8');
	return $conn;
}

//////////////////////////
//        ERRORE        //
//////////////////////////

function ErroreDB(){

     echo "<p> Si sono verificati dei problemi. </p>";
     echo "<p> Ci scusiamo per l'inconveniente e vi preghiamo di provare pi&ugrave; tardi. </p>";
     echo "<p> Se il problema persiste contattare web.supporto@icsguidomonaco.it </p>";
     exit();

}

//////////////////////////////
// CHIUDE CONNESSIONE AL DB //
//////////////////////////////

function disconnectDB($conn) {
	unset($conn);
	//mysqli_close($conn);
}

function executeQuery($query, $types = "", ...$params)
{
    $connect = connectDB();
    $stmt = mysqli_prepare($connect, $query);
    if ($types != "" && count($params) > 0) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    disconnectDB($connect);
    return $result;
}

?>
