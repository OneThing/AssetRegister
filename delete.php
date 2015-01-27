<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');

//DELETE NOTE
if (isset($_GET['note'])) {
sqlsrv_query($connection,"DELETE FROM notes WHERE note_id = ".$_GET['note']."");
$redirect = "asset-details.php?id=$_GET[id]";
update_history('Asset Note','DELETE', $_GET['note'], 'Note ID: ' . $_GET['note'], $userid, 'Asset ID: '.$_GET[id]);
redirect('Note Deleted',$redirect);
}
//

//DELETE USER
if (isset($_GET['user'])) {
sqlsrv_query($connection,"DELETE FROM users WHERE user_id = ".$_GET['user']."");
$redirect = 'admin.php';
update_history('User', 'DELETE', $_GET['user'], $_GET['ref'], $userid);
redirect('User Deleted',$redirect);
}
//

?>