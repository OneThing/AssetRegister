<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'AssetDetails';

$updatenote = 0;
if (isset($_GET['note'])) {
$updatenote = 1;
}
//asset


record_set('assetlist',"SELECT * FROM assets JOIN devices ON asset_device = device_id JOIN scotusers ON scotuser_id = asset_user JOIN status on status_id = asset_status WHERE asset_id = '".$_GET['id']."'");
record_set('noteuserdetails',"SELECT asset_user FROM assets WHERE asset_id = '".$_GET['id']."'");
record_set('notestatuslist',"SELECT * FROM status ORDER BY status_name");
record_set('noteuserlist',"SELECT * FROM scotusers ORDER BY scotuser_name");
record_set('itsetup',"SELECT user_name FROM assets JOIN users ON user_id = asset_setup WHERE asset_id = '".$_GET['id']."'");
record_set('itchecked',"SELECT user_name FROM assets JOIN users ON user_id = asset_checked WHERE asset_id = '".$_GET['id']."'");
record_set('assetsim',"SELECT * FROM sims JOIN devices ON device_id = sim_device WHERE sim_asset = '".$_GET['id']."'");
record_set('simlist',"SELECT * FROM sims JOIN devices ON device_id = sim_device WHERE sim_asset IS NULL");

//notes
record_set('notes',"SELECT * FROM notes JOIN status on status_id = note_status JOIN users on user_id = note_user JOIN scotusers ON scotuser_id = note_scotuser WHERE note_asset = '".$_GET['id']."' ORDER BY note_date DESC");

record_set('note',"SELECT * FROM notes WHERE note_id = -1");
if ($updatenote==1) {
record_set('note',"SELECT * FROM notes WHERE note_id = ".$_GET['note']."");
}


$noteuser = $row_noteuserdetails['asset_user'];
if ($_POST['noteuser']) {
$noteuser = $_POST['noteuser'];
}

//INSERT NOTE FOR CONTACT
if ($updatenote==0 && !empty($_POST['note_text'])) {
	sqlsrv_query($connection,"INSERT INTO notes (note_asset, note_text, note_date, note_user, note_status, note_scotuser ) VALUES 
		(
		".$row_assetlist['asset_id'].",
		'".addslashes($_POST['note_text'])."',
		".time().",
		'".$userid."',
		'".insert('notestatus')."',
		'".$noteuser."'
		)
	");
	
	if ($_POST['notestatus'] > 0) {
	sqlsrv_query($connection,"UPDATE assets SET

	asset_status = '".insert('notestatus')."'
	
WHERE asset_id = ".$_GET['id']."
");
	}
	
	if ($_POST['noteuser'] > 0) {
	sqlsrv_query($connection,"UPDATE assets SET

	asset_user = '".$noteuser."'
	
WHERE asset_id = ".$_GET['id']."
");
	}
	$goto = "asset-details.php?id=$_GET[id]";
	redirect('Note Added',$goto);
}
//

//UPDATE NOTE
if ($updatenote==1 && !empty($_POST['note_text'])) {
	sqlsrv_query($connection,"UPDATE notes SET 
		note_text = '".addslashes($_POST['note_text'])."' 
	WHERE note_id = ".$_GET['note']."");

	$goto = "asset-details.php?id=$_GET[id]";
	redirect('Note Updated',$goto);
}
//

//UPDATE SIM

// add SIM
if ($_POST['SubmitSIM']) {

sqlsrv_query($connection,"UPDATE sims SET

	sim_asset = '".$_GET[id]."'

WHERE sim_id = ".$_POST['simcard']."
");
record_set('siminfo',"SELECT * FROM sims JOIN devices ON device_id = sim_device WHERE sim_id = ".$_POST['simcard']."");
sqlsrv_query($connection,"INSERT INTO notes (note_asset, note_text, note_date, note_user, note_status, note_scotuser ) VALUES 
		(
		".$row_assetlist['asset_id'].",
		'".addslashes("SIM Card ref: ". $row_siminfo['device_name'] . ' - ' . $row_siminfo['sim_model'] . ' - ' . $row_siminfo['sim_mobile'] . ' - ' . $row_siminfo['sim_number'].", added to device")."',
		".time().",
		'".$userid."',
		'".insert('notestatus')."',
		'".$noteuser."'
		)
	");

	$sid = $_GET['id'];
	$redirect = "asset-details.php?id=$sid";

	redirect('SIM Assigned',$redirect);
}

// Remove SIM
if ($_POST['removeSIM']) {

sqlsrv_query($connection,"UPDATE sims SET

	sim_asset = NULL

WHERE sim_asset = ".$_GET['id']."
");
	update_history('SIM Card','UN-ASSIGN', $_GET['id'],'', $userid, 'Asset ID: '.$_GET[id]);
	$sid = $_GET['id'];
	$redirect = "asset-details.php?id=$sid";

	redirect('SIM Un-assigned',$redirect);
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $row_userdetails['scotuser_name']; ?></title>

<script src="includes/src/unittest.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">

    <?php display_msg(); ?>

<div style="display:block; margin-bottom:5px">


<h2><?php echo $row_assetlist['asset_model'] . '</h2><h3>&nbsp&nbsp' . $row_assetlist['device_name'] . ' - ' . $row_assetlist['asset_serial']; ?><?php if ($user_admin) { ?><a style="font-size:12px; font-weight:normal" href="asset.php?id=<?php echo $row_assetlist['asset_id']; ?>">&nbsp;&nbsp;+ Edit Asset </a><?php } ?></h3>
<br clear="all" />


</div>
	
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
			<td><strong>Device:</strong><br />
			<?php echo $row_assetlist['device_name']; ?>
			</td><td>
			<strong>Model:</strong><br />
			<?php echo $row_assetlist['asset_model']; ?>
			</td><td>
			<strong>Serial:</strong><br />
            <?php echo $row_assetlist['asset_serial']; ?>
			</td><td>
		    <strong>Tag:</strong><br />
            <?php echo $row_assetlist['asset_tag']; ?>
			</td><td>
        </tr>
		<tr>
		<td><strong>Assigned User</strong><br />
			<?php echo $row_assetlist['scotuser_name']; ?></option>
		</td>
		<td><strong>Asset Status</strong><br />
			<?php echo $row_assetlist['status_name']; ?></option>
		</td>
		<td><strong>Setup by</strong><br />
			<?php echo $row_itsetup['user_name']; ?>
		</td>
				<td><strong>Checked by</strong><br />
			<?php echo $row_itchecked['user_name']; ?>
		</td>
        </tr>
		<tr>
		<td><strong>Issued Date</strong><br />
			<?php echo date('F d, Y', $row_assetlist['asset_issued']);?>
		</td>
		<td><strong>Purchased Date</strong><br />
			<?php echo date('F d, Y', $row_assetlist['asset_purchased']);?>
		</td>
		<td><strong>Support Date</strong><br />
			<?php echo date('F d, Y', $row_assetlist['asset_support']);?>
		</td>
		<td><strong>Warranty Date</strong><br />
			<?php echo date('F d, Y', $row_assetlist['asset_warranty']);?>
		</td>
		
        </tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            
          </p></td>
        </tr>
      </table>
	  
	  <?php if (!$totalRows_assetsim > 0){ ?>
	   Add a SIM Card.
	   <form action="" method="POST" enctype="multipart/form-data" name="form2" id="form2">
	   <select id="simcard" name="simcard">
			<option value="0">Select SIM Card...</option>
			<?php do { ?>
				<option value="<?php echo $row_simlist['sim_id']; ?>">
				<?php echo $row_simlist['device_name'] . ' - ' . $row_simlist['sim_model'] . ' - ' . $row_simlist['sim_mobile'] . ' - ' . $row_simlist['sim_number']; ?></option>
			<?php } while ($row_simlist = sqlsrv_fetch_array($simlist)); ?>
			</select>
			<input type="submit" name="SubmitSIM" value="Assign SIM" />
			</form>
	   </br><br/>
	  <?php }?>
	  
	<?php if ($totalRows_assetsim > 0) { ?>
	  <hr />
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		<tr><h5>Associated SIM Cards<h5><br/>
		</tr>
		<?php do { ?>
        <tr>
			<td><strong>Device:</strong><br />
			<?php echo $row_assetsim['device_name']; ?>
			</td><td>
			<strong>Model:</strong><br />
			<?php echo $row_assetsim['sim_model']; ?>
			</td><td>
			<strong>Mobile No.:</strong><br />
            <?php echo $row_assetsim['sim_mobile']; ?>
			</td><td>
		    <strong>SIM Number:</strong><br />
            <?php echo $row_assetsim['sim_number']; ?>
			</td><td>
        </tr>
		<?php } while ($row_assetsim = sqlsrv_fetch_array($assetsim)); ?>
	  </table>
	  <form action="" method="POST" enctype="multipart/form-data" name="form3" id="form3">
	  <input type="submit" name="removeSIM" value="Un-Assign SIM" />
	  </form>
	  <hr/><br/>
	<?php } ?>  
	  
	<?php if ($_GET['id']) { ?>
	
	<?php if (!$updatenote) { echo "Add a new note <br>"; } ?>

<form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
<textarea name="note_text" style="width:60% "rows="3" id="note_text"><?php echo $row_note['note_text']; ?></textarea>
			<br /><select id="notestatus" name="notestatus">
			<option value="0">Update Status?</option>
			<?php do { ?>
				<option value="<?php echo $row_notestatuslist['status_id']; ?>">
				<?php echo $row_notestatuslist['status_name']; ?></option>
			<?php } while ($row_notestatuslist = sqlsrv_fetch_array($notestatuslist)); ?>
			</select>
			<select id="noteuser" name="noteuser">
			<option value="0">Update User?</option>
			<?php do { ?>
				<option value="<?php echo $row_noteuserlist['scotuser_id']; ?>">
				<?php echo $row_noteuserlist['scotuser_name']; ?></option>
			<?php } while ($row_noteuserlist = sqlsrv_fetch_array($noteuserlist)); ?>
			</select>
		</td>
        <br /><br/>
<input type="submit" name="Submit2" value="<?php if ($updatenote==1) { echo 'Update'; } else { echo 'Add'; } ?> note" />
</form>
<br/>
      <?php if ($updatenote==1) { ?>  <a href="delete.php?note=<?php echo $row_note['note_id']; ?>&amp;id=<?php echo $row_note['note_asset']; ?>" onclick="javascript:return confirm('Are you sure you want to delete this note?')">Delete Note</a><?php } ?>
<?php if ($totalRows_notes > 0) { ?>
        <hr />
        <?php do { ?>
<div <?php if ($row_notes['note_date'] > time()-1) { ?>id="newnote"<?php } ?>>
        <span class="datedisplay"><a href="?id=<?php echo $row_assetlist['asset_id']; ?>&note=<?php echo $row_notes['note_id']; ?>"><?php echo date('F d, Y - g:i', $row_notes['note_date']); ?></a></span><em>&nbspLast edited by: <?php echo $row_notes['user_name'];?></em><br />
          <?php echo "User: <Strong>" . $row_notes['scotuser_name'] . "</Strong> - " . "Status: <Strong>" . $row_notes['status_name'] . "</Strong> - <em>" . $row_notes['note_text'] . "</em>"; ?>
</div>
          <hr />
              <?php } while ($row_notes = sqlsrv_fetch_array($notes)); ?>

<?php } ?>
<?php } ?>
          <td colspan="2">
</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
