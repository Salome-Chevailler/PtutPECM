<!-- Permet de se connecter à la base de données Microsoft SQL Server -->

<?php
$serverName = "LAPTOP-RCTMJQ1M\SQLEXPRESS"; //serverName\instanceName\Salomé
 //$serverName = "DESKTOP-OJ289NC\SQLEXPRESS"; //Séraphie
// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"master");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

/*if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}*/

?>
