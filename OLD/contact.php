<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Contact';

$update = 0;
if (isset($_GET['id'])) {
$update = 1;
}

//
record_set('contact',"SELECT * FROM contacts WHERE contact_id = -1");
if ($update==1) {
record_set('contact',"SELECT * FROM contacts LEFT JOIN fields_assoc ON cfield_contact = contact_id WHERE contact_id = ".$_GET['id']."");
}
//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer && $update) {
$cid = $_GET['id'];
	$redirect = "contact-details.php?id=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//



//add contact

if (!$update && $_POST['contact_first']) {

  sqlsrv_query($connection,"INSERT INTO contacts (contact_first, contact_middle, contact_last, contact_title, contact_profile, contact_company, contact_street, contact_city, contact_country, contact_zip, contact_phone, contact_cell, contact_email, contact_web, contact_jobtitle, contact_companystreet, contact_companycity, contact_companycountry, contact_companyzip, contact_worktelephone, contact_workemail, contact_lastedit, contact_updated, contact_user, contact_type) VALUES 

	(
		'".insert('contact_first')."',
		'".insert('contact_middle')."',
		'".insert('contact_last')."',
		'".insert('contact_title')."',
		'".insert('contact_profile')."',
		'".insert('contact_company')."',
		'".insert('contact_street')."',
		'".insert('contact_city')."',
		'".insert('contact_country')."',
		'".insert('contact_zip')."',
		'".insert('contact_phone')."',
		'".insert('contact_cell')."',
		'".insert('contact_email')."',
		'".insert('contact_web')."',
		'".insert('contact_jobtitle')."',
		'".insert('contact_companystreet')."',
		'".insert('contact_companycity')."',
		'".insert('contact_companycountry')."',
		'".insert('contact_companyzip')."',
		'".insert('contact_worktelephone')."',
		'".insert('contact_workemail')."',
		'".$userid."',
		'".time()."',
		'".$userid."',
		'2'
	)

	");

$cid = mysql_insert_id();

//add extra fields
record_set('fields',"SELECT * FROM fields ORDER BY field_title ASC");
do {

	$fv = "";
	
	if ($_POST['contact_f_'].$row_fields['field_id']) {
		
		$fv = $_POST['contact_f_'.$row_fields['field_id']];
		
		if (!empty($fv)) {
		sqlsrv_query($connection,"INSERT INTO fields_assoc (cfield_field, cfield_contact, cfield_value) VALUES
			
			(
				'".$row_fields['field_id']."',
				'".$cid."',
				'".$fv."'
			)
		
		");
		}
	}

} while ($row_fields = sqlsrv_fetch_array($fields));
//end add extra fields

	$redirect = "contact-details.php?id=$cid";
	redirect('Contact Added',$redirect);
}
//end add contact

//update contact


if ($update && $_POST &&  $_POST['contact_first']) {

sqlsrv_query($connection,"UPDATE contacts SET

	contact_first = '".insert('contact_first')."',
	contact_middle = '".insert('contact_middle')."',
	contact_last = '".insert('contact_last')."',
	contact_title = '".insert('contact_title')."',
	contact_profile = '".insert('contact_profile')."',
	contact_company = '".insert('contact_company')."',
	contact_street = '".insert('contact_street')."',
	contact_city = '".insert('contact_city')."',
	contact_country = '".insert('contact_country')."',
	contact_zip = '".insert('contact_zip')."',
	contact_phone = '".insert('contact_phone')."',
	contact_cell = '".insert('contact_cell')."',
	contact_email = '".insert('contact_email')."',
	contact_web = '".insert('contact_web')."',
	contact_companystreet = '".insert('contact_companystreet')."',
	contact_companycity = '".insert('contact_companycity')."',
	contact_companycountry = '".insert('contact_companycountry')."',
	contact_companyzip = '".insert('contact_companyzip')."',
	contact_worktelephone = '".insert('contact_worktelephone')."',
	contact_workemail = '".insert('contact_workemail')."',
	contact_updated = '".time()."'

WHERE contact_id = ".$_GET['id']."
");

//add extra fields
sqlsrv_query($connection,"DELETE FROM fields_assoc WHERE cfield_contact = ".$_GET['id']."");
record_set('fields',"SELECT * FROM fields ORDER BY field_title ASC");
do {

	$fv = "";
	
	if ($_POST['contact_f_'].$row_fields['field_id']) {
		
		$fv = $_POST['contact_f_'.$row_fields['field_id']];
		
		if (!empty($fv)) {
		sqlsrv_query($connection,"INSERT INTO fields_assoc (cfield_field, cfield_contact, cfield_value) VALUES
			
			(
				'".$row_fields['field_id']."',
				'".$_GET['id']."',
				'".$fv."'
			)
		
		");
		}
	}

} while ($row_fields = sqlsrv_fetch_array($fields));
//end add extra fields

	$pid = $_GET['id'];



	$cid = $_GET['id'];
	$redirect = "contact-details.php?id=$cid";

	redirect('Contact Updated',$redirect);
}

//custom fields
record_set('fields',"SELECT * FROM fields ORDER BY field_title ASC");
//

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Contact"; } ?><?php echo $row_contact['contact_first']; ?> <?php echo $row_contact['contact_last']; ?></title>
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
<body <?php if ($row_contact['contact_state']) { ?>onload="showState('<?php echo $row_contact['contact_state']; ?>')"<?php } ?>>
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="leftcolumn">
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Contact </h2>
    <p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td>Title<br />
		<input name="contact_title" type="text" id="contact_title" value="<?php echo $row_contact['contact_title']; ?>" size="35" /></td>
          <td>First Name<br />
            <input name="contact_first" type="text" class="required" id="contact_first" value="<?php echo $row_contact['contact_first']; ?>" size="35" /></td>
          </tr>
		  <tr>
		  <td>Middle Name<br />
            <input name="contact_middle" type="text" id="contact_middle" value="<?php echo $row_contact['contact_middle']; ?>" size="35" /></td>
		  <td>Last Name<br />
                <input name="contact_last" type="text" class="required" id="contact_last" value="<?php echo $row_contact['contact_last']; ?>" size="35" />
            </p></td>
        </tr>
        <tr>
          <td colspan="2"><hr />
         <!--<?php if ($update!=1) { ?>   <p><a href="#" onclick="new Effect.toggle('morecontact', 'slide'); return false;">+Add more contact information </a></p>
         <br />
         <?php } ?>-->
		 <br />
<div id="morecontact">
            <table  width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
			  <h2>Personal Details</h2>
                <td>Street<br />
                    <input name="contact_street" type="text" id="contact_street" value="<?php echo $row_contact['contact_street']; ?>" size="35" /></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3">Country<br />
                        <select id="contact_country" name="contact_country">
                      <option value="">Select a Country...</option>
<?php foreach ($country_list as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php selected($key,$row_contact['contact_country']); ?>><?php echo $value; ?></option>
<?php } ?>

       
                        </select></td>
                      </tr>
                    <tr>
                      <td width="39%">City<br />
                          <input name="contact_city" type="text" id="contact_city" value="<?php echo $row_contact['contact_city']; ?>" size="35" /></td>
                      <td width="27%" valign="top"></td>
                      <td width="34%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Postal Code <br />
                    <input name="contact_zip" type="text" id="contact_zip" value="<?php echo $row_contact['contact_zip']; ?>" size="10" /></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Phone<br />
                          <input name="contact_phone" type="text" id="contact_phone" value="<?php echo $row_contact['contact_phone']; ?>" size="35" /></td>
                      <td>Mobile<br />
                          <input name="contact_cell" type="text" id="contact_cell" value="<?php echo $row_contact['contact_cell']; ?>" size="35" /></td>
                    </tr>
					<tr>
          <td colspan="2">Personal Email <br />
            <input name="contact_email" type="text" id="contact_email" value="<?php echo $row_contact['contact_email']; ?>" size="35" /></td>
        </tr>
                </table></td>
              </tr>
			  <tr>
                <td>Background/Profile<br />
                    <textarea name="contact_profile" cols="35" rows="3" id="contact_profile"><?php echo $row_contact['contact_profile']; ?></textarea>
				</td>
				</tr>
				<br />

			</td>
              </tr>
            </table>  
</div>   
<br/>
<hr />

<?php if ($update!=1) { ?>   <p><a href="#" onclick="new Effect.toggle('extracontact', 'slide'); return false;">+Add employer contact information </a></p>
         <br />
         <?php } ?>

<div id="extracontact"<?php if ($update!=1) { echo ' style="display:none"'; } ?>>
            <table  width="100%" border="0" cellspacing="0" cellpadding="0">
              <h2>Employer Details</h2><br/>
			  <tr>
          <td width="25%">Company<br />
            <input name="contact_company" type="text" id="contact_company" value="<?php echo $row_contact['contact_company']; ?>" size="35" /></td>
		    <td width="70%">Position<br />
            <input name="contact_jobtitle" type="text" id="contact_jobtitle" value="<?php echo $row_contact['contact_jobtitle']; ?>" size="35" /></td>
		     </tr>
				<tr>
                <td>Street<br />
                    <input name="contact_companystreet" type="text" id="contact_companystreet" value="<?php echo $row_contact['contact_companystreet']; ?>" size="35" /></td>
              </tr>
              <tr>
                <td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="3">Country<br />
                        <select id="contact_companycountry" name="contact_companycountry">

<?php foreach ($country_list as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php selected($key,$row_contact['contact_companycountry']); ?>><?php echo $value; ?></option>
<?php } ?>

       
                        </select></td>
                      </tr>
                    <tr>
                      <td width="39%">City<br />
                          <input name="contact_companycity" type="text" id="contact_companycity" value="<?php echo $row_contact['contact_companycity']; ?>" size="35" /></td>
                      <td width="27%" valign="top"></td>
                      <td width="34%">&nbsp;</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Postal Code <br />
                    <input name="contact_companyzip" type="text" id="contact_companyzip" value="<?php echo $row_contact['contact_companyzip']; ?>" size="10" /></td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>Phone<br />
                          <input name="contact_worktelephone" type="text" id="contact_worktelephone" value="<?php echo $row_contact['contact_worktelephone']; ?>" size="35" /></td>
                      <tr />
					  <tr>
					  <td>Email<br />
                          <input name="contact_workemail" type="text" id="contact_workemail" value="<?php echo $row_contact['contact_workemail']; ?>" size="35" /></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td>Website<br />
                    <input name="contact_web" type="text" id="contact_web" value="<?php echo $row_contact['contact_web']; ?>" size="35" /></td>
              </tr>
            </table>  
</div>          


          <p>&nbsp;</p></td>
        </tr>
		<tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> contact" />
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