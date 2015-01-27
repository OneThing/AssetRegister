<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Companies';

$update = 0;
if (isset($_GET['com'])) {
$update = 1;
}

record_set('companies',"SELECT * FROM companies WHERE company_name = -1");
if ($update==1) {
record_set('companies',"SELECT * FROM companies WHERE company_id = ".$_GET['com']."");
}
//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer && !$user_administrator && $update) {
$cid = $_GET['com'];
	$redirect = "company-details.php?id=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//


//add company
if (!$update && $_POST['company_name']) {

  sqlsrv_query($connection,"INSERT INTO companies (company_name, company_url, company_agency, company_street, company_city, company_country, company_zip, company_sales, company_salesphone, company_admin, company_adminphone, company_details, company_lastedit, company_updated) VALUES 

	(
		'".insert('company_name')."',
		'".insert('company_url')."',
		'".insert('company_agency')."',
		'".insert('company_street')."',
		'".insert('company_city')."',
		'".insert('company_country')."',
		'".insert('company_zip')."',
		'".insert('company_sales')."',
		'".insert('company_salesphone')."',
		'".insert('company_admin')."',
		'".insert('company_adminphone')."',
		'".insert('company_details')."',
		'".$userid."',
		'".time()."'
	)

	");

$cid = mysql_insert_id();

	$redirect = "company-details.php?com=$cid";
	redirect('Company Added',$redirect);
}
//end add Company

//update Company


if ($update && $_POST &&  $_POST['company_name']) {

sqlsrv_query($connection,"UPDATE companies SET

	company_name = '".insert('company_name')."',
	company_url = '".insert('company_url')."',
	company_agency = '".insert('company_agency')."',
	company_street = '".insert('company_street')."',
	company_city = '".insert('company_city')."',
	company_country = '".insert('company_country')."',
	company_zip = '".insert('company_zip')."',
	company_sales = '".insert('company_sales')."',
	company_salesphone = '".insert('company_salesphone')."',
	company_admin = '".insert('company_admin')."',
	company_adminphone = '".insert('company_adminphone')."',
	company_details = '".insert('company_details')."',
	company_lastedit = '".$userid."',
	company_updated = '".time()."'

WHERE company_id = ".$_GET['com']."
");
	$pid = $_GET['id'];

//

	$cid = $_GET['com'];
	$redirect = "company-details.php?com=$cid";

	redirect('Company Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Company"; } ?></title>
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
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Companies </h2>
    <p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td>Company Name<br />
                        <input name="company_name" type="text" id="company_name" value="<?php echo $row_companies['company_name']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Adviser Website<br />
                        <input name="company_url" type="text" id="company_url" value="<?php echo $row_companies['company_url']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Street<br />
                        <input name="company_street" type="text" id="company_street" value="<?php echo $row_companies['company_street']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>City<br />
                        <input name="company_city" type="text" id="company_city" value="<?php echo $row_companies['company_city']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Country<br />
            <select id="company_country" name="company_country">
                      <option value="">Select a Country...</option>
							<?php foreach ($country_list as $key => $value) { ?>
                          <option value="<?php echo $key; ?>" <?php selected($key,$row_companies['company_country']); ?>><?php echo $value; ?></option>
							<?php } ?>       
                        </select></td>
		</tr>
		<tr>
		<td>Postcode<br />
                        <input name="company_zip" type="text" id="company_zip" value="<?php echo $row_companies['company_zip']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Sales Consultant<br />
                        <input name="company_sales" type="text" id="company_sales" value="<?php echo $row_companies['company_sales']; ?>" size="35" /></td>
		</td>
		<td>Sales Phone Number<br />
                        <input name="company_salesphone" type="text" id="company_salesphone" value="<?php echo $row_companies['company_salesphone']; ?>" size="35" /></td>
		</td>
		</tr>
		<tr>
		<td>Admin Support<br />
                        <input name="company_admin" type="text" id="company_admin" value="<?php echo $row_companies['company_admin']; ?>" size="35" /></td>
		</td>
		<td>Admin Phone Number<br />
                        <input name="company_adminphone" type="text" id="company_adminphone" value="<?php echo $row_companies['company_adminphone']; ?>" size="35" /></td>
		</td>
		</tr>
             <td>Notes<br />
                    <textarea name="company_details" cols="35" rows="4" id="company_details"><?php echo $row_companies['company_details']; ?></textarea>
				</td>
				</tr>
		<tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit2" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> company" />
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
