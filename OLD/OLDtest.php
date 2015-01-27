<?php require_once('includes/config.php'); 
include('includes/sc-includes.php');
$pagetitle = 'Contact';

//restrict if not admin
if (!$user_admin) {
header('Location: contacts.php'); die;
}
//

//
record_set('investments',"SELECT * FROM investments WHERE inv_policy = ".$_GET['p']." ORDER BY inv_date ASC");
//

if ($_POST) {

foreach ($_POST['investmentvalue'] as $key => $value) {
if ($value) {
$value = addslashes($value);
$date = strtotime($_POST['investmentdate'][$key]);
$date = str_replace('/', '-', $date);

sqlsrv_query($connection,"UPDATE investments SET 
	inv_value = '".$value."',
	inv_date = '".$date."',
	inv_type = '".addslashes($_POST['investmenttype'][$key])."',
	inv_frequency = '".addslashes($_POST['investmentfreq'][$key])."'
WHERE inv_id = ".$key."");
}
}


//add new field

$invdate = strtotime($_POST['invyear'] . '-' . $_POST['invmonth'] . '-' . $_POST['invday']);
if ($_POST['inv_value']) {
sqlsrv_query($connection,"INSERT INTO investments (inv_value, inv_date, inv_type, inv_frequency, inv_policy) VALUES 
	(
		'".insert('inv_value')."',
		'".$invdate."',
		'".insert('inv_type')."',
		'".insert('inv_frequency')."',
		'".$_GET['p']."'

	)
");
}

redirect('Investment added.','test.php?p=30');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Custom Fields</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2>Custom Fields </h2>
    <?php display_msg(); ?>    


    <form id="form1" name="form1" method="post" action="">

    <table width="100%" border="0" cellspacing="0" cellpadding="3">
		  <tr>
		  <td>
		  Investment Value <br />
          <input name="inv_value" id="inv_value" size="35"  />
		  </td>
		  </tr>
		  <tr>
          <td>
          Date <br />
          <?php echo date_picker("inv"); ?>
          </td>
		  </tr>
		  <tr>
		  <td>Investment Type<br />
                        <select id="inv_type" name="inv_type">
						<option value="">Select a Investment Type...</option>
						<?php foreach ($invest_list as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		  </tr>
		  <tr>
		  		  <td>Investment Frequency<br />
                        <select id="inv_frequency" name="inv_frequency">
						<option value="">Select a Frequency...</option>
						<?php foreach ($invest_freq as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		</tr>
		<tr><td/>
          <input name="Submit22" type="submit" id="Submit22" value="Add" />
          </td></tr>
		  </table>
		  <br/>
		  <hr/>
		  
	<?php if ($row_investments['inv_id']) { ?>
		  <table>
		<tr>
		<th>Value</th>
		<th>Date</th>
		<th>Type</th>
		<th>Frequency</th>
		</tr>
		<?php do { ?>
	<tr>
		<td><input name="investmentvalue[<?php echo $row_investments['inv_id']; ?>]" id="investmentvalue[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo $row_investments['inv_value']; ?>" size="15" /></td>
		<td><input name="investmentdate[<?php echo $row_investments['inv_id']; ?>]" id="investmentdate[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo date('d/m/Y', $row_investments['inv_date']); ?>" size="15" /></td>
		<td><input name="investmenttype[<?php echo $row_investments['inv_id']; ?>]" id="investmenttype[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo $row_investments['inv_type']; ?>" size="15" /></td>
		<td><input name="investmentfreq[<?php echo $row_investments['inv_id']; ?>]" id="investmentfreq[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo $row_investments['inv_frequency']; ?>" size="15" /></td>
	</tr>
	<?php } while ($row_investments = sqlsrv_fetch_array($investments)); ?>
	
		<tr><td/>
        <input name="Submit2" type="submit" id="Submit2" value="Update" /> 
		</td></tr>
		    </table>
	<?php } ?>

      </p>
    </form>
    
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
