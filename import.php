<?php require_once('includes/config.php'); 
ob_start();

include('includes/sc-includes.php');
$pagetitle = 'Import Data';

if (!empty($_GET['csv']) && $_GET['csv'] == 'import') { 

$row = 1;
$handle = fopen ($_FILES['csv']['tmp_name'],"r");

	$cf = array();

while ($data = fgetcsv($handle, 1000, ",")) {



$checkc = sqlsrv_has_rows(sqlsrv_query($connection,"SELECT * FROM assets WHERE asset_id = ".$data[0].""));

	if ($checkc > 0) {

sqlsrv_query($connection,"UPDATE assets SET

	contact_first = '".addslashes($data[1])."',
	contact_last = '".addslashes($data[2])."',
	contact_title = '".addslashes($data[3])."',
	contact_company = '".addslashes($data[4])."',
	contact_street = '".addslashes($data[5])."',
	contact_city = '".addslashes($data[6])."',
	contact_state = '".addslashes($data[7])."',
	contact_zip = '".addslashes($data[8])."',
	contact_country = '".addslashes($data[9])."',
	contact_email = '".addslashes($data[10])."',
	contact_phone = '".addslashes($data[11])."',
	contact_cell = '".addslashes($data[12])."',
	contact_web = '".addslashes($data[13])."',
	contact_profile = '".addslashes($data[14])."'

WHERE asset_id = ".$data['0']."
");

}
//

else { 


if ($row > 1) {

//INSERT NEW RECORDS
sqlsrv_query($connection,"INSERT INTO assets (asset_user, asset_company, asset_department, asset_device, asset_model, asset_serial, asset_tag, asset_mobile, asset_sim, asset_setup, asset_checked, asset_issued, asset_status, asset_purchased, asset_support, asset_warrenty, asset_returned, asset_notes) VALUES
(
	   '".addslashes($data[0])."',
	   '".addslashes($data[1])."',
	   '".addslashes($data[2])."',
	   '".addslashes($data[3])."',
	   '".addslashes($data[4])."',
	   '".addslashes($data[5])."',
	   '".addslashes($data[6])."',
	   '".addslashes($data[7])."',
	   '".addslashes($data[8])."',
	   '".addslashes($data[9])."',
	   '".addslashes($data[10])."',
	   '".addslashes(strtotime(str_replace('/', '-', $data[11])))."',
	   '".addslashes($data[12])."',
	   '".addslashes(strtotime(str_replace('/', '-', $data[13])))."',
	   '".addslashes(strtotime(str_replace('/', '-', $data[14])))."',
	   '".addslashes(strtotime(str_replace('/', '-', $data[15])))."',
	   '".addslashes(strtotime(str_replace('/', '-', $data[16])))."',
	   '".addslashes($data[17])."'
)

");
}
$row++;
}

}


redirect('Data imported', "import.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $pagetitle; ?>s</title>
<script src="includes/lib/prototype.js" type="text/javascript"></script>
<script src="includes/src/effects.js" type="text/javascript"></script>
<script src="includes/validation.js" type="text/javascript"></script>
<script src="includes/src/scriptaculous.js" type="text/javascript"></script>

<link href="includes/style.css" rel="stylesheet" type="text/css" />
<link href="includes/scotcall.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php include('includes/header.php'); ?>
  
  <div class="container">
  <div class="leftcolumn">
    <h2> Import Data </h2>
    <table width="540" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td colspan="2"><form name="form1" id="form1" enctype="multipart/form-data" method="post" action="?csv=import">
            <input name="csv" type="file" id="csv" size="40" />
            <br />
            <input name="submit" type="submit" value="Import File" />
            <a href="csv.php"></a> 
        </form></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
    </table>    
    <p>&nbsp; </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <?php include('includes/right-column.php'); ?>
  <br clear="all" />
</div>

<?php include('includes/footer.php'); ?>

</body>
</html>
