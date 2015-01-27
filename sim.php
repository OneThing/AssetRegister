<?php require_once('includes/config.php');
include('includes/sc-includes.php');

$pagetitle = 'SIM CardDetails';

$update = 0;
if (isset($_GET['sim'])) {
$update = 1;
}

//SIM

record_set('devicelist',"SELECT * FROM devices ORDER BY device_name");

if ($update==1) {
record_set('simdetails',"SELECT * FROM sims WHERE sim_id = '".$_GET['sim']."'");
}

//add SIM
if (!$update && $_POST['sim_number']) {


  sqlsrv_query($connection,"INSERT INTO sims (sim_model, sim_device, sim_mobile sim_number) VALUES 

	(
		'".insert('sim_model')."',
		'".insert('sim_device')."',
		'".insert('sim_mobile')."',
		'".insert('sim_number')."'
	)

	");

$sid = mysql_insert_id();

	$redirect = "sims.php?sim=$sid";
	redirect('SIM Added',$redirect);
}
//end add SIM

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SIMS</title>

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

<h2><?php echo $row_simdetails['sim_model'] . '</h2><h3>&nbsp&nbsp' . $row_simdetails['sim_mobile'] . ' - ' . $row_simdetails['sim_number']; ?></h3>


</div>

     <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<hr />
        <tr>
		<td>SIM Model<br />
		<input name="sim_model" type="text" id="sim_model" value="<?php echo $row_simdetails['sim_model']; ?>" size="35" /></td>
		<td>Device<br />
			<select id="sim_device" name="sim_device">
			<option value="0">Select a Device...</option>
			<?php do { ?>
				<option value="<?php echo $row_devicelist['device_id']; ?>" <?php selected ($row_simdetails['sim_device'],$row_devicelist['device_id']); ?>>
				<?php echo $row_devicelist['device_name']; ?></option>
			<?php } while ($row_devicelist = sqlsrv_fetch_array($devicelist)); ?>
			</select>
		</td>
		<td>SIM Mobile Number<br />
		<input name="sim_mobile" type="text" id="sim_mobile" value="<?php echo $row_simdetails['sim_mobile']; ?>" size="35" /></td>
		<td>SIM Serial Number<br />
		<input name="sim_number" type="text" id="sim_number" value="<?php echo $row_simdetails['sim_number']; ?>" size="35" /></td>
		</tr>
		<tr>
          <td colspan="2"><p>
		  <br />
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> SIM Card" />
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
