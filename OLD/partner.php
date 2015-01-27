<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Partner';

$update = 0;
if (isset($_GET['pa'])) {
$update = 1;
}

//
record_set('client',"SELECT * FROM contacts WHERE contact_id = ".$_GET['id']."");
record_set('partner',"SELECT * FROM partner WHERE partner_name = -1");
if ($update==1) {
record_set('partner',"SELECT * FROM partner WHERE partner_id = ".$_GET['pa']."");
}
//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer &&!$user_administrator && $update) {
$cid = $_GET['id'];
	$redirect = "client-details.php?id=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//


//add Partner
if (!$update && $_POST['partner_name']) {

$partnerdob = strtotime($_POST['dobyear'] . '-' . $_POST['dobmonth'] . '-' . $_POST['dobday']);

if ($_POST['same_address']) {
$street = $row_client['contact_street'];
$city = $row_client['contact_city'];
$zip = $row_client['contact_zip'];
$country = $row_client['contact_country'];
}
else {
$street = insert('partner_street');
$city = insert('partner_city');
$zip = insert('partner_zip');
$country = insert('partner_country');
}


  sqlsrv_query($connection,"INSERT INTO partner (partner_name, partner_relationship, partner_dob, partner_marital, partner_ni, partner_smoker, partner_street, partner_city, partner_zip, partner_country, partner_contact) VALUES 

	(
		'".insert('partner_name')."',
		'".insert('partner_relationship')."',
		'".$partnerdob."',
		'".insert('partner_marital')."',
		'".insert('partner_ni')."',
		'".insert('partner_smoker')."',
		'".$street."',
		'".$city."',
		'".$zip."',
		'".$country."',
		'".$_GET['id']."'
	)

	");

$cid = $_GET['id'];

	sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");

	$redirect = "client-details.php?id=$cid";
	redirect('Partner Added',$redirect);
}
//end add partner

//update partner


if ($update && $_POST &&  $_POST['partner_name']) {

$partnerdob = strtotime($_POST['dobyear'] . '-' . $_POST['dobmonth'] . '-' . $_POST['dobday']);

if ($_POST['same_address']) {
$street = $row_client['contact_street'];
$city = $row_client['contact_city'];
$zip = $row_client['contact_zip'];
$country = $row_client['contact_country'];
}
else {
$street = insert('partner_street');
$city = insert('partner_city');
$zip = insert('partner_zip');
$country = insert('partner_country');
}

sqlsrv_query($connection,"UPDATE partner SET

	partner_name = '".insert('partner_name')."',
	partner_relationship = '".insert('partner_relationship')."',
	partner_dob = '".$partnerdob."',
	partner_marital = '".insert('partner_marital')."',
	partner_ni = '".insert('partner_ni')."',
	partner_smoker = '".insert('partner_smoker')."',
	partner_street = '".$street."',
	partner_city = '".$city."',
	partner_zip = '".$zip."',
	partner_country = '".$country."'

WHERE partner_id = ".$_GET['pa']."
");
	$pid = $_GET['id'];

//
	sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");

	$cid = $_GET['id'];
	$redirect = "client-details.php?id=$cid";

	redirect('Partner Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Partner"; } ?></title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>
<script language="javascript">
function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
style2.display = style2.display? "":"block";
}
}
</script>


<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Partner 
	
	<?php if ($update==1) { ?>
	<?php if ($user_admin) { ?><a style="font-size:12px; font-weight:normal" href="delete.php?partner=<?php echo $row_partner['partner_id'] . "&ref=" . $row_partner['partner_name']; ?>&id=<?php echo $_GET['id']; ?>" onclick="javascript:return confirm('Are you sure?')">+ Delete partner </a><?php } ?>
    <?php } ?>
	</h2>
	<p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td>Name<br/>
                    <input name="partner_name" type="text" id="partner_name" value="<?php echo $row_partner['partner_name']; ?>" size="45" /></td>
        </tr>
		
		<tr>
		<td>Relationship<br/>
                    <input name="partner_relationship" type="text" id="partner_relationship" value="<?php echo $row_partner['partner_relationship']; ?>" size="45" /></td>
        </tr>
		<tr>
		<td>Date of Birth<br/>
		<?php if ($update==1) { 
		$date = $row_partner['partner_dob'];
		echo date_picker("dob", $date);	
		}  
		else {
		echo date_picker("dob");
		}
		?>
		</td>
		</tr>
			  <tr>
                <td>National Insurance <br />
                    <input name="partner_ni" type="text" id="partner_ni" value="<?php echo $row_partner['partner_ni']; ?>" size="35" /></td>
              </tr>
			  <tr>
				<td>Do they Smoke? <br />
                        <select id="partner_smoker" name="partner_smoker">
						<option value="">Choose an option...</option>
						<?php foreach ($smoker as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_partner['partner_smoker']); ?>><?php echo $value; ?></option>
						<?php } ?>
				</select></td>
			  </tr>
			  <tr>
				<td>Marital Status <br />
                        <select id="partner_marital" name="partner_marital">
						<option value="">Choose an option...</option>
						<?php foreach ($marital_status as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_partner['partner_marital']); ?>><?php echo $value; ?></option>
						<?php } ?>
				</select></td>
			  </tr>
		</table>
		<br/>Tick to copy address from partner: <input type="checkbox" name="same_address" value="1" onclick="new Effect.toggle('address', 'slide');"/>
		<div id="address">	  
		<table  width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td>Street<br />
                    <input name="partner_street" type="text" id="partner_street" value="<?php echo $row_partner['partner_street']; ?>" size="35" /></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3">Country<br />
                        <select id="partner_country" name="partner_country">
                      <option value="">Select a Country...</option>
<?php foreach ($country_list as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php selected($key,$row_partner['partner_country']); ?>><?php echo $value; ?></option>
<?php } ?>

       
                        </select></td>
                      </tr>
                    <tr>
                      <td width="39%">City<br />
                          <input name="partner_city" type="text" id="partner_city" value="<?php echo $row_partner['partner_city']; ?>" size="35" /></td>
                      <td width="27%" valign="top"></td>
                      <td width="34%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Postal Code <br />
                    <input name="partner_zip" type="text" id="partner_zip" value="<?php echo $row_partner['partner_zip']; ?>" size="10" /></td>
              </tr>
                </table>
				</div>
		<table>
		<tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> Partner" />
          </p></td>
        </tr>
      </table>
    </form>

<script type="text/javascript">
	var valid2 = new Validation('form1', {useTitles:true});
</script>

  </div>
  <?php include('includes/right-column.php'); ?>

  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>