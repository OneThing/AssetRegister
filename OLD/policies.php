<?php require_once('includes/config.php');
include('includes/sc-includes.php');
$pagetitle = 'Policies';

$update = 0;
if (isset($_GET['p'])) {
$update = 1;
}

//
record_set('client',"SELECT contact_first, contact_last FROM contacts WHERE contact_id = ".$_GET['id']."");
record_set('partner',"SELECT partner_name FROM partner WHERE partner_contact = ".$_GET['id']."");
record_set('policies',"SELECT * FROM policies WHERE policy_contact = -1");
record_set('companies_list',"SELECT company_id, company_name FROM companies ORDER BY company_name");
if ($update==1) {
record_set('policies',"SELECT * FROM policies WHERE policy_id = ".$_GET['p']."");
record_set('investments',"SELECT * FROM investments WHERE inv_policy = ".$_GET['p']." ORDER BY inv_date ASC");
}



//

//if not admin or writer and trying to edit
if (!$user_admin && !$user_writer &&!$user_administrator && $update) {
$cid = $_GET['id'];
	$redirect = "client-details.php?id=$cid";
	redirect('You don\'t have permission to access that page.',$redirect);
}
//


//investments
if ($_POST && ($_POST['inv_value'] || $_POST['Submit2'])) {

foreach ($_POST['investmentvalue'] as $key => $value) {
if ($value) {
$value = addslashes($value);
$date = strtotime(str_replace('/', '-', $_POST['investmentdate'][$key]));
//$date = str_replace('/', '-', $date);

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
	$cid = $_GET['id'];
	$pid = $_GET['p'];
	$redirect = "policies.php?id=$cid&p=$pid";
	redirect('Investment added.',$redirect);
}
//


//add policy
if (!$update && $_POST['policy_number']) {

$enddate = strtotime($_POST['endyear'] . '-' . $_POST['endmonth'] . '-' . $_POST['endday']);
$startdate = strtotime($_POST['startyear'] . '-' . $_POST['startmonth'] . '-' . $_POST['startday']);


  sqlsrv_query($connection,"INSERT INTO policies (policy_company, policy_owner, policy_lifeassured, policy_type, policy_number, policy_start, policy_end, policy_noend, policy_sumassured, policy_details, policy_contact) VALUES 

	(
		'".insert('policy_company')."',
		'".insert('policy_owner')."',
		'".insert('policy_lifeassured')."',
		'".insert('policy_type')."',
		'".insert('policy_number')."',
		'".$startdate."',
		'".$enddate."',
		'".insert('policy_noend')."',
		'".insert('policy_sumassured')."',
		'".insert('policy_details')."',
		'".$_GET['id']."'
	)

	");
	$pid = mysql_insert_id();
	
		sqlsrv_query($connection,"UPDATE contacts SET
	contact_updated = '".time()."',
	contact_lastedit = '".$userid."'
WHERE contact_id = ".$_GET['id']."
");

$cid = $_GET['id'];

if ($_POST &&  $_POST['Submit5']) {
	
	$redirect = "policies.php?id=$cid&p=$pid";
	redirect('Policy Added',$redirect);
	}
	else {
	$redirect = "client-details.php?id=$cid";
	redirect('Policy Added',$redirect);
	}
}
//end add policy

//update policy


if ($update && $_POST &&  $_POST['policy_number']) {

$enddate = strtotime($_POST['endyear'] . '-' . $_POST['endmonth'] . '-' . $_POST['endday']);
$startdate = strtotime($_POST['startyear'] . '-' . $_POST['startmonth'] . '-' . $_POST['startday']);

$check = $_POST['policy_noend'];

sqlsrv_query($connection,"UPDATE policies SET


	policy_company = '".insert('policy_company')."',
	policy_owner = '".insert('policy_owner')."',
	policy_lifeassured = '".insert('policy_lifeassured')."',
	policy_type = '".insert('policy_type')."',
	policy_number = '".insert('policy_number')."',
	policy_start = '".$startdate."',
	policy_end = '".$enddate."',
	policy_noend = '".$check."',
	policy_sumassured = '".insert('policy_sumassured')."',
	policy_details = '".insert('policy_details')."'

WHERE policy_id = ".$_GET['p']."
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

	redirect('Policy Updated',$redirect);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if ($update==0) { echo "Add Policy"; } ?></title>
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
    <h2><?php if ($update==1) { echo 'Update'; } else { echo 'Add'; } ?> Policies 
	<?php if ($update==1) { ?>
	<?php if ($user_admin || $user_administrator) { ?><a style="font-size:12px; font-weight:normal" href="delete.php?policy=<?php echo $row_policies['policy_id'] . "&ref=" . $row_policies['policy_number']; ?>&id=<?php echo $_GET['id']; ?>" onclick="javascript:return confirm('Are you sure?')">+ Delete policy  </a><?php } ?>
    <?php } ?>
	
	</h2>
    <p>&nbsp;</p>
    <form action="" method="POST" enctype="multipart/form-data" name="form1" id="form1">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td>Policy Owner<br />
			<select id="policy_owner" name="policy_owner">
			<option value=""><?php echo $row_client['contact_first'] . ' ' . $row_client['contact_last'] ; ?></option>
			<?php if ($row_partner['partner_name']) { ?><option value="1" <?php selected ($row_policies['policy_owner'],'1'); ?>>
			<?php echo $row_partner['partner_name']; ?></option><?php } ?>
		</select>
		</td>
		</tr>
		
		<tr>
		<td>Company<br />
			<select id="policy_company" name="policy_company">
			<option value="">Select a Company...</option>
		<?php do { ?>
		
		<option value="<?php echo $row_companies_list['company_name']; ?>" <?php selected ($row_companies_list['company_name'],$row_policies['policy_company']); ?>>
<?php echo $row_companies_list['company_name']; ?></option>
	<?php } while ($row_companies_list = sqlsrv_fetch_array($companies_list)); ?>
		</select>
		</td>
		</tr>
		
		
		<!--<tr>
		<td>Company<br />
                        <select id="policy_company" name="policy_company">
						<option value="">Select a Company...</option>
						<?php foreach ($company_list as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_policies['policy_company']); ?>><?php echo $value; ?></option>
						<?php } ?>
		</select></td>
		
		</tr>
		<tr> -->
		<td>Life Assured<br />
                        <select id="policy_lifeassured" name="policy_lifeassured">
						<option value="**Not Selected**">Choose an option...</option>
						<?php foreach ($policy_life as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_policies['policy_lifeassured']); ?>><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		</tr>
		<tr>
		<td>Policy Type<br />
                        <select id="policy_type" name="policy_type">
						<option value="**Not Selected**">Select a Policy Type...</option>
						<?php foreach ($policy_list as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_policies['policy_type']); ?>><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		</tr>
		
		<tr>
		<td>Policy Number<br/>
                    <input name="policy_number" type="text" id="policy_number" value="<?php echo $row_policies['policy_number']; ?>" size="45" /></td>
        </tr>
		
		<tr>
		<td>Policy Start Date<br/>
		<?php if ($update==1) { 
		$datestart = $row_policies['policy_start'];
		echo date_picker("start", $datestart);
		}
		else {
		echo date_picker("start");
		}
		?>
		</td>
		</tr>
		
		<tr>
		<td>Policy End Date<br/>
		<?php if ($update==1) { 
		$dateend = $row_policies['policy_end'];
		echo date_picker("end", $dateend);
		}
		else {
		echo date_picker("end");
		}
		?>
		No end date: <input type="checkbox" name="policy_noend" value="1"<?php checked('1',$row_policies['policy_noend']); ?>/>

		</td>
        </tr>
		</table>
		<br/>
		<hr/>
		<br/>
		
		<?php if (isset($_GET['p'])) { ?>
		<table>
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
	<h2>Investments </h2>
	</br>
		  <table>
		<tr>
		<th>Value</th>
		<th>Date</th>
		<th>Type</th>
		<th>Frequency</th>
		<th></th>
		</tr>
		<?php do { ?>
	<tr>
		
		<td><input name="investmentvalue[<?php echo $row_investments['inv_id']; ?>]" id="investmentvalue[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo $row_investments['inv_value']; ?>" size="15" /></td>
		<td><input name="investmentdate[<?php echo $row_investments['inv_id']; ?>]" id="investmentdate[<?php echo $row_investments['inv_id']; ?>]" value="<?php echo date('d/m/Y', $row_investments['inv_date']); ?>" class="required validate-date-au" size="15" /></td>
		<td>
                        <select id="investmenttype[<?php echo $row_investments['inv_id']; ?>]" name="investmenttype[<?php echo $row_investments['inv_id']; ?>]">
						<?php foreach ($invest_list as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_investments['inv_type']); ?>><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		<td>
                        <select id="investmentfreq[<?php echo $row_investments['inv_id']; ?>]" name="investmentfreq[<?php echo $row_investments['inv_id']; ?>]">
						<?php foreach ($invest_freq as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php selected($key,$row_investments['inv_frequency']); ?>><?php echo $value; ?></option>
						<?php } ?>
        </select></td>
		<td><?php if ($user_admin || $user_administrator) { ?> <a href="delete.php?investment=<?php echo $row_investments['inv_id'] . '&ref=' . $row_investments['inv_value']. '-'. date('d/m/Y', $row_investments['inv_date']); ?>&p=<?php echo $_GET['p']; ?>&id=<?php echo $_GET['id']; ?>" onclick="javascript:return confirm('Are you sure?')">Delete</a><?php } ?></td>
	</tr>
	<?php } while ($row_investments = sqlsrv_fetch_array($investments)); ?>
	
		<tr><td/>
        <input name="Submit2" type="submit" id="Submit2" value="Update" /> 
		</td></tr>
		    </table>
			<br/>
			<hr/>
			<br/>
	<?php } ?>
    <?php } ?>
	<?php if (!isset($_GET['p'])) { ?>
	 <input type="submit" name="Submit5" value="Add an Investment" />
	 <hr/>
	<?php } ?>
	
		<table>		
		<tr>
		<td>Sum Assured<br/>
                    <input name="policy_sumassured" type="text" id="policy_sumassured" value="<?php echo $row_policies['policy_sumassured']; ?>" size="45" /></td>
        </tr>
		
		<tr>
		<td>Details<br/>
                    <textarea name="policy_details" cols="60" rows="3" id="policy_details"><?php echo $row_policies['policy_details']; ?></textarea></td>
        </tr>
		
        <tr>
          <td colspan="2"><p>
            <input type="submit" name="Submit3" value="<?php echo $update==1 ? 'Update' : 'Add'; ?> policy" <?php if (!isset($_GET['p'])) { ?>onclick="javascript:return confirm('Please Add an Investment before clicking Add Policy')"<?php } ?> />
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
