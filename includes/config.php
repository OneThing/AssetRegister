<?php

$serverName = "PHOBOS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"AssetRegisterDB", "UID"=>"asset", "PWD"=>"sc0tc@ll");
$connection = sqlsrv_connect( $serverName, $connectionInfo) or trigger_error(sqlsrv_error(),E_USER_ERROR); 

/*mysql connection information
$hostname_contacts = "PHOBOS";  
$database_contacts = "asset"; //The name of the database
$username_contacts = "dbadmin"; //The username for the database
$password_contacts = "2lqx2lqx"; // The password for the database
$contacts = mssql_connect($hostname_contacts, $username_contacts, $password_contacts) or trigger_error(sqlsrv_error(),E_USER_ERROR); 
mssql_select_db($database_contacts, $contacts);

*/

?>