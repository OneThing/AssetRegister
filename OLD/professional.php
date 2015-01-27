<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Professional Contacts';

$update = 0;
if (isset($_GET['pro'])) {
$update = 1;
}

record_set('professional',"SELECT * FROM prof_contacts WHERE prof_name = -1");
if ($update==1) {
record_set('professional',"SELECT * FROM prof_contacts WHERE prof_id = ".$_GET['pro']."");
}
//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer && !$user_administrator && $update) {
$cid = $_GET['pro'];
	$redirect = "professional-details.php?pro=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//


//add Professional Contact
if (!$update && $_POST['prof_name']) {

  sqlsrv_query($connection,"INSERT INTO prof_contacts (prof_name, prof_street, prof_city, prof_country, prof_zip, prof_phone, prof_email, prof_website, prof_repname, prof_repphone, prof_repemail, prof_details, prof_lastedit, prof_updated) VALUES 

	(
		'".insert('prof_name')."',
		'".insert('prof_street')."',
		'".insert('prof_city')."',
		'".insert('prof_country')."',
		'".insert('prof_zip')."',
		'".insert('prof_phone')."',
		'".insert('prof_email')."',
		'".insert('prof_website')."',
		'".insert('prof_repname')."',
		'".insert('prof_repphone')."',
		'".insert('prof_repemail')."',
		'".insert('prof_details')."',
		'".$userid."',
		'".time()."'
	)

	");

$cid = mysql_insert_id();

	$redirect = "professional-details.php?pro=$cid";
	redirect('Professional Contact Added',$redirect);
}
//end add Professional Contact

//update Professional Contact


if ($update && $_POST &&  $_POST['prof_name']) {

sqlsrv_query($connection,"UPDATE prof_contacts SET

	prof_name = '".insert('prof_name')."',
	prof_street = '".insert('prof_street')."',
	prof_city = '".insert('prof_city')."',
	prof_country = '".insert('prof_country')."',
	prof_zip = '".insert('prof_zip')."',
	prof_phone = '".insert('prof_phone')."',
	prof_email = '".insert('prof_email')."',
	prof_website = '".insert('prof_website')."',
	prof_repname = '".insert('prof_repname')."',
	prof_repphone = '".insert('prof_repphone')."',
	prof_repemail = '".insert('prof_repemail')."',
	prof_details = '".insert('prof_details')."',
	prof_updated = '".time()."',
	prof_lastedit = '".$userid."'

WHERE prof_id = ".$_GET['pro']."
");
	$pid = $_GET['id'];

//

	$cid = $_GET['pro'];
	$redirect = "professional-details.php?pro=$cid";

	redirect('Professional Contact Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Professional Contact"; } ?></title>
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
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Professional Contact </h2>
    <p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td>Name<br />
                        <input name="prof_name" type="text" id="prof_name" value="<?php echo $row_professional['prof_name']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Street<br />
                        <input name="prof_street" type="text" id="prof_street" value="<?php echo $row_professional['prof_street']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>City<br />
                        <input name="prof_city" type="text" id="prof_city" value="<?php echo $row_professional['prof_city']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Country<br />
            <select id="prof_country" name="prof_country">
                      <option value="">Select a Country...</option>
							<?php foreach ($country_list as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php selected($key,$row_professional['prof_country']); ?>><?php echo $value; ?></option>
							<?php } ?>       
                        </select></td>
		</tr>
		<tr>
		<td>Postcode<br />
                        <input name="prof_zip" type="text" id="prof_zip" value="<?php echo $row_professional['prof_zip']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Main Phone<br />
                        <input name="prof_phone" type="text" id="prof_phone" value="<?php echo $row_professional['prof_phone']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Main Email<br />
                        <input name="prof_email" type="text" id="prof_email" value="<?php echo $row_professional['prof_email']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Website<br />
                        <input name="prof_website" type="text" id="prof_website" value="<?php echo $row_professional['prof_website']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td><hr/>Representative<br />
                        <input name="prof_repname" type="text" id="prof_repname" value="<?php echo $row_professional['prof_repname']; ?>" size="35" /></td>
		</td>
		</tr>
		</td>
		<td>Representative Phone<br />
                        <input name="prof_repphone" type="text" id="prof_repphone" value="<?php echo $row_professional['prof_repphone']; ?>" size="35" /></td>
		</td>
		</tr>
		</td>
		<td>Representative Email<br />
                        <input name="prof_repemail" type="text" id="prof_repemail" value="<?php echo $row_professional['prof_repemail']; ?>" size="35" /></td>
		</td>
		</tr>
             <td>Notes<br />
                    <textarea name="prof_details" cols="35" rows="4" id="prof_details"><?php echo $row_professional['prof_details']; ?></textarea>
				</td>
				</tr>
		<tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> Professional Contact" />
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
