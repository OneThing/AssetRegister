<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'AssetDetails';


$update = 0;
if (isset($_GET['id'])) {
$update = 1;
}

//asset

record_set('devicelist',"SELECT * FROM devices ORDER BY device_name");
record_set('userlist',"SELECT * FROM scotusers ORDER BY scotuser_name");
record_set('statuslist',"SELECT * FROM status ORDER BY status_name");
record_set('itcheckedlist',"SELECT * FROM users ORDER BY user_name");
record_set('itsetuplist',"SELECT * FROM users ORDER BY user_name");
record_set('simlist',"SELECT * FROM sims JOIN devices ON device_id = sim_device ORDER BY sim_number");

if ($update==1) {
record_set('assetlist',"SELECT * FROM assets JOIN devices ON asset_device = device_id WHERE asset_id = '".$_GET['id']."'");
}


//add asset
if (!$update && $_POST['asset_serial']) {

$issueddate = strtotime($_POST['issuedyear'] . '-' . $_POST['issuedmonth'] . '-' . $_POST['issuedday']);
$purchaseddate = strtotime($_POST['purchasedyear'] . '-' . $_POST['purchasedmonth'] . '-' . $_POST['purchasedday']);
$supportdate = strtotime($_POST['supportyear'] . '-' . $_POST['supportmonth'] . '-' . $_POST['supportday']);
$warrantydate = strtotime($_POST['warrantyyear'] . '-' . $_POST['warrantymonth'] . '-' . $_POST['warrantyday']);

  sqlsrv_query($connection,"INSERT INTO assets (asset_user, asset_device, asset_model, asset_serial, asset_tag, asset_setup, asset_checked, asset_issued, asset_status, asset_purchased, asset_support, asset_warranty) VALUES 

	(
		'".insert('user')."',
		'".insert('device')."',
		'".insert('model')."',
		'".insert('asset_serial')."',
		'".insert('tag')."',
		'".insert('setup')."',
		'".insert('checked')."',
		'".$issueddate."',
		'".insert('status')."',
		'".$purchaseddate."',
		'".$supportdate."',
		'".$warrantydate."'
	)

	");

$aid = mysql_insert_id();

	$redirect = "asset.php?id=$aid";
	redirect('Asset Added',$redirect);
}
//end add asset

// edit asset
if ($update && $_POST &&  $_POST['asset_serial']) {

$issueddate = strtotime($_POST['issuedyear'] . '-' . $_POST['issuedmonth'] . '-' . $_POST['issuedday']);
$purchaseddate = strtotime($_POST['purchasedyear'] . '-' . $_POST['purchasedmonth'] . '-' . $_POST['purchasedday']);
$supportdate = strtotime($_POST['supportyear'] . '-' . $_POST['supportmonth'] . '-' . $_POST['supportday']);
$warrantydate = strtotime($_POST['warrantyyear'] . '-' . $_POST['warrantymonth'] . '-' . $_POST['warrantyday']);

sqlsrv_query($connection,"UPDATE assets SET

	asset_user = '".insert('user')."',
	asset_device = '".insert('device')."',
	asset_model = '".insert('model')."',
	asset_serial = '".insert('asset_serial')."',
	asset_tag = '".insert('tag')."',
	asset_setup = '".insert('setup')."',
	asset_checked = '".insert('checked')."',
	asset_issued = '".$issueddate."',
	asset_status = '".insert('status')."',
	asset_purchased = '".$purchaseddate."',
	asset_support = '".$supportdate."',
	asset_warranty = '".$warrantydate."'
	
WHERE asset_id = ".$_GET['id']."
");

	$aid = $_GET['id'];
	$redirect = "asset.php?id=$aid";

	redirect('Asset Updated',$redirect);
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


<h2><?php echo $row_assetlist['asset_model'] . '</h2><h3>&nbsp&nbsp' . $row_assetlist['device_name'] . ' - ' . $row_assetlist['asset_serial']; ?></h3>
<br clear="all" />


</div>
	
	<form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
		<td>Device<br />
			<select id="device" name="device">
			<option value="0">Select a Device Type...</option>
			<?php do { ?>
				<option value="<?php echo $row_devicelist['device_id']; ?>" <?php selected ($row_assetlist['asset_device'],$row_devicelist['device_id']); ?>>
				<?php echo $row_devicelist['device_name']; ?></option>
			<?php } while ($row_devicelist = sqlsrv_fetch_array($devicelist)); ?>
		</select>
			</td>
		<td>Model<br />
		<input name="model" type="text" id="model" value="<?php echo $row_assetlist['asset_model']; ?>" size="35" /></td>
		  <td>Serial<br />
            <input name="asset_serial" type="text" id="asset_serial" value="<?php echo $row_assetlist['asset_serial']; ?>" size="35" /></td>
		  <td>Tag<br />
             <input name="tag" type="text" id="tag" value="<?php echo $row_assetlist['asset_tag']; ?>" size="35" /></td>
            </p></td>
        </tr>
		<tr>
		<td>Assigned User<br />
			<select id="user" name="user">
			<option value="0">Select a User...</option>
			<?php do { ?>
				<option value="<?php echo $row_userlist['scotuser_id']; ?>" <?php selected ($row_assetlist['asset_user'],$row_userlist['scotuser_id']); ?>>
				<?php echo $row_userlist['scotuser_name']; ?></option>
			<?php } while ($row_userlist = sqlsrv_fetch_array($userlist)); ?>
			</select>
		</td>
		<td>Asset Status<br />
			<select id="status" name="status">
			<option value="0">Select a Status...</option>
			<?php do { ?>
				<option value="<?php echo $row_statuslist['status_id']; ?>" <?php selected ($row_assetlist['asset_status'],$row_statuslist['status_id']); ?>>
				<?php echo $row_statuslist['status_name']; ?></option>
			<?php } while ($row_statuslist = sqlsrv_fetch_array($statuslist)); ?>
			</select>
		</td>
		<td>Setup by<br />
			<select id="setup" name="setup">
			<option value="0">Select an IT Person...</option>
			<?php do { ?>
				<option value="<?php echo $row_itsetuplist['user_id']; ?>" <?php selected ($row_assetlist['asset_setup'],$row_itsetuplist['user_id']); ?>>
				<?php echo $row_itsetuplist['user_name']; ?></option>
			<?php } while ($row_itsetuplist = sqlsrv_fetch_array($itsetuplist)); ?>
			</select>
		</td>
		<td>Checked by<br />
			<select id="checked" name="checked">
			<option value="0">Select an IT Person...</option>
			<?php do { ?>
				<option value="<?php echo $row_itcheckedlist['user_id']; ?>" <?php selected ($row_assetlist['asset_checked'],$row_itcheckedlist['user_id']); ?>>
				<?php echo $row_itcheckedlist['user_name']; ?></option>
			<?php } while ($row_itcheckedlist = sqlsrv_fetch_array($itcheckedlist)); ?>
			</select>
		</td>
        </tr>
		<tr>
		<td>Issued Date<br />
			<?php if ($update==1) { 
			$date = $row_assetlist['asset_issued'];
			echo date_picker("issued", $date);	
			}  
			else {
			echo date_picker("issued");
			}
			?>
		</td>
		<td>Purchased Date<br />
			<?php if ($update==1) { 
			$date = $row_assetlist['asset_purchased'];
			echo date_picker("purchased", $date);	
			}  
			else {
			echo date_picker("purchased");
			}
			?>
		</td>
		<td>Support Date<br />
			<?php if ($update==1) { 
			$date = $row_assetlist['asset_support'];
			echo date_picker("support", $date);	
			}  
			else {
			echo date_picker("support");
			}
			?>
		</td>
		<td>Warranty Date<br />
			<?php if ($update==1) { 
			$date = $row_assetlist['asset_warranty'];
			echo date_picker("warranty", $date);	
			}  
			else {
			echo date_picker("warranty");
			}
			?>
		</td>
        </tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> asset" />
          </p></td>
        </tr>
      </table>
    </form>
          <td colspan="2">
</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
