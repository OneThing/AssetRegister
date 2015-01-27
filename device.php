<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'DeviceDetails';

$update = 0;
if (isset($_GET['device'])) {
$update = 1;
}

if ($update==1) {
record_set('devicedetails',"SELECT * FROM devices WHERE device_id = '".$_GET['device']."'");
}

//add device
if (!$update && $_POST['device']) {


  sqlsrv_query($connection,"INSERT INTO devices (device_name) VALUES 

	(
		'".insert('device')."'
	)

	");

$did = mysql_insert_id();

	$redirect = "device-details.php?device=$did";
	redirect('Device Added',$redirect);
}
//end add device

// edit device
if ($update && $_POST &&  $_POST['device']) {

sqlsrv_query($connection,"UPDATE devices SET

	device_name = '".insert('device')."'
	
WHERE device_id = ".$_GET['device']."
");

	$did = $_GET['device'];
	$redirect = "device-details.php?device=$did";

	redirect('Device Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Device</title>

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

<h2><?php echo $row_devicedetails['device_name'];?></h3>


</div>

     <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
		<td>Device Name<br />
		<input name="device" type="text" id="device" value="<?php echo $row_devicedetails['device_name']; ?>" size="35" /></td>
		</tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> device" />
          </p></td>
        </tr>
      </table>
    </form>

</div>
  <?php include('includes/right-column.php'); ?>
  
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
